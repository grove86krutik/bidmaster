<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Seller;
use Inertia\Inertia;

class SellerController extends Controller
{
    public function index()
    {
        $sellers = Seller::latest()->get()->map(function ($seller) {
            return [
                'id' => $seller->id,
                'name' => $seller->name,
                'email' => $seller->email,
                'phone' => $seller->phone,
                'created_at' => $seller->created_at->diffForHumans()
            ];
        });

        return Inertia::render('admin/seller/index', [
            'sellers' => $sellers
        ]);
    }
    
    public function create()
    {
        return Inertia::render('admin/seller/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:sellers',
            'phone' => 'required',
            'password' => 'required|min:8',
        ]);
        $seller = Seller::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.seller.index');
    }

    public function destroy(Seller $seller)
    {
        $seller->delete();
        return redirect()->route('admin.seller.index');
    }
}
