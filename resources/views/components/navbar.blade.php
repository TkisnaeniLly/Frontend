    <!-- Navigation -->
    <nav id="navbar">
        <a href="{{ route('home') }}" class="nav-logo">IT <span>SHOP</span></a>

        <!-- Search Bar -->
        {{-- <div class="nav-search-container">
            <div class="nav-search">
                <input type="text" placeholder="Search products..." id="navSearchInput">
                <button id="navSearchBtn"><i class="fas fa-search"></i></button>
            </div>
        </div> --}}

        <ul class="nav-links">
            <li><a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('messages.nav_home') }}</a></li>
            <li><a href="{{ route('products.index') }}"
                    class="{{ request()->routeIs('products.index') ? 'active' : '' }}">{{ __('messages.nav_shop') }}</a>
            </li>
            <li><a href="{{ route('products.index', ['category' => 'T-Shirt']) }}">{{ __('messages.nav_tshirts') }}</a>
            </li>
            <li><a href="{{ route('products.index', ['category' => 'Jaket']) }}">{{ __('messages.nav_jackets') }}</a>
            </li>
            <li><a href="{{ route('contact') }}"
                    class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
        </ul>
        <div class="nav-icons">
            <button class="nav-icon" id="themeToggle" aria-label="Toggle theme">
                <i class="fas fa-moon"></i>
            </button>

            <!-- Language Switcher -->
            <div class="lang-switch" style="display: flex; align-items: center; margin-right: 15px;">
                <a href="{{ route('locale.switch', 'en') }}"
                    style="font-size: 0.85rem; font-weight: {{ app()->getLocale() == 'en' ? 'bold' : 'normal' }}; color: var(--text-primary); text-decoration: none; margin-right: 5px;">EN</a>
                <span style="color: var(--text-secondary);">|</span>
                <a href="{{ route('locale.switch', 'id') }}"
                    style="font-size: 0.85rem; font-weight: {{ app()->getLocale() == 'id' ? 'bold' : 'normal' }}; color: var(--text-primary); text-decoration: none; margin-left: 5px;">ID</a>
            </div>
            <div class="user-menu" id="userMenuContainer">
                <button class="nav-icon" id="userBtn" aria-label="Account">
                    <i class="fas fa-user"></i>
                </button>
                <div class="user-dropdown" id="userDropdown" style="display: none;">
                    <div class="user-dropdown-header">
                        <div class="user-dropdown-name" id="dropdownName"></div>
                        <div class="user-dropdown-email" id="dropdownEmail"></div>
                    </div>
                    <ul class="user-dropdown-links">
                        <li><a href="#"><i class="fas fa-user"></i> My Profile</a></li>
                        <li><a href="#"><i class="fas fa-box"></i> Orders</a></li>
                        <li><a href="{{ route('wishlist') }}"><i class="fas fa-heart"></i> Wishlist</a></li>
                        <li><a href="#" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
            <button class="nav-icon" style="position: relative;" aria-label="Cart" onclick="goToCart()">
                <i class="fas fa-shopping-bag"></i>
                <span class="cart-count" id="cartCount">0</span>
            </button>
            <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <style>
        /* Active Link */
        .nav-links a.active {
            color: var(--rose);
            font-weight: 600;
        }

        /* Search Bar */
        .nav-search-container {
            flex: 1;
            display: flex;
            justify-content: center;
            margin: 0 20px;
            max-width: 400px;
        }

        .nav-search {
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;
        }

        .nav-search input {
            width: 100%;
            padding: 8px 15px;
            padding-right: 40px;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            background: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Montserrat', sans-serif;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .nav-search input:focus {
            outline: none;
            border-color: var(--rose);
            box-shadow: 0 0 0 3px rgba(214, 169, 157, 0.1);
        }

        .nav-search button {
            position: absolute;
            right: 5px;
            background: transparent;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 5px 10px;
            transition: color 0.3s ease;
        }

        .nav-search button:hover {
            color: var(--rose);
        }

        @media (max-width: 968px) {
            .nav-search-container {
                display: none;
                /* Hide on smaller screens for now or move to mobile menu */
            }
        }
    </style>

    <!-- Mobile Navigation -->
    <div class="mobile-nav-overlay" id="mobileNavOverlay"></div>
    <div class="mobile-nav" id="mobileNav">
        <button class="mobile-nav-close" id="mobileNavClose">
            <i class="fas fa-times"></i>
        </button>
        <ul class="mobile-nav-links">
            <li><a href="{{ route('home') }}">{{ __('messages.nav_home') }}</a></li>
            <li><a href="{{ route('products.index') }}">{{ __('messages.nav_shop') }}</a></li>
            <li><a
                    href="{{ route('products.index', ['category' => 'T-Shirt']) }}">{{ __('messages.nav_tshirts') }}</a>
            </li>
            <li><a href="{{ route('products.index', ['category' => 'Jaket']) }}">{{ __('messages.nav_jackets') }}</a>
            </li>
            <li><a href="{{ route('products.index', ['category' => 'Sepatu']) }}">{{ __('messages.nav_shoes') }}</a>
            </li>
        </ul>
    </div>
    <script>
        function goToCart() {
            window.location.href = '/cart';
        }
    </script>
