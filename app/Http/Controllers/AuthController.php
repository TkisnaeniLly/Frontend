<?php

namespace App\Http\Controllers;

use App\Services\AuthApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthApiService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $response = $this->authService->login($request->email, $request->password);

        if (isset($response['statusCode']) && $response['statusCode'] == 200) {
            // Store data for next step
            Session::put('login_email', $response['data']['email']);
            Session::put('login_device_id', $response['data']['device_id']);
            Session::put('login_message', $response['message']);

            return response()->json([
                'status' => 'success',
                'step' => 'otp',
                'message' => $response['message'],
                'data' => $response['data']
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $response['message'] ?? 'Login failed'
            ], 401);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'full_name' => 'required',
            'gender' => 'required',
            'birth_date' => 'required|date',
        ]);

        $data = [
            'username' => $request->username,
            'password' => $request->password,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'role' => 'user',
            'full_name' => $request->full_name,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date
        ];

        $response = $this->authService->register($data);

        if (isset($response['statusCode']) && $response['statusCode'] == 200) {
            return response()->json([
                'status' => 'success',
                'message' => $response['message']
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $response['message'] ?? 'Registration failed'
            ], 400);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $email = Session::get('login_email');
        $deviceId = Session::get('login_device_id');

        if (!$email || !$deviceId) {
             // Fallback if not in session, though frontend should handle flow.
             // Or allow passing them in request if session expired/missing
             $email = $request->input('email');
             $deviceId = $request->input('device_id');
        }

        if (!$email || !$deviceId) {
             return response()->json([
                'status' => 'error',
                'message' => 'Session expired. Please login again.'
            ], 400);
        }

        $response = $this->authService->verifyLogin($email, $deviceId, $request->otp);

        if (isset($response['statusCode']) && $response['statusCode'] == 200) {
            // Login successful
            $token = $response['data']['token'];
            $user = $response['data']['user'];

            Session::put('api_token', $token);
            Session::put('user', $user);
            
            // Clear temp session
            Session::forget(['login_email', 'login_device_id', 'login_message']);

            // Get intended URL or default to home
            $redirectUrl = Session::get('url.intended', '/');
            Session::forget('url.intended');

            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
                'redirect_url' => $redirectUrl
            ]);
        } else {
             return response()->json([
                'status' => 'error',
                'message' => $response['message'] ?? 'OTP Verification failed'
            ], 401);
        }
    }

    public function logout()
    {
        Session::flush();
        return response()->json(['status' => 'success', 'message' => 'Logged out']);
    }
    
    public function user()
    {
        $user = Session::get('user');
        if ($user) {
            return response()->json(['user' => $user]);
        }
        return response()->json(['user' => null]);
    }
}
