@extends('layouts.app')

@section('content')
    <div class="wishlist-container">
        <div class="wishlist-header">
            <h1 class="wishlist-title">My Wishlist</h1>
        </div>

        <div id="wishlistContent">
            <!-- Wishlist items will be populated by JavaScript -->
        </div>
    </div>

    <style>
        .wishlist-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 120px 50px 80px;
            min-height: 80vh;
        }

        .wishlist-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .wishlist-title {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 300;
        }

        .wishlist-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        /* Reusing product card styles but simpler */
        .wishlist-item {
            position: relative;
        }

        .empty-wishlist {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-wishlist-icon {
            font-size: 5rem;
            color: var(--rose);
            margin-bottom: 25px;
            opacity: 0.5;
        }

        .empty-wishlist-title {
            font-size: 2rem;
            margin-bottom: 15px;
        }

        .empty-wishlist-desc {
            color: var(--text-secondary);
            margin-bottom: 30px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            loadWishlist();
        });

        function loadWishlist() {
            const wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
            const container = document.getElementById('wishlistContent');

            if (wishlist.length === 0) {
                container.innerHTML = `
                    <div class="empty-wishlist">
                        <div class="empty-wishlist-icon">
                            <i class="far fa-heart"></i>
                        </div>
                        <h2 class="empty-wishlist-title">Your Wishlist is Empty</h2>
                        <p class="empty-wishlist-desc">Save items you love to revisit later.</p>
                        <a href="{{ route('products.index') }}" class="shop-now-btn">Start Exploring</a>
                    </div>
                `;
                return;
            }

            const html = wishlist.map(item => `
                <div class="product-card">
                     <div class="product-image" style="background: linear-gradient(135deg, #D6A99D 0%, #C9967E 100%);">
                        <img src="${item.image}" alt="${item.name}" 
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                             style="width: 100%; height: 100%; object-fit: cover;">
                         <i class="fas fa-tshirt" style="display:none"></i>
                        <div class="product-actions">
                            <button class="product-action-btn" onclick="removeFromWishlist(${item.id})" title="Remove">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="product-action-btn" onclick="window.location.href='/product/slug-placeholder'" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">${item.name}</h3>
                        <div class="product-price">
                             <span class="current-price">Rp ${parseFloat(item.price).toLocaleString('id-ID')}</span>
                        </div>
                    </div>
                </div>
            `).join('');

            container.innerHTML = `<div class="wishlist-grid">${html}</div>`;
        }

        function removeFromWishlist(id) {
            let wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
            wishlist = wishlist.filter(item => item.id !== id);
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            loadWishlist();
            showToast('info', 'Item Removed', 'Product removed from wishlist');
        }
    </script>
@endsection
