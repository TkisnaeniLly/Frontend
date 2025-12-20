@extends('layouts.app')

@section('content')
    <section class="products-listing">
        <div class="container">
            <!-- Header -->
            <div class="listing-header">
                <h1 class="page-title">{{ __('messages.products_title') }}</h1>

                <form method="GET" action="{{ route('products.index') }}" class="listing-controls">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" name="q" placeholder="{{ __('messages.search_placeholder') }}"
                            value="{{ request('q') }}">
                    </div>

                    <div class="filter-box">
                        <select name="category" onchange="this.form.submit()">
                            <option value="">{{ __('messages.filter_all_categories') }}</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                    {{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

            <!-- Grid -->
            @if (count($products) > 0)
                <div class="products-grid">
                    @foreach ($products as $product)
                        <div class="product-card"
                            onclick="window.location.href='{{ route('product.detail', $product['slug']) }}'">
                            <div class="product-image">
                                @if (!empty($product['image']))
                                    <img src="{{ App\Helpers\ImageHelper::getUrl($product['image']) }}"
                                        alt="{{ $product['name'] }}"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <i class="fas fa-shopping-bag" style="display: none;"></i>
                                @else
                                    <i class="fas fa-shopping-bag"></i>
                                @endif

                                @if (!empty($product['badge']))
                                    <span class="product-badge">{{ $product['badge'] }}</span>
                                @endif

                                <div class="product-actions">
                                    <button class="product-action-btn" onclick="event.stopPropagation()">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <button class="product-action-btn" onclick="event.stopPropagation()">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="product-info">
                                <p class="product-category">{{ $product['category'] }}</p>
                                <h3 class="product-name">{{ $product['name'] }}</h3>
                                <p class="product-brand">{{ $product['brand'] }}</p>
                                <div class="product-price">
                                    <span class="current-price">Rp
                                        {{ number_format($product['price'], 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-search"></i>
                    <h3>{{ __('messages.empty_state_title') }}</h3>
                    <p>{{ __('messages.empty_state_desc') }}</p>
                    <a href="{{ route('products.index') }}" class="btn-reset">{{ __('messages.reset_filters') }}</a>
                </div>
            @endif
        </div>
    </section>

    <style>
        /* Page Layout */
        .products-listing {
            padding: 120px 0 80px;
            background-color: var(--bg-light);
            min-height: 100vh;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 50px;
        }

        /* Header & Controls */
        .listing-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 50px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 300;
            color: var(--text-primary);
        }

        .listing-controls {
            display: flex;
            gap: 15px;
        }

        .search-box {
            position: relative;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }

        .search-box input {
            padding: 12px 20px 12px 45px;
            border-radius: 30px;
            border: 1px solid var(--border-color);
            width: 250px;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .search-box input:focus {
            width: 300px;
            border-color: var(--rose);
            box-shadow: 0 0 10px rgba(214, 169, 157, 0.2);
            outline: none;
        }

        .filter-box select {
            padding: 12px 25px;
            border-radius: 30px;
            border: 1px solid var(--border-color);
            background: white;
            cursor: pointer;
            font-size: 0.9rem;
            outline: none;
            transition: var(--transition);
        }

        .filter-box select:hover {
            border-color: var(--rose);
        }

        /* Grid Reuse (ensure basic styles if not inherited) */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        /* Card Styles (Replicated from Home if needed, but assuming global or copied here) */
        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            height: 350px;
            position: relative;
            overflow: hidden;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            /* Center fallback icon */
            justify-content: center;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.1);
        }

        .product-image i.fa-shopping-bag {
            font-size: 3rem;
            color: #ccc;
        }

        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--rose);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .product-actions {
            position: absolute;
            right: 15px;
            bottom: 15px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            transform: translateX(50px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .product-card:hover .product-actions {
            transform: translateX(0);
            opacity: 1;
        }

        .product-action-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            color: var(--text-primary);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .product-action-btn:hover {
            background: var(--rose);
            color: white;
        }

        .product-info {
            padding: 20px;
        }

        .product-category {
            font-size: 0.8rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 5px;
        }

        .product-name {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-brand {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 10px;
        }

        .product-price {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .current-price {
            font-weight: 600;
            color: var(--rose);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 100px 0;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: var(--border-color);
        }

        .btn-reset {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 25px;
            background: var(--text-primary);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            transition: var(--transition);
        }

        .btn-reset:hover {
            background: var(--rose);
        }

        /* Resp */
        @media (max-width: 768px) {
            .listing-header {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box input {
                width: 100%;
            }

            .search-box input:focus {
                width: 100%;
            }

            .container {
                padding: 0 20px;
            }
        }
    </style>
@endsection
