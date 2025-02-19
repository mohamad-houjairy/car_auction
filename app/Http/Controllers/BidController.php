<?php
// app/Http/Controllers/BidController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class BidController extends Controller
{
    public function index($auctionId)
    {
        $auction = Auction::with('car')->findOrFail($auctionId);
        
        // Get the highest bid, or start price if no bids exist
        $highestBid = Bid::where('auction_id', $auctionId)->max('bid_amount') ?? 0;
    
        // Get the last 3 bids placed for the auction
        $lastBids = Bid::where('auction_id', $auctionId)
                       ->latest()  // This orders by the latest bid
                       ->take(4)   // Get the last 4 bids
                       ->get();    // Fetch the bids
    
        // Calculate the updated price
        $updated_price = $auction->highest_bid + $auction->start_price;
    
        return view('bids.index', compact('auction', 'highestBid', 'updated_price', 'lastBids'));
    }
    
    
    
    public function store(Request $request, $auctionId)
    {
        // Validate the bid amount to be >= 250
        $request->validate([
            'bid_amount' => 'required|numeric|min:250', // Minimum bid is 250
        ]);
        
        // Find the auction by ID
        $auction = Auction::findOrFail($auctionId);
        
        // Get the current auction price. If no bids have been placed, use the starting price.
        $currentPrice = $auction->highest_bid ?? $auction->start_price;
         // Get the most recent bid in the auction
    $recentBid = Bid::where('auction_id', $auctionId)->latest()->first();
    if (!$recentBid) {
        // Create a new bid record
        Bid::create([
            'auction_id' => $auctionId,
            'user_id' => auth()->id(),
            'bid_amount' => $request->bid_amount,
        ]);

        // Update the auction's highest bid with the new bid
        $auction->update([
            'highest_bid' => $request->bid_amount,
        ]);

        return redirect()->route('bids.index', $auctionId)->with('success', 'Your bid of $' . number_format($request->bid_amount, 2) . ' has been placed!');
    }

    // Check if the current user placed the recent bid
    if ($recentBid->user_id == auth()->id()) {
        // If the user placed the recent bid, reject this new bid with a "Bid failed" message
        return redirect()->route('bids.index', $auctionId)->with('error', 'You cannot place another bid in this auction until another user has placed a bid.');
    }
        // Define a threshold multiplier (e.g., 1.5 for 50% higher)
        $lastBid = Bid::where('auction_id', $auctionId)->latest()->first();

        // If there is no last bid, use the auction's starting price
        $lastBidAmount = $lastBid ? $lastBid->bid_amount : $auction->start_price;
        
        // Define a threshold for the new bid to be reasonable compared to the last bid
        $thresholdMultiplier = 1.5; // For example, 50% higher than the last bid
    
        // Check if the new bid is less than or equal to the last bid, or too much higher than the last bid
        if ( $request->bid_amount > $lastBidAmount * $thresholdMultiplier) {
            // If the bid is too low or too high, reject it with an error message
            return redirect()->route('bids.index', $auctionId)->with('error', 'Your bid is either too low or too high compared to the last bid. Please place a more reasonable bid.');
        }
        
        // Calculate the new price (sum of the current price and the new bid amount)
        $newPrice = $currentPrice + $request->bid_amount;
        
        // Create a new bid record
        Bid::create([
            'auction_id' => $auctionId,
            'user_id' => auth()->id(),
            'bid_amount' => $request->bid_amount,
        ]);
        
        // Update the auction's price with the new total price
        $auction->update([
            'highest_bid' => $newPrice, // Update with the new total price
        ]);







        $timeSinceLastBid = $lastBid ? now()->diffInSeconds($lastBid->created_at) : 9999;
   $totalBidsByUser = Bid::where('user_id', auth()->id())->count();

    // Prepare data for AI detection
    $dataForModel = json_encode([
        'bid_amount' => (int) $request->bid_amount,  
        'time_since_last_bid' => (int) $timeSinceLastBid, 
        'total_bids_by_user' => (int) $totalBidsByUser
    ]);

    // Construct Python command
    $pythonPath = "C:\Users\LENOVO\AppData\Local\Programs\Python\Python313\python.exe ";
    $scriptPath = base_path('ai/check_fake_bid.py');

    $command = "\"{$pythonPath}\" \"{$scriptPath}\" " . escapeshellarg($dataForModel);

    // Capture both output and error
    $output = shell_exec($command . " 2>&1");

    // Log command and output for debugging
    Log::info("AI Command Executed: " . $command);
    Log::info("AI Output: " . $output);

    // Check if the prediction indicates a fake bid
    if (trim($output) == "1") {
        return redirect()->back()->with('error', 'You cannot place another bid in this auction until another user has placed a bid.');
    }

    // Save valid bid
    Bid::create([
        'auction_id' => $auctionId,
        'user_id' => auth()->id(),
        'bid_amount' => $request->bid_amount,
    ]);

        
        // Redirect back to the auction's bid page with a success message
        return redirect()->route('bids.index', $auctionId)->with('success', 'Your bid of $' . number_format($request->bid_amount, 2) . ' has been placed!');
    }
    

//     public function store(Request $request, $auctionId)
// {
//     // Validate bid amount
//     $request->validate([
//         'bid_amount' => 'required|numeric|min:250',
//     ]);

//     // Find the auction
//     $auction = Auction::findOrFail($auctionId);

//     // Get the highest bid (or start price if no bids exist)
//     $highestBid = Bid::where('auction_id', $auctionId)->max('bid_amount') ?? $auction->start_price;

//     // Get bid history for AI detection
//     $lastBid = Bid::where('auction_id', $auctionId)->where('user_id', auth()->id())->latest()->first();
//     $timeSinceLastBid = $lastBid ? now()->diffInSeconds($lastBid->created_at) : 9999;
//     $totalBidsByUser = Bid::where('user_id', auth()->id())->count();

//     // Prepare data for AI detection
//     $dataForModel = json_encode([
//         'bid_amount' => (int) $request->bid_amount,  
//         'time_since_last_bid' => (int) $timeSinceLastBid, 
//         'total_bids_by_user' => (int) $totalBidsByUser
//     ]);

//     // Construct Python command
//     $pythonPath = "C:\Users\LENOVO\AppData\Local\Programs\Python\Python313\python.exe ";
//     $scriptPath = base_path('ai/check_fake_bid.py');

//     $command = "\"{$pythonPath}\" \"{$scriptPath}\" " . escapeshellarg($dataForModel);

//     // Capture both output and error
//     $output = shell_exec($command . " 2>&1");

//     // Log command and output for debugging
//     Log::info("AI Command Executed: " . $command);
//     Log::info("AI Output: " . $output);

//     // Check if the prediction indicates a fake bid
//     if (trim($output) == "1") {
//         return redirect()->back()->with('error', '🚨 Fake bid detected! Your bid was rejected.');
//     }

//     // Save valid bid
//     Bid::create([
//         'auction_id' => $auctionId,
//         'user_id' => auth()->id(),
//         'bid_amount' => $request->bid_amount,
//     ]);

//     // Update auction's highest bid
//     $auction->update([
//         'highest_bid' => $request->bid_amount,
//     ]);

//     return redirect()->route('bids.index', $auctionId)
//         ->with('success', 'Your bid of $' . number_format($request->bid_amount, 2) . ' has been placed!');
// }


// public function store(Request $request, $auctionId)
// {
//     // Validate bid amount
//     $request->validate([
//         'bid_amount' => 'required|numeric|min:250',
//     ]);

//     // Find the auction
//     $auction = Auction::findOrFail($auctionId);

//     // Get the highest bid (or start price if no bids exist)
//     $highestBid = Bid::where('auction_id', $auctionId)->max('bid_amount') ?? $auction->start_price;

//     // Get bid history for AI detection
//     $lastBid = Bid::where('auction_id', $auctionId)->where('user_id', auth()->id())->latest()->first();
//     $timeSinceLastBid = $lastBid ? now()->diffInSeconds($lastBid->created_at) : 9999;
//     $totalBidsByUser = Bid::where('user_id', auth()->id())->count();

//     // Prepare JSON for Python input
//   // Convert data to properly formatted JSON
// // Convert data to properly formatted JSON
// $dataForModel = json_encode([
//     "bid_amount" => (int) $request->bid_amount,  
//     "time_since_last_bid" => (int) $timeSinceLastBid, 
//     "total_bids_by_user" => (int) $totalBidsByUser
// ]);

// // Escape the JSON string properly for command-line execution
// $escapedData = escapeshellarg($dataForModel);

// $pythonPath = "C:\\Users\\LENOVO\\AppData\\Local\\Programs\\Python\\Python313\\python.exe";
// $scriptPath = base_path('ai/check_fake_bid.py');

// // Wrap the escaped data in the command properly
// $command = "\"{$pythonPath}\" \"{$scriptPath}\" {$escapedData}";

// // Execute the command
// $output = shell_exec($command . " 2>&1");

// // Log command and output
// Log::info("AI Command Executed: " . $command);
// Log::info("AI Output: " . $output);
// Log::info("Data sent to Python: " . $dataForModel);



//     // Check if the prediction indicates a fake bid
//     if (trim($output) == "1") {
//         return redirect()->back()->with('error', '🚨 Fake bid detected! Your bid was rejected.');
//     }

//     // Save valid bid
//     Bid::create([
//         'auction_id' => $auctionId,
//         'user_id' => auth()->id(),
//         'bid_amount' => $request->bid_amount,
//     ]);

//     // Update auction's highest bid
//     $auction->update([
//         'highest_bid' => $request->bid_amount,
//     ]);

//     return redirect()->route('bids.index', $auctionId)
//         ->with('success', 'Your bid of $' . number_format($request->bid_amount, 2) . ' has been placed!');
// }

// public function store(Request $request, $auctionId)
// {
//     // Validate the bid amount to be at least 250
//     $request->validate([
//         'bid_amount' => 'required|numeric|min:250',
//     ]);

//     // Find the auction by ID
//     $auction = Auction::findOrFail($auctionId);

//     // Get the current auction price (use highest bid if exists, otherwise start price)
//     $currentPrice = $auction->highest_bid ?? $auction->start_price;

//     // Get bid history for AI detection
//     $lastBid = Bid::where('auction_id', $auctionId)->where('user_id', auth()->id())->latest()->first();
//     $timeSinceLastBid = $lastBid ? now()->diffInSeconds($lastBid->created_at) : 9999;
//     $totalBidsByUser = Bid::where('user_id', auth()->id())->count();

//     // Prepare data for AI detection
//     // Prepare data for AI detection (Ensure Proper JSON Encoding)
// $dataForModel = json_encode([
//     'bid_amount' => (int) $request->bid_amount,
//     'time_since_last_bid' => (int) $timeSinceLastBid,
//     'total_bids_by_user' => (int) $totalBidsByUser
// ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); // Prevents Laravel from escaping slashes

// // Construct Python command
// $pythonPath = "C:\Users\LENOVO\AppData\Local\Programs\Python\Python313\python.exe";
// $scriptPath = base_path('ai/check_fake_bid.py');

// // Escape JSON properly
// $command = "\"{$pythonPath}\" \"{$scriptPath}\" " . escapeshellarg($dataForModel);

// // Execute Python script
// $output = shell_exec($command . " 2>&1");

// // Log AI output for debugging
// Log::info("AI Command Executed: " . $command);
// Log::info("AI Output: " . $output);

//     // Check if the AI detected a fake bid (Output should be "1" for fake, "0" for real)
//     if (trim($output) == "1") {
//         return redirect()->back()->with('error', '🚨 Fake bid detected! Your bid was rejected.');
//     }

//     // Calculate the new price (sum of the current price and the new bid amount)
//     $newPrice = $currentPrice + $request->bid_amount;

//     // Save valid bid
//     Bid::create([
//         'auction_id' => $auctionId,
//         'user_id' => auth()->id(),
//         'bid_amount' => $request->bid_amount,
//     ]);

//     // Update auction's highest bid
//     $auction->update([
//         'highest_bid' => $newPrice,
//     ]);

//     // Redirect back to the auction bid page with success message
//     return redirect()->route('bids.index', $auctionId)
//         ->with('success', 'Your bid of $' . number_format($request->bid_amount, 2) . ' has been placed! The new auction price is $' . number_format($newPrice, 2));
// }


public function __construct()
{
    $this->middleware('auth');
}

}
