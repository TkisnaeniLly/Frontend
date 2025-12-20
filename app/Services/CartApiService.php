<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class CartApiService
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'https://tishopapi.naxgrinting.my.id/api/cart';
        $this->client = new Client([
            'timeout'  => 10,
            'http_errors' => false,
        ]);
    }

    protected function getHeaders($token)
    {
        return [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    public function getCart($token)
    {
        try {
            $response = $this->client->get($this->baseUrl, [
                'headers' => $this->getHeaders($token)
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('CartApiService getCart error: ' . $e->getMessage());
            return ['statusCode' => 500, 'message' => $e->getMessage()];
        }
    }

    public function addToCart($token, $variantId, $qty)
    {
        try {
            $response = $this->client->post($this->baseUrl, [
                'headers' => $this->getHeaders($token),
                'json' => [
                    'variant_id' => $variantId,
                    'qty' => $qty
                ]
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('CartApiService addToCart error: ' . $e->getMessage());
            return ['statusCode' => 500, 'message' => $e->getMessage()];
        }
    }

    public function updateCart($token, $itemId, $qty = null, $variantId = null)
    {
        try {
            $data = ['item_id' => $itemId];
            if (!is_null($qty)) $data['qty'] = $qty;
            if (!is_null($variantId)) $data['variant_id'] = $variantId;

            $response = $this->client->put($this->baseUrl, [
                'headers' => $this->getHeaders($token),
                'json' => $data
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('CartApiService updateCart error: ' . $e->getMessage());
            return ['statusCode' => 500, 'message' => $e->getMessage()];
        }
    }

    public function deleteCart($token, $itemId, $qty = null)
    {
        try {
            $data = ['item_id' => $itemId];
            if (!is_null($qty)) $data['qty'] = $qty;

            $response = $this->client->delete($this->baseUrl, [
                'headers' => $this->getHeaders($token),
                'json' => $data
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('CartApiService deleteCart error: ' . $e->getMessage());
            return ['statusCode' => 500, 'message' => $e->getMessage()];
        }
    }
}
