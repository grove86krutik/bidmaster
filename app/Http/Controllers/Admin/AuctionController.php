<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auction;
use Inertia\Inertia;
use App\Helpers\RedisHelper;

class AuctionController extends Controller
{
    public function index()
    {
        if(!($auctions = RedisHelper::cacheGet('auction_list'))){
            $auctions = Auction::latest()->get()->map(function ($auction) {
                return [
                    'id' => $auction->id,
                    'title' => $auction->title,
                    'description' => $auction->description,
                    'created_at' => $auction->created_at->diffForHumans()
                ];
            });
            RedisHelper::cacheSet('auction_list', $auctions, 60);
        }
        
        return Inertia::render('admin/auction/index', [
            'auctions' => $auctions
        ]);
    }

    public function create()
    {
        return Inertia::render('admin/auction/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => 'required'
        ]);
        Auction::create($request->all());
        return redirect()->route('admin.auction.index');
    }

    public function edit(Auction $auction)
    {
        return Inertia::render('admin/auction/edit', [
            'auction' => $auction
        ]);
    }

    public function update(Request $request, Auction $auction)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => 'required'
        ]);
        $auction->update($request->all());
        return redirect()->route('admin.auction.index');
    }

    public function destroy(Auction $auction)
    {
        $auction->delete();
        return redirect()->route('admin.auction.index');
    }
}
