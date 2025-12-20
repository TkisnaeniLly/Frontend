@extends('layouts.app')

@section('content')
    <div class="auth-page-container">
        <div class="auth-card" style="max-width: 550px;">
            <h2 class="auth-title">{{ __('messages.auth_register_tab') }}</h2>
            <p class="auth-subtitle">Cek Email Anda Untuk Verifikasi Akun</p>

            <!-- Register Form -->
            <form id="registerForm">
                <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.auth_fullname') }}</label>
                        <input type="text" class="form-input" id="registerName" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.auth_username') }}</label>
                        <input type="text" class="form-input" id="registerUsername" placeholder="johndoe" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('messages.auth_email') }}</label>
                    <input type="email" class="form-input" id="registerEmail" placeholder="your@email.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('messages.auth_phone') }}</label>
                    <input type="tel" class="form-input" id="registerPhone" placeholder="08123456789" required>
                </div>

                <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.auth_gender') }}</label>
                        <select class="form-input" id="registerGender" required>
                            <option value="L">{{ __('messages.auth_gender_male') }}</option>
                            <option value="P">{{ __('messages.auth_gender_female') }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.auth_birthdate') }}</label>
                        <input type="date" class="form-input" id="registerBirthDate" required onclick="this.showPicker()"
                            style="cursor: pointer;">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('messages.auth_password') }}</label>
                    <div class="password-toggle">
                        <input type="password" class="form-input" id="registerPassword" placeholder="Create a password"
                            required minlength="8">
                        <button type="button" class="toggle-password" data-target="registerPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('messages.auth_confirm_password') }}</label>
                    <div class="password-toggle">
                        <input type="password" class="form-input" id="confirmPassword" placeholder="Confirm your password"
                            required>
                        <button type="button" class="toggle-password" data-target="confirmPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="form-checkbox">
                    <input type="checkbox" id="agreeTerms" required>
                    <label for="agreeTerms">{{ __('messages.auth_agree') }} <a
                            href="#">{{ __('messages.auth_terms') }}</a> & <a
                            href="#">{{ __('messages.auth_privacy') }}</a></label>
                </div>
                <div class="auth-footer">
                    <button type="submit" class="submit-btn"
                        style="white-space: nowrap;">{{ __('messages.auth_btn_create') }}</button>
                </div>

                <div class="divider">
                    <span>{{ __('messages.auth_or_continue') }}</span>
                </div>

                <div class="social-auth">
                    <button type="button" class="social-auth-btn">
                        <i class="fab fa-google"></i>
                        <span style="margin-left: 8px;">Google</span>
                    </button>
                    <button type="button" class="social-auth-btn">
                        <i class="fab fa-facebook-f"></i>
                        <span style="margin-left: 8px;">Facebook</span>
                    </button>
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
        }

        .auth-card {
            background: white;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 100%;
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
    </style>
@endsection
