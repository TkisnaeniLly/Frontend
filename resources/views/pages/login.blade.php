@extends('layouts.app')

@section('content')
    <div class="auth-page-container">
        <div class="auth-card">
            <h2 class="auth-title">{{ __('messages.auth_welcome') }}</h2>
            <p class="auth-subtitle">{{ __('messages.auth_subtitle') }}</p>

            <!-- Login Form (Reusing IDs for script.js compatibility) -->
            <form id="loginForm">
                <div class="form-group">
                    <label class="form-label">{{ __('messages.auth_email') }}</label>
                    <input type="email" class="form-input" id="loginEmail" placeholder="your@email.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('messages.auth_password') }}</label>
                    <div class="password-toggle">
                        <input type="password" class="form-input" id="loginPassword" placeholder="Enter your password"
                            required>
                        <button type="button" class="toggle-password" data-target="loginPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="form-checkbox">
                    <input type="checkbox" id="rememberMe">
                    <label for="rememberMe">{{ __('messages.auth_remember') }}</label>
                </div>
                <button type="submit" class="submit-btn">{{ __('messages.auth_btn_signin') }}</button>

                <div class="auth-footer">
                    <p>Don't have an account? <a href="{{ route('register') }}">Create Account</a></p>
                </div>

                <div class="divider">
                    <span>{{ __('messages.auth_or_continue') }}</span>
                </div>
                <div class="social-auth">
                    <button type="button" class="social-auth-btn"><i class="fab fa-google"></i></button>
                    <button type="button" class="social-auth-btn"><i class="fab fa-facebook-f"></i></button>
                </div>
            </form>

            <!-- OTP Form (Hidden initially) -->
            <form id="otpForm" style="display: none;">
                <div class="form-group">
                    <label class="form-label"
                        style="text-align: center; display: block;">{{ __('messages.auth_verify_title') }}</label>
                    <p style="text-align: center; color: #6b7280; font-size: 0.9rem; margin-bottom: 1.5rem;">
                        {{ __('messages.auth_verify_desc') }}
                    </p>
                    <input type="text" class="form-input" id="otpInput" placeholder="Enter 6-digit code" required
                        style="text-align: center; letter-spacing: 0.5em; font-size: 1.5rem;">
                </div>
                <button type="submit" class="submit-btn">{{ __('messages.auth_verify_btn') }}</button>
                <div class="divider">
                    <span>{{ __('messages.auth_resend') }} <a href="#"
                            id="resendOtp">{{ __('messages.auth_resend_link') }}</a></span>
                </div>
            </form>
        </div>
    </div>

    <style>
        .auth-page-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f3f4f6;
            padding: 2rem;
            padding-top: 100px;
            /* Navbar space */
        }

        .auth-card {
            background: white;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 100%;
            max-width: 450px;
        }

        .auth-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: #111827;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            text-align: center;
            color: #6b7280;
            margin-bottom: 2rem;
        }

        .auth-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.9rem;
            color: #6b7280;
        }

        .auth-footer a {
            color: #4f46e5;
            font-weight: 500;
            text-decoration: none;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        /* Reuse existing form styles from style.css */
    </style>
@endsection
