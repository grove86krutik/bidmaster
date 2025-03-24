<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\Seller;
use Inertia\Inertia;
use App\Services\RedisService;

class AuctionController extends Controller
{
    protected $redisService;

    public function __construct(RedisService $redisService)
    {
        $this->redisService = $redisService;
    }

    public function index()
    {
        if(!($auctions = $this->redisService->cacheGet('auction_list'))){
            $auctions = Auction::latest()->get()->map(function ($auction) {
                return [
                    'id' => $auction->id,
                    'title' => $auction->title,
                    'description' => $auction->description,
                    'created_at' => $auction->created_at->diffForHumans()
                ];
            });
            $this->redisService->cacheSet('auction_list', $auctions, 60);
        }
        
        return Inertia::render('admin/auction/index', [
            'auctions' => $auctions
        ]);
    }

    public function create()
    {
        $sellers = Seller::all(['id', 'name']);
        return Inertia::render('admin/auction/create', [
            'sellers' => $sellers
        ]);
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
        $this->redisService->cacheForget('auction_list');
        return redirect()->route('admin.auction.index');
    }
}
