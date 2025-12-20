@extends('layouts.app')

@section('content')
    <section class="hero" id="home">
        <div class="hero-bg"></div>
        <div class="hero-pattern"></div>
        <div class="hero-content">
            <p class="hero-subtitle">{{ __('messages.hero_subtitle') }}</p>
            <h1 class="hero-title">{!! __('messages.hero_title') !!}</h1>
            <p class="hero-desc">{{ __('messages.hero_desc') }}</p>
            <a href="#products" class="hero-btn">{{ __('messages.explore_btn') }}</a>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories" id="collections">
        <div class="section-header">
            <p class="section-subtitle">{{ __('messages.section_explore') }}</p>
            <h2 class="section-title">{{ __('messages.section_featured_collections') }}</h2>
        </div>
        <div class="categories-grid">
            <div class="category-card" data-category="t-shirt">
                <div class="category-bg">
                    <i class="fas fa-tshirt"></i>
                </div>
                <div class="category-content">
                    <h3 class="category-name">{{ __('messages.category_tshirt') }}</h3>
                    <p class="category-count">
                        {{ count(array_filter($products, function ($p) {return isset($p['category']) && $p['category'] === 't-shirt';})) }}
                        {{ __('messages.products_count') }}</p>
                </div>
            </div>
            <div class="category-card" data-category="jaket">
                <div class="category-bg">
                    <i class="fas fa-vest"></i>
                </div>
                <div class="category-content">
                    <h3 class="category-name">{{ __('messages.category_jacket') }}</h3>
                    <p class="category-count">
                        {{ count(array_filter($products, function ($p) {return isset($p['category']) && $p['category'] === 'jaket';})) }}
                        {{ __('messages.products_count') }}</p>
                </div>
            </div>
            <div class="category-card" data-category="sepatu">
                <div class="category-bg">
                    <i class="fas fa-shoe-prints"></i>
                </div>
                <div class="category-content">
                    <h3 class="category-name">{{ __('messages.category_shoes') }}</h3>
                    <p class="category-count">
                        {{ count(array_filter($products, function ($p) {return isset($p['category']) && $p['category'] === 'sepatu';})) }}
                        {{ __('messages.products_count') }}</p>
                </div>
            </div>
            <div class="category-card" data-category="new">
                <div class="category-bg">
                    <i class="fas fa-star"></i>
                </div>
                <div class="category-content">
                    <h3 class="category-name">{{ __('messages.category_new') }}</h3>
                    <p class="category-count">
                        {{ count(array_filter($products, function ($p) {return isset($p['badge']) && $p['badge'] === 'New';})) }}
                        {{ __('messages.products_count') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products" id="products">
        <div class="section-header">
            <p class="section-subtitle">{{ __('messages.section_shop_now') }}</p>
            <h2 class="section-title">{{ __('messages.section_featured_products') }}</h2>
        </div>
        <div class="filter-tabs">
            <button class="filter-tab active" data-filter="all">{{ __('messages.filter_all') }}</button>
            <button class="filter-tab" data-filter="t-shirt">{{ __('messages.category_tshirt') }}</button>
            <button class="filter-tab" data-filter="jaket">{{ __('messages.category_jacket') }}</button>
            <button class="filter-tab" data-filter="sepatu">{{ __('messages.category_shoes') }}</button>
            <button class="filter-tab" data-filter="new">New</button>
        </div>
        <div class="products-grid" id="productsGrid">
            @foreach ($products as $product)
                <div class="product-card" data-id="{{ $product['id'] }}" data-category="{{ $product['category'] }}"
                    data-badge="{{ $product['badge'] ?? '' }}"
                    onclick="window.location.href='{{ route('product.detail', $product['slug']) }}'"
                    style="cursor: pointer;">
                    <div class="product-image" style="background: linear-gradient(135deg, #D6A99D 0%, #C9967E 100%);">
                        @if (!empty($product['image']))
                            <img src="{{ App\Helpers\ImageHelper::getUrl($product['image']) }}"
                                alt="{{ $product['name'] }}"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="fas fa-tshirt"></i>
                        @endif
                        @if (!empty($product['badge']))
                            <span class="product-badge">{{ $product['badge'] }}</span>
                        @endif
                        <div class="product-actions">
                            <button class="product-action-btn wishlist-btn" title="Add to Wishlist"
                                onclick="event.stopPropagation()">
                                <i class="far fa-heart"></i>
                            </button>
                            <button class="product-action-btn quick-view-btn" data-product-id="{{ $product['id'] }}"
                                title="Quick View" onclick="event.stopPropagation()">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="product-info">
                        <p class="product-category">{{ $product['category'] }}</p>
                        <a href="{{ route('product.detail', $product['slug']) }}"
                            style="text-decoration: none; color: inherit;">
                            <h3 class="product-name">{{ $product['name'] }}</h3>
                        </a>
                        @if (!empty($product['brand']))
                            <p class="product-brand" style="font-size: 0.85rem; color: #888; margin-top: 0.25rem;">
                                {{ $product['brand'] }}</p>
                        @endif
                        <div class="product-price">
                            <span class="current-price">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
                            @if (!empty($product['originalPrice']))
                                <span class="original-price">Rp
                                    {{ number_format($product['originalPrice'], 0, ',', '.') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter">
        <h2 class="newsletter-title">{{ __('messages.newsletter_title') }}</h2>
        <p class="newsletter-desc">{{ __('messages.newsletter_desc') }}</p>
        <form class="newsletter-form" id="newsletterForm">
            <input type="email" class="newsletter-input" placeholder="{{ __('messages.newsletter_placeholder') }}"
                required>
            <button type="submit" class="newsletter-btn">{{ __('messages.newsletter_btn') }}</button>
        </form>
    </section>

    <script>
        // Pass products data to JavaScript
        window.productsData = @json($products);

        // Create product map for quick access
        window.productsMap = {};
        window.productsData.forEach(product => {
            window.productsMap[product.id] = product;
        });

        const newsletterForm = document.getElementById("newsletterForm");
        // Newsletter Form
        newsletterForm.addEventListener("submit", (e) => {
            e.preventDefault();
            const email = newsletterForm.querySelector("input").value;
            if (email) {
                showToast(
                    "success",
                    "Subscribed!",
                    "Thank you for joining our newsletter"
                );
                newsletterForm.reset();
            }
        });
    </script>
@endsection
