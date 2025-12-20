<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class AuthApiService
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'https://tishopapi.naxgrinting.my.id/api/auth';
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 10,
            'http_errors' => false, // We handle errors manually
        ]);
    }

    /**
     * Send login request to API
     *
     * @param string $email
     * @param string $password
     * @return array
     */
    public function login(string $email, string $password)
    {
        try {
            $response = $this->client->post("{$this->baseUrl}/login", [
                'json' => [
                    'email' => $email,
                    'password' => $password,
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('AuthApiService login error: ' . $e->getMessage());
            return [
                'statusCode' => 500,
                'message' => 'Internal Server Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Send register request to API
     *
     * @param array $data
     * @return array
     */
    public function register(array $data)
    {
        try {
            $response = $this->client->post("{$this->baseUrl}/register", [
                'json' => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('AuthApiService register error: ' . $e->getMessage());
            return [
                'statusCode' => 500,
                'message' => 'Internal Server Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Verify OTP
     *
     * @param string $email
     * @param string $deviceId
     * @param string $otp
     * @return array
     */
    public function verifyLogin(string $email, string $deviceId, string $otp)
    {
        try {
            $response = $this->client->put("{$this->baseUrl}/verify-login", [
                'json' => [
                    'email' => $email,
                    'device_id' => $deviceId,
                    'otp' => $otp,
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('AuthApiService verifyLogin error: ' . $e->getMessage());
            return [
                'statusCode' => 500,
                'message' => 'Internal Server Error: ' . $e->getMessage()
            ];
        }
    }
}
