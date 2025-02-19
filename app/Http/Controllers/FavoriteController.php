<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;

class FavoriteController extends Controller
{
    // Add to favorites using session
    public function add($auctionId)
    {
        $favorites = session()->get('favorites', []);
        
        if (!in_array($auctionId, $favorites)) {
            $favorites[] = $auctionId;
            session()->put('favorites', $favorites);
        }

        return back()->with('success', 'Auction added to favorites!');
    }

    // Remove from favorites using session
    public function remove($auctionId)
    {
        $favorites = session()->get('favorites', []);
        
        if (($key = array_search($auctionId, $favorites)) !== false) {
            unset($favorites[$key]);
            session()->put('favorites', $favorites);
        }

        return back()->with('success', 'Auction removed from favorites!');
    }

    // Display favorite auctions
    public function index()
    {
        $favoriteIds = session()->get('favorites', []);
        
        // Get auctions based on stored session IDs
        $auctions = Auction::whereIn('id', $favoriteIds)->get();

        return view('favorite-view.favorite', compact('auctions'));
    }
}
