<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\Car;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use App\Models\Bid;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AuctionEndedNotification;
;
class AuctionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensure user is authenticated
    }

    public function index2(Request $request)
    {
        $now = now();
    
        // Update auctions to "ongoing" if their start time has passed
        Auction::where('start_time', '<=', $now)
            ->where('status', 'pending')
            ->update(['status' => 'ongoing']);
    
        // Base query with eager loading
        $query = Auction::with(['car.user']);
    
        // Filter by car name if provided
        if ($request->has('name') && !empty($request->name)) {
            $query->whereHas('car', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }
    
        // Get filtered auctions
        $auctions = $query->get();
    
        // Get all unique car names for the filter dropdown with auction counts
        $carNames = Car::select('name')
            ->distinct()
            ->get();
    
        // Prepare a name count array
        $nameCounts = [];
        foreach ($carNames as $car) {
            $nameCounts[$car->name] = Auction::whereHas('car', function ($q) use ($car) {
                $q->where('name', $car->name);
            })->count();
        }

        return view('auctions.index2', compact('auctions', 'carNames', 'nameCounts'));
    }
    
    

    public function create()
    {
        return view('auctions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $now = now();
        $request->validate([
            'name' => 'required|string',
            'brand' => 'required|string',
            'model' => 'required|string',
            'body_type' => 'required|string',
            'door_count' => 'required|integer',
            'color' => 'required|string',
            'mileage' => 'required|integer',
            'power' => 'required|integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate each image
            'description' => 'nullable|string',
            'start_price' => 'required|numeric',
            'start_time' => 'required|date',
            'finish_time' => 'required|date|after:start_time',
        ]);

        // Handling image upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('car_images', 'public'); // Save in storage/app/public/car_images
                $imagePaths[] = $path;
            }
        }

        $car = Car::create([
            'vendor_id' => auth()->id(),
            'name' => $request->name,
            'brand' => $request->brand,
            'model' => $request->model,
            'body_type' => $request->body_type,
            'door_count' => $request->door_count,
            'color' => $request->color,
            'mileage' => $request->mileage,
            'power' => $request->power,
            'description' => $request->description,
            'images' => json_encode($imagePaths), // Store paths as JSON
        ]);

        // Create Auction
        Auction::create([
            'car_id' => $car->id,
            'start_price' => $request->start_price,
            'start_time' => $request->start_time,
            'finish_time' => $request->finish_time,
            'status' => 'pending', // Set initial status to 'pending'
        ]);

        Log::info('Auction Start Time: ' . $request->start_time);
        return redirect()->route('auctions.my')->with('success', 'Auction created successfully!');
    }
    public function showCarDetails($id)
    {
        $auction = Auction::with('car.user')->findOrFail($id);
    
        // Check if the auction has a car and user associated
        if (!$auction->car || !$auction->car->user) {
            return redirect()->route('auctions.index')->with('error', 'Car or Vendor details not found.');
        }
    
        // Fetch the last bid for the auction
        $lastBid = $auction->bids()->latest()->first(); // Assuming a 'bids' relationship exists
        $currentprice= $auction->start_price + $auction->highest_bid;
      
        return view('auctions.details', compact('auction', 'lastBid','currentprice'));
    }
    



   
    
    public function endAuction($auctionId)
{
    // Find the auction by ID
    $auction = Auction::find($auctionId);
    if (!$auction) {
        return response()->json(['error' => 'Auction not found'], 404);
    }

    // Check if the auction is already completed
    if ($auction->status === 'completed') {
        return redirect()->route('auctions.index')->with('info', 'Auction has already ended.');
    }

    // Log auction status
    Log::info('Auction found', ['auctionId' => $auctionId]);

    // Get the highest bid for the auction
    $highestBid = Bid::where('auction_id', $auctionId)->orderBy('bid_amount', 'desc')->first();

    // If no bid exists, update auction and return early
    if (!$highestBid) {
        // Update auction status with the start price and no winner
        $auction->update([
            'status' => 'completed',
            'highest_bid' => $auction->start_price,
            'winner_id' => null
        ]);
        Log::info('No bids found, auction ended without a winner', ['auctionId' => $auctionId]);
        return redirect()->route('auctions.index')->with('success', 'Auction ended with no bids.');
    }

    // Determine the winner (if any)
    $winner = $highestBid ? $highestBid->user : null;

    // Update the auction to completed status and set the highest bid and winner
    $auction->update([
        'highest_bid' => $highestBid->bid_amount,
        'winner_id' => $winner ? $winner->id : null,
        'status' => 'completed',
    ]);

    Log::info('Auction status updated to completed', [
        'auctionId' => $auctionId, 
        'winner' => $winner ? $winner->id : 'None',
        'highestBid' => $highestBid->bid_amount
    ]);

    // Get all bidders excluding the winner
    $bidders = Bid::where('auction_id', $auctionId)
        ->where('user_id', '!=', $winner ? $winner->id : null)
        ->distinct('user_id')
        ->pluck('user_id');

    // Notify the winner (if any)
    if ($winner) {
        Log::info('Notifying winner', ['userId' => $winner->id]);
        Notification::send($winner, new AuctionEndedNotification($auction, 'win'));
    }

    // Notify the losing bidders
    if ($bidders->isNotEmpty()) {
        foreach ($bidders as $userId) {
            $user = User::find($userId);
            if ($user) {
                Log::info('Notifying losing bidder', ['userId' => $userId]);
                Notification::send($user, new AuctionEndedNotification($auction, 'lose'));
            }
        }
    }

    // Notify the vendor (auction owner)
    if ($auction->user) {
        Log::info('Notifying vendor', ['userId' => $auction->user->id]);
        Notification::send($auction->user, new AuctionEndedNotification($auction, 'vendor'));
    }

    // Return success response
    return redirect()->route('auctions.index')->with('success', 'Auction ended successfully! Notifications sent.');
}


    
    // Other methods...

    // app/Http/Controllers/AuctionController.php

    public function index()
    {
        $auctions = Auction::all(); // Fetch all auctions
        return view('auctions.index', compact('auctions'));
    }
    

    public function show($id)
    {
        $auction = Auction::with('car.user')->findOrFail($id); // Fetch the auction by ID
        return view('auctions.show', compact('auction')); // Pass the auction to the view
    }

    public function edit($id)
    {
        $auction = Auction::with('car.user')->findOrFail($id); // Fetch the auction and its related car and user data
    
        $user = Auth::user(); // Get the authenticated user
    
        // Check if the user is an admin or the vendor who created the auction
        if ($user->role !== 'admin' && $user->id !== $auction->car->user->id) {
            return redirect()->route('auctions.my')->with('error', 'You are not authorized to edit this auction.');
        }
    
        return view('auctions.edit', compact('auction')); // Pass the auction to the edit view
    }
    


    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'start_price' => 'required|numeric',
            'start_time' => 'required|date',
            'finish_time' => 'required|date|after:start_time',
            // Add other validation rules as needed
        ]);

        $auction = Auction::findOrFail($id); // Fetch the auction to update
        $auction->update($request->all()); // Update the auction
        return redirect()->route('auctions.my')->with('success', 'Auction updated successfully.'); // Redirect to the auction list
    }

    public function destroy($id): RedirectResponse
    {
        $auction = Auction::findOrFail($id); // Fetch the auction to delete
        $auction->delete(); // Delete the auction
        return redirect()->route('auctions.my')->with('success', 'Auction deleted successfully.'); // Redirect to the auction list
    }
    ////display the auction created by the vendor ////////////////////////////////////////
    public function myAuctions()
{
    $auctions = Auction::whereHas('car', function ($query) {
        $query->where('vendor_id', auth()->id());
    })->with('car')->get();

    // Group auctions by status
    $groupedAuctions = $auctions->groupBy('status');

    return view('auctions.my_auctions', compact('groupedAuctions'));
}
//////////////////////////////display the auction bidded by the user /////////////////////////////////
public function myBids()
{
    // Retrieve auctions where the user has placed bids
    $auctions = Auction::whereHas('bids', function ($query) {
        $query->where('user_id', auth()->id()); // Filter bids by the logged-in user
    })->with(['car', 'bids' => function ($query) {
        $query->where('user_id', auth()->id()); // Include only the user's bids
    }])->get();

    return view('auctions.my_bids', compact('auctions'));
}

public function updateAuctionStatuses()
{
    $now = now();

    // Update auctions to "ongoing" if their start time has passed
    Auction::where('start_time', '<=', $now)
        ->where('status', 'pending')
        ->update(['status' => 'ongoing']);

    // Update auctions to "completed" if their finish time has passed
    Auction::where('finish_time', '<=', $now)
        ->where('status', 'ongoing')
        ->update(['status' => 'completed']);

    Log::info("Auction statuses updated successfully.");
}



}

