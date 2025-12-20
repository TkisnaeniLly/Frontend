<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ProductApiService
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        // Ideally this comes from .env, using default if not set
        $baseUrl = env('API_BASE_URL', 'https://tishopapi.naxgrinting.my.id/api');
        // Ensure trailing slash for Guzzle base_uri resolution
        $this->baseUrl = rtrim($baseUrl, '/') . '/';
        
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 30.0,
            'http_errors' => false, // We'll handle errors manually
        ]);
    }

    /**
     * Fetch product details by slug.
     * 
     * @param string $slug
     * @return array|null Returns product data array or null on failure (404)
     */
    public function getProductBySlug($slug)
    {
        try {
            // Note: User prompt example shows /api/catalog/{slug}
            // But baseUrl is /api from construct, so we append /catalog/{slug}
            // Ensure no double slash issue
            $url = rtrim($this->baseUrl, '/') . '/catalog/' . $slug;
            
            // Adjust if baseUrl already includes /api, but let's assume construct handles base.
            // Actually, Guzzle base_uri handles simple relative paths better.
            // Let's rely on full path construction for safety if base_uri is ambiguous in env.
            // Or cleaner: use relative uri if base_uri is set properly.
            
            $response = $this->client->get("catalog/{$slug}", [
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);

            if ($statusCode >= 200 && $statusCode < 300) {
                return $body['data'] ?? null;
            }

            Log::error("Product API Error ({$statusCode}): " . json_encode($body));
            return null;

        } catch (\Exception $e) {
            Log::error("Product API Exception: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Fetch all products from catalog.
     * 
     * @return array
     */
    public function getAllProducts()
    {
        try {
            $response = $this->client->get("catalog", [
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);

            if ($statusCode >= 200 && $statusCode < 300) {
                return $body['data'] ?? [];
            }

            Log::error("Product API List Error ({$statusCode}): " . json_encode($body));
            return [];

        } catch (\Exception $e) {
            Log::error("Product API List Exception: " . $e->getMessage());
            return [];
        }
    }
}
