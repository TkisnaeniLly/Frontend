<?php

namespace App\Http\Controllers;

use App\Services\CartApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartApiService $cartService)
    {
        $this->cartService = $cartService;
    }

    protected function getToken()
    {
        return Session::get('api_token');
    }

    public function index()
    {
        $token = $this->getToken();
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $response = $this->cartService->getCart($token);
        
        // Check if token expired or invalid (statusCode 401 from API)
        if (isset($response['statusCode']) && $response['statusCode'] == 401) {
             Session::forget(['api_token', 'user']);
             return response()->json(['status' => 'error', 'message' => 'Session expired'], 401);
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $token = $this->getToken();
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'variant_id' => 'required',
            'qty' => 'required|integer|min:1'
        ]);

        $response = $this->cartService->addToCart($token, $request->variant_id, $request->qty);

        return response()->json($response);
    }

    public function update(Request $request)
    {
        $token = $this->getToken();
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'item_id' => 'required'
        ]);

        $response = $this->cartService->updateCart(
            $token, 
            $request->item_id, 
            $request->qty, 
            $request->variant_id
        );

        return response()->json($response);
    }

    public function destroy(Request $request)
    {
        $token = $this->getToken();
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'item_id' => 'required'
        ]);

        $response = $this->cartService->deleteCart(
            $token, 
            $request->item_id, 
            $request->input('qty')
        );

        return response()->json($response);
    }
}
