<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        $products = Product::all();
            return view('buah.home', compact('products'));
    }

    public function shop()
    {
        $products = Product::all();
        return view('buah.shop', compact('products'));
    }

    public function showDetail()
    {
        $products = Product::all();
        return view('buah.shop-detail', compact('products'));
    }

    public function detail($id)
    {
        $detail = Product::find($id);
        return view('buah.shop-detail', compact('detail'));
    }

    public function cart()
    {
        // $products = Product::all();
        return view('buah.cart');
    }

    public function search(Request $request)
    {
        $category = $request->query('category');
        if ($category) {
            $products = Product::where('category', $category)->get();
        } else {
            $products = Product::all();
        }

        return view('buah.shop', compact('products'));
    }


}
