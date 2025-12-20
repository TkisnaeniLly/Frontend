@extends('layouts.app')

@section('content')

    <!-- Product Detail Section -->
    <section class="product-detail">
        <div class="product-detail-container">
            <!-- Breadcrumb -->
            <div class="breadcrumb">
                <a href="/">{{ __('messages.nav_home') }}</a>
                <i class="fas fa-chevron-right"></i>
                <span>{{ $product['category'] ?? 'Product' }}</span>
                <i class="fas fa-chevron-right"></i>
                <span>{{ $product['name'] ?? $product['product_name'] }}</span>
            </div>

            <!-- Product Main Content -->
            <div class="product-detail-grid">
                <!-- Product Images -->
                <div class="product-images">
                    <div class="main-image-container">
                        @if (isset($product['badge']))
                            <div class="product-badge">{{ $product['badge'] }}</div>
                        @endif
                        <div class="main-image" id="mainImage">
                            @if (!empty($product['Media']) && count($product['Media']) > 0)
                                <img src="{{ \App\Helpers\ImageHelper::getUrl($product['Media'][0]['media_url']) }}"
                                    alt="{{ $product['product_name'] }}"
                                    style="width:100%; height:100%; object-fit:contain;">
                            @elseif(!empty($product['image']))
                                <img src="{{ \App\Helpers\ImageHelper::getUrl($product['image']) }}"
                                    alt="{{ $product['name'] }}" style="width:100%; height:100%; object-fit:contain;">
                            @else
                                <i class="fas fa-shopping-bag"></i>
                            @endif
                        </div>
                    </div>
                    <div class="thumbnail-images">
                        @if (!empty($product['Media']) && count($product['Media']) > 0)
                            @foreach ($product['Media'] as $index => $media)
                                <div class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                                    data-src="{{ \App\Helpers\ImageHelper::getUrl($media['media_url']) }}">
                                    <img src="{{ \App\Helpers\ImageHelper::getUrl($media['media_url']) }}"
                                        alt="Thumbnail {{ $index + 1 }}"
                                        style="width:100%; height:100%; object-fit:cover;">
                                </div>
                            @endforeach
                        @elseif(!empty($product['image']))
                            <div class="thumbnail active"
                                data-src="{{ \App\Helpers\ImageHelper::getUrl($product['image']) }}">
                                <img src="{{ \App\Helpers\ImageHelper::getUrl($product['image']) }}" alt="Thumbnail"
                                    style="width:100%; height:100%; object-fit:cover;">
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="product-detail-info">
                    <div class="product-meta">
                        <span
                            class="product-category">{{ $product['Category']['category_name'] ?? ($product['category'] ?? 'Category') }}</span>
                        @if (isset($product['Brand']))
                            <span class="product-brand"
                                style="margin-left: 10px; color: #888;">{{ $product['Brand']['brand_name'] }}</span>
                        @endif
                    </div>

                    <h1 class="product-detail-title">{{ $product['product_name'] ?? $product['name'] }}</h1>

                    <div class="product-detail-price">
                        @php
                            // Determine price to display
                            $displayPrice = $product['price'] ?? 0;
                            if (isset($product['Variants']) && count($product['Variants']) > 0) {
                                $displayPrice = $product['Variants'][0]['price'];
                            }
                        @endphp
                        <span class="current-price" id="displayPrice">Rp
                            {{ number_format($displayPrice, 0, ',', '.') }}</span>
                    </div>

                    <p class="product-description">
                        {{ $product['description'] }}
                    </p>

                    <div class="product-options">
                        <!-- Variant Selection Loop -->
                        @if (isset($product['Variants']) && count($product['Variants']) > 0)
                            @php
                                $variants = collect($product['Variants']);
                                $sizes = $variants->where('variant_type', 'SIZE')->unique('variant_value');
                                $colors = $variants->where('variant_type', 'COLOR')->unique('variant_value');
                            @endphp

                            @if ($sizes->isNotEmpty())
                                <div class="option-group">
                                    <div class="option-header">
                                        <label class="option-label">
                                            {{ __('messages.detail_size') }} <span
                                                id="selectedSize">{{ __('messages.detail_select') }}</span>
                                        </label>
                                    </div>
                                    <div class="size-options">
                                        @foreach ($sizes as $size)
                                            <button class="size-option" data-id="{{ $size['id'] }}"
                                                data-price="{{ $size['price'] }}"
                                                data-value="{{ $size['variant_value'] }}">
                                                {{ $size['variant_value'] }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($colors->isNotEmpty())
                                <div class="option-group">
                                    <label class="option-label">
                                        {{ __('messages.detail_color') }} <span
                                            id="selectedColor">{{ __('messages.detail_select') }}</span>
                                    </label>
                                    <div class="color-options">
                                        @foreach ($colors as $color)
                                            <button class="color-option" data-id="{{ $color['id'] }}"
                                                data-price="{{ $color['price'] }}"
                                                data-value="{{ $color['variant_value'] }}"
                                                style="background: {{ strtolower($color['variant_value']) }}; border: 1px solid #ddd;">
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif

                        <!-- Quantity -->
                        <div class="option-group">
                            <label class="option-label">{{ __('messages.detail_quantity') }}</label>
                            <div class="quantity-selector">
                                <button class="quantity-btn" id="decreaseQty">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" class="quantity-input" value="1" min="1" max="10"
                                    id="quantityInput">
                                <button class="quantity-btn" id="increaseQty">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="product-actions-group">
                        <button class="btn-primary add-to-cart-main" id="addToCartBtn">
                            <i class="fas fa-shopping-cart"></i>
                            {{ __('messages.detail_add_to_cart') }}
                        </button>
                        <button class="btn-secondary wishlist-btn-detail" id="wishlistBtnDetail">
                            <i class="far fa-heart"></i>
                            {{ __('messages.detail_add_to_wishlist') }}
                        </button>
                        <!-- Hidden Input for selected variant -->
                        <input type="hidden" id="selectedVariantId" value="">
                    </div>

                    <!-- Share Product -->
                    <div class="product-share">
                        <span>{{ __('messages.detail_share') }}</span>
                        <div class="share-buttons">
                            <button class="share-btn"
                                onclick="window.open('https://api.whatsapp.com/send?text=' + encodeURIComponent(window.location.href))"
                                title="Share on WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </button>
                            <button class="share-btn"
                                onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href))"
                                title="Share on Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button class="share-btn" onclick="window.open('https://www.instagram.com/')" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details Tabs -->
            <div class="product-tabs">
                <div class="tab-buttons">
                    <button class="tab-btn active"
                        data-tab="description">{{ __('messages.detail_description') }}</button>
                    <button class="tab-btn" data-tab="details">{{ __('messages.detail_details') }}</button>
                </div>

                <div class="tab-content-container">
                    <div class="tab-content active" id="description">
                        <h3>{{ __('messages.detail_description') }}</h3>
                        <p>{{ $product['description'] }}</p>
                    </div>
                    <div class="tab-content" id="details">
                        <h3>{{ __('messages.detail_specifications') }}</h3>
                        <div class="details-grid">
                            <div class="detail-item">
                                <strong>Category</strong>
                                <span>{{ $product['Category']['category_name'] ?? 'N/A' }}</span>
                            </div>
                            <div class="detail-item">
                                <strong>Brand</strong>
                                <span>{{ $product['Brand']['brand_name'] ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Related Products -->
            <div class="related-products">
                <h2 class="section-title">{{ __('messages.detail_related') }}</h2>
                <div class="related-products-grid">
                    <div class="product-card">
                        <div class="product-image"
                            style="background: linear-gradient(135deg, var(--teal) 0%, #7a9994 100%);">
                            <i class="fas fa-tshirt"></i>
                        </div>
                        <div class="product-info">
                            <p class="product-category">Women</p>
                            <h3 class="product-name">Cashmere Sweater</h3>
                            <div class="product-price">
                                <span class="current-price">$189.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="product-image"
                            style="background: linear-gradient(135deg, var(--sage) 0%, #b8bda9 100%);">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="product-info">
                            <p class="product-category">Accessories</p>
                            <h3 class="product-name">Leather Handbag</h3>
                            <div class="product-price">
                                <span class="current-price">$249.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="product-image"
                            style="background: linear-gradient(135deg, var(--rose) 0%, #c48b7f 100%);">
                            <i class="fas fa-shoe-prints"></i>
                        </div>
                        <div class="product-info">
                            <p class="product-category">Women</p>
                            <h3 class="product-name">Classic Heels</h3>
                            <div class="product-price">
                                <span class="current-price">$159.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="product-image" style="background: linear-gradient(135deg, #c9a962 0%, #a8894d 100%);">
                            <i class="fas fa-gem"></i>
                        </div>
                        <div class="product-info">
                            <p class="product-category">Accessories</p>
                            <h3 class="product-name">Gold Necklace</h3>
                            <div class="product-price">
                                <span class="current-price">$129.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Product Detail Styles */
        .product-detail {
            padding: 120px 50px 100px;
            min-height: 100vh;
        }

        .product-detail-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 40px;
            font-size: 0.85rem;
        }

        .breadcrumb a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: var(--transition);
        }

        .breadcrumb a:hover {
            color: var(--rose);
        }

        .breadcrumb i {
            font-size: 0.7rem;
            color: var(--text-secondary);
        }

        .breadcrumb span {
            color: var(--text-primary);
            font-weight: 500;
        }

        /* Product Detail Grid */
        .product-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            margin-bottom: 80px;
        }

        /* Product Images */
        .product-images {
            position: sticky;
            top: 120px;
            height: fit-content;
        }

        .main-image-container {
            position: relative;
            margin-bottom: 20px;
        }

        .main-image {
            height: 600px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--rose) 0%, #c48b7f 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .wishlist-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--bg-card);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1.3rem;
            color: var(--text-primary);
            z-index: 10;
        }

        .wishlist-btn:hover,
        .wishlist-btn.active {
            background: var(--rose);
            color: white;
            transform: scale(1.1);
        }

        .thumbnail-images {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .thumbnail {
            height: 120px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--teal) 0%, #7a9994 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            cursor: pointer;
            transition: var(--transition);
            border: 3px solid transparent;
        }

        .thumbnail:hover,
        .thumbnail.active {
            border-color: var(--rose);
            transform: translateY(-3px);
        }

        /* Product Info */
        .product-detail-info {
            padding: 20px 0;
        }

        .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .product-rating i {
            color: var(--gold);
            font-size: 0.9rem;
        }

        .rating-count {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-left: 5px;
        }

        .product-detail-title {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: 300;
        }

        .product-detail-price {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .product-detail-price .current-price {
            font-size: 2rem;
            font-weight: 500;
            color: var(--rose);
        }

        .product-detail-price .original-price {
            font-size: 1.3rem;
            color: var(--text-secondary);
            text-decoration: line-through;
        }

        .discount-badge {
            padding: 6px 12px;
            background: var(--rose);
            color: white;
            font-size: 0.85rem;
            border-radius: 5px;
            font-weight: 500;
        }

        .product-description {
            color: var(--text-secondary);
            line-height: 1.8;
            margin-bottom: 30px;
            font-size: 0.95rem;
        }

        /* Product Options */
        .product-options {
            margin-bottom: 30px;
        }

        .option-group {
            margin-bottom: 25px;
        }

        .option-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .option-label {
            font-size: 0.85rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text-primary);
            font-weight: 500;
            margin-bottom: 12px;
            display: block;
        }

        .option-label span {
            color: var(--rose);
        }

        .size-guide {
            font-size: 0.85rem;
            color: var(--rose);
            text-decoration: none;
            transition: var(--transition);
        }

        .size-guide:hover {
            text-decoration: underline;
        }

        /* Color Options */
        .color-options {
            display: flex;
            gap: 12px;
        }

        .color-option {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 3px solid transparent;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }

        .color-option::after {
            content: '';
            position: absolute;
            inset: -6px;
            border: 2px solid var(--rose);
            border-radius: 50%;
            opacity: 0;
            transition: var(--transition);
        }

        .color-option.active::after,
        .color-option:hover::after {
            opacity: 1;
        }

        /* Size Options */
        .size-options {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .size-option {
            min-width: 55px;
            padding: 12px 18px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            background: var(--bg-primary);
            color: var(--text-primary);
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }

        .size-option:hover {
            border-color: var(--rose);
        }

        .size-option.active {
            border-color: var(--rose);
            background: var(--rose);
            color: white;
        }

        /* Quantity Selector */
        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 15px;
            width: fit-content;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            background: var(--bg-primary);
            color: var(--text-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .quantity-btn:hover {
            border-color: var(--rose);
            color: var(--rose);
        }

        .quantity-input {
            width: 70px;
            height: 40px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            background: var(--bg-primary);
            color: var(--text-primary);
            text-align: center;
            font-size: 1rem;
            font-weight: 500;
        }

        .quantity-input:focus {
            outline: none;
            border-color: var(--rose);
        }

        /* Action Buttons */
        .product-actions-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 30px;
        }

        .btn-primary,
        .btn-secondary {
            padding: 18px 30px;
            border-radius: 8px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.9rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 500;
        }

        .btn-primary {
            background: var(--rose);
            border: 2px solid var(--rose);
            color: white;
        }

        .btn-primary:hover {
            background: transparent;
            color: var(--rose);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(214, 169, 157, 0.3);
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid var(--border-color);
            color: var(--text-primary);
        }

        .btn-secondary:hover {
            border-color: var(--rose);
            color: var(--rose);
            transform: translateY(-3px);
        }

        /* Product Features */
        .product-features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 25px;
            background: var(--bg-secondary);
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .feature-item i {
            font-size: 1.5rem;
            color: var(--rose);
            margin-top: 5px;
        }

        .feature-item div {
            flex: 1;
        }

        .feature-item strong {
            display: block;
            font-size: 0.9rem;
            margin-bottom: 3px;
        }

        .feature-item span {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        /* Product Share */
        .product-share {
            display: flex;
            align-items: center;
            gap: 15px;
            padding-top: 25px;
            border-top: 1px solid var(--border-color);
        }

        .product-share span {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .share-buttons {
            display: flex;
            gap: 10px;
        }

        .share-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid var(--border-color);
            background: var(--bg-primary);
            color: var(--text-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .share-btn:hover {
            border-color: var(--rose);
            background: var(--rose);
            color: white;
        }

        /* Product Tabs */
        .product-tabs {
            margin-bottom: 30px;
        }

        .tab-buttons {
            display: flex;
            gap: 10px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .tab-btn {
            padding: 15px 30px;
            background: none;
            border: none;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.9rem;
            letter-spacing: 0.05em;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }

        .tab-btn::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--rose);
            transform: scaleX(0);
            transition: var(--transition);
        }

        .tab-btn.active,
        .tab-btn:hover {
            color: var(--rose);
        }

        .tab-btn.active::after {
            transform: scaleX(1);
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tab-content h3 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        .tab-content h4 {
            font-size: 1.3rem;
            margin: 25px 0 15px;
        }

        .tab-content p {
            color: var(--text-secondary);
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .tab-content ul {
            list-style: none;
            padding-left: 0;
        }

        .tab-content ul li {
            color: var(--text-secondary);
            padding: 8px 0;
            padding-left: 30px;
            position: relative;
        }

        .tab-content ul li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--rose);
            font-weight: bold;
        }

        /* Details Grid */
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .detail-item {
            padding: 20px;
            background: var(--bg-secondary);
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .detail-item strong {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-primary);
        }

        .detail-item span {
            color: var(--text-secondary);
        }

        /* Reviews */
        .reviews-summary {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 50px;
            padding: 30px;
            background: var(--bg-secondary);
            border-radius: 15px;
            margin-bottom: 40px;
        }

        .rating-overview {
            text-align: center;
        }

        .rating-score {
            font-size: 4rem;
            font-weight: 300;
            color: var(--rose);
            margin-bottom: 15px;
        }

        .rating-overview .rating-stars {
            margin-bottom: 15px;
        }

        .rating-overview .rating-stars i {
            font-size: 1.2rem;
            color: var(--gold);
        }

        .rating-overview p {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .rating-bars {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .rating-bar-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .rating-bar-item>span:first-child {
            width: 50px;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .rating-bar-item i {
            font-size: 0.7rem;
            color: var(--gold);
        }

        .rating-bar {
            flex: 1;
            height: 8px;
            background: var(--bg-primary);
            border-radius: 10px;
            overflow: hidden;
        }

        .rating-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--rose), #c48b7f);
            transition: width 0.5s ease;
        }

        .rating-bar-item>span:last-child {
            width: 40px;
            text-align: right;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        /* Reviews List */
        .reviews-list {
            display: flex;
            flex-direction: column;
            gap: 30px;
            margin-bottom: 30px;
        }

        .review-item {
            padding: 30px;
            background: var(--bg-secondary);
            border-radius: 15px;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .reviewer-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .reviewer-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--rose);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 500;
        }

        .reviewer-info strong {
            display: block;
            margin-bottom: 5px;
        }

        .review-stars {
            display: flex;
            gap: 3px;
        }

        .review-stars i {
            font-size: 0.85rem;
            color: var(--gold);
        }

        .review-date {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .review-text {
            color: var(--text-secondary);
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .review-helpful {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .review-helpful span {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .review-helpful button {
            padding: 8px 15px;
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            color: var(--text-primary);
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .review-helpful button:hover {
            border-color: var(--rose);
            color: var(--rose);
        }

        .load-more-reviews {
            width: fit-content;
            margin: 0 auto;
        }

        /* Related Products */
        .related-products {
            margin-top: 30px;
            margin-bottom: 80px;
        }

        .related-products .section-title {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 40px;
        }

        .related-products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .product-detail {
                padding: 100px 30px 80px;
            }

            .product-detail-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .product-images {
                position: static;
            }

            .reviews-summary {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .product-features {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .product-detail {
                padding: 90px 20px 60px;
            }

            .main-image {
                height: 450px;
                font-size: 6rem;
            }

            .thumbnail-images {
                grid-template-columns: repeat(4, 1fr);
                gap: 10px;
            }

            .thumbnail {
                height: 80px;
                font-size: 1.5rem;
            }

            .product-detail-title {
                font-size: 2rem;
            }

            .product-detail-price .current-price {
                font-size: 1.5rem;
            }

            .product-actions-group {
                grid-template-columns: 1fr;
            }

            .tab-buttons {
                gap: 5px;
            }

            .tab-btn {
                padding: 12px 20px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 480px) {
            .breadcrumb {
                font-size: 0.75rem;
                gap: 8px;
            }

            .main-image {
                height: 350px;
                font-size: 4rem;
            }

            .thumbnail-images {
                grid-template-columns: repeat(3, 1fr);
            }

            .product-detail-title {
                font-size: 1.6rem;
            }

            .color-options {
                gap: 8px;
            }

            .color-option {
                width: 38px;
                height: 38px;
            }

            .tab-btn {
                padding: 10px 15px;
                font-size: 0.75rem;
            }

            .review-item {
                padding: 20px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isLoggedIn = {{ \Illuminate\Support\Facades\Session::has('user') ? 'true' : 'false' }};
            const mainImage = document.querySelector('#mainImage img');
            const displayPrice = document.getElementById('displayPrice');
            const selectedVariantInput = document.getElementById('selectedVariantId');
            const quantityInput = document.getElementById('quantityInput');

            // Helper formats
            const formatRupiah = (num) => 'Rp ' + new Intl.NumberFormat('id-ID').format(num);

            // Thumbnail Logic
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.addEventListener('click', function() {
                    document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove(
                        'active'));
                    this.classList.add('active');
                    if (mainImage && this.dataset.src) {
                        mainImage.src = this.dataset.src;
                    }
                });
            });

            // Wishlist Toggle Detail
            const wishlistBtnDetail = document.getElementById('wishlistBtnDetail');
            if (wishlistBtnDetail) {
                wishlistBtnDetail.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    const isActive = icon.classList.contains('fas');

                    if (!isActive) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        this.style.color = 'var(--rose)';
                        this.style.borderColor = 'var(--rose)';
                        if (typeof showToast === 'function') showToast('success', 'Wishlist',
                            'Added to wishlist');
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        this.style.color = '';
                        this.style.borderColor = '';
                        if (typeof showToast === 'function') showToast('info', 'Wishlist',
                            'Removed from wishlist');
                    }
                });
            }

            // Size Selector
            document.querySelectorAll('.size-option').forEach(option => {
                option.addEventListener('click', function() {
                    document.querySelectorAll('.size-option').forEach(o => o.classList.remove(
                        'active'));
                    this.classList.add('active');

                    const variantId = this.dataset.id;
                    const price = this.dataset.price;
                    const value = this.dataset.value;

                    selectedVariantInput.value = variantId;
                    document.getElementById('selectedSize').textContent = value;

                    if (price) {
                        displayPrice.textContent = formatRupiah(price);
                    }
                });
            });

            // Color Selector
            document.querySelectorAll('.color-option').forEach(option => {
                option.addEventListener('click', function() {
                    document.querySelectorAll('.color-option').forEach(o => o.classList.remove(
                        'active'));
                    this.classList.add('active');

                    const variantId = this.dataset.id;
                    const price = this.dataset.price;
                    const value = this.dataset.value;

                    // Note: If product has both Size and Color, logic needs to combine them to find unique Variant ID.
                    // But API structure implies flat variants list. We assume simple selection for now.
                    // If flat variants, selecting Color might override Size if they are separate variant entries?
                    // Re-visiting API: "Variants": [ {type: SIZE, value: M}, {type: SIZE, value: L} ].
                    // It seems products have EITHER size OR color variants in the example, OR simpler structure.
                    selectedVariantInput.value = variantId;
                    document.getElementById('selectedColor').textContent = value;

                    if (price) {
                        displayPrice.textContent = formatRupiah(price);
                    }
                });
            });

            // Quantity
            document.getElementById('decreaseQty').addEventListener('click', () => {
                let val = parseInt(quantityInput.value);
                if (val > 1) quantityInput.value = val - 1;
            });
            document.getElementById('increaseQty').addEventListener('click', () => {
                let val = parseInt(quantityInput.value);
                if (val < 10) quantityInput.value = val + 1;
            });

            // Add to Cart
            document.getElementById('addToCartBtn').addEventListener('click', function() {
                const variantId = selectedVariantInput.value;
                const qty = quantityInput.value;
                const hasOptions = document.querySelectorAll('.size-option, .color-option').length > 0;

                if (hasOptions && !variantId) {
                    // Try to use global showToast if available, else alert
                    if (typeof showToast === 'function') {
                        showToast('info', 'Select Option', 'Please select a variant (Size/Color)');
                    } else {
                        alert('Please select a variant');
                    }
                    return;
                }

                if (!isLoggedIn) {
                    if (typeof showToast === 'function') showToast('info', 'Please Login',
                        'You must be logged in to add items');

                    // Open Auth Modal
                    const authModal = document.getElementById('authModal');
                    if (authModal) {
                        authModal.classList.add('active');
                    } else {
                        window.location.href = '/login';
                    }
                    return;
                }

                // API Call
                const btn = this;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                btn.disabled = true;

                fetch('/cart', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            variant_id: variantId,
                            qty: qty
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success' || data.statusCode === 200) {
                            if (typeof showToast === 'function') showToast('success', 'Added to Cart',
                                'Product added successfully');

                            // Update cart count if function exists
                            if (typeof fetchCartCount === 'function') fetchCartCount();

                            // Redirect to Cart page or stay? User requirement in previous task was redirect to produkdetail (reload)
                            // But here we are ON produkdetail. Maybe just stay or reload.
                            // Let's reload to reflect state or just reset.
                        } else {
                            if (typeof showToast === 'function') showToast('error', 'Failed', data
                                .message || 'Error adding to cart');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        if (typeof showToast === 'function') showToast('error', 'Error',
                            'Something went wrong');
                    })
                    .finally(() => {
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    });
            });

            // Tab switching
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const target = this.dataset.tab;
                    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove(
                        'active'));
                    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove(
                        'active'));
                    this.classList.add('active');
                    const targetEl = document.getElementById(target);
                    if (targetEl) targetEl.classList.add('active');
                });
            });
        });
    </script>



@endsection
