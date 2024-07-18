<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addtoCart($id)
    {
        $products = Product::find($id);

        if (!$products) {
            abort(404);
        }

        $cart = session()->get('cart');

        if (!$cart) {
            $cart = [
                $id => [
                    'name' => $products->name,
                    'quantity' => 1,
                    'price' => $products->price,
                    'image' => $products->image->getUrl(),
                ]
            ];

            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;

            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }

        $cart[$id] = [
            'name' => $products->name,
            'quantity' => 1,
            'price' => $products->price,
            'image' => $products->image->getUrl(),
        ];

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function updateCart(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return response()->json(['success' => 'Cart updated successfully!']);
        }
        return response()->json(['error' => 'Cart update failed!'], 400);
    }

    public function deleteCart($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return response()->json(['success' => 'Product removed from cart successfully!']);
        }
        return response()->json(['error' => 'Product not found in cart!'], 404);
    }
}
