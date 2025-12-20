@extends('layouts.app')

@section('content')
    <!-- Cart Container -->
    <div class="cart-container">
        <div class="cart-header">
            <p class="cart-subtitle">Your Selection</p>
            <div style="display: flex; justify-content: center; align-items: center; gap: 20px;">
                <h1 class="cart-title">Shopping Cart</h1>
                <button onclick="clearMyCart()"
                    style="background:none; border:none; color:var(--text-secondary); cursor:pointer; text-decoration:underline;">Remove
                    All</button>
            </div>
        </div>

        <div id="cartContent">
            <!-- Cart will be populated by JavaScript -->
        </div>
    </div>

    <style>
        /* Cart Container */
        .cart-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 120px 50px 80px;
        }

        .cart-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .cart-subtitle {
            font-size: 0.8rem;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--rose);
            margin-bottom: 15px;
        }

        .cart-title {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 300;
        }

        /* Cart Layout */
        .cart-layout {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 40px;
            align-items: start;
        }

        /* Cart Items */
        .cart-items {
            background: var(--bg-card);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
        }

        .cart-item {
            display: grid;
            grid-template-columns: 120px 1fr auto;
            gap: 25px;
            padding: 25px 0;
            border-bottom: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .cart-item:first-child {
            padding-top: 0;
        }

        .cart-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .cart-item-image {
            width: 120px;
            height: 140px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--rose) 0%, #c48b7f 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .cart-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-item-image i {
            font-size: 2.5rem;
            color: white;
        }

        .cart-item-details {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .cart-item-header {
            margin-bottom: 10px;
        }

        .cart-item-name {
            font-size: 1.2rem;
            font-weight: 500;
            margin-bottom: 5px;
            color: var(--text-primary);
        }

        .cart-item-category {
            font-size: 0.75rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--rose);
        }

        .cart-item-meta {
            display: flex;
            gap: 20px;
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 15px;
        }

        .cart-item-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .cart-item-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 15px;
            background: var(--bg-primary);
            padding: 8px 15px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .quantity-btn {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: none;
            background: var(--rose);
            color: white;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .quantity-btn:hover {
            background: #c48b7f;
            transform: scale(1.1);
        }

        .quantity-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .quantity-value {
            min-width: 30px;
            text-align: center;
            font-weight: 500;
            color: var(--text-primary);
        }

        .remove-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
            padding: 5px 10px;
            font-size: 0.85rem;
        }

        .remove-btn:hover {
            color: #dc2626;
        }

        .cart-item-price-section {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: space-between;
        }

        .cart-item-price {
            font-size: 1.3rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        .cart-item-original-price {
            font-size: 0.9rem;
            color: var(--text-secondary);
            text-decoration: line-through;
        }

        /* Cart Summary */
        .cart-summary {
            background: var(--bg-card);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 100px;
        }

        .summary-title {
            font-size: 1.5rem;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 0.95rem;
        }

        .summary-row.total {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid var(--border-color);
            font-size: 1.2rem;
            font-weight: 600;
        }

        .summary-label {
            color: var(--text-secondary);
        }

        .summary-value {
            font-weight: 500;
            color: var(--text-primary);
        }

        .summary-value.discount {
            color: var(--rose);
        }

        /* Promo Code */
        .promo-code {
            margin: 25px 0;
        }

        .promo-input-group {
            display: flex;
            gap: 10px;
        }

        .promo-input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--bg-primary);
            color: var(--text-primary);
            font-family: "Montserrat", sans-serif;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .promo-input:focus {
            outline: none;
            border-color: var(--rose);
        }

        .promo-btn {
            padding: 12px 20px;
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-primary);
            font-family: "Montserrat", sans-serif;
            font-size: 0.85rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            cursor: pointer;
            transition: var(--transition);
        }

        .promo-btn:hover {
            background: var(--rose);
            border-color: var(--rose);
            color: white;
        }

        /* Checkout Button */
        .checkout-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, var(--rose) 0%, #c48b7f 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-family: "Montserrat", sans-serif;
            font-size: 0.9rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 20px;
        }

        .checkout-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(214, 169, 157, 0.4);
        }

        .continue-shopping {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 15px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.85rem;
            transition: var(--transition);
        }

        .continue-shopping:hover {
            color: var(--rose);
        }

        /* Empty Cart */
        .empty-cart {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-cart-icon {
            font-size: 5rem;
            color: var(--rose);
            margin-bottom: 25px;
            opacity: 0.5;
        }

        .empty-cart-title {
            font-size: 2rem;
            margin-bottom: 15px;
        }

        .empty-cart-desc {
            color: var(--text-secondary);
            margin-bottom: 30px;
        }

        .shop-now-btn {
            display: inline-block;
            padding: 15px 40px;
            background: transparent;
            border: 1px solid var(--text-primary);
            color: var(--text-primary);
            font-family: "Montserrat", sans-serif;
            font-size: 0.85rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            text-decoration: none;
            cursor: pointer;
            transition: var(--transition);
            border-radius: 8px;
        }

        .shop-now-btn:hover {
            background: var(--rose);
            border-color: var(--rose);
            color: white;
        }

        .free-shipping-notice {
            background: linear-gradient(135deg, var(--sage) 0%, var(--teal) 100%);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 0.85rem;
            text-align: center;
            margin-bottom: 25px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .cart-layout {
                grid-template-columns: 1fr;
            }

            .cart-summary {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .cart-container {
                padding: 100px 20px 60px;
            }

            .cart-item {
                grid-template-columns: 90px 1fr;
                gap: 15px;
            }

            .cart-item-price-section {
                grid-column: 2;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                margin-top: 15px;
            }

            .cart-item-image {
                width: 90px;
                height: 110px;
            }

            .cart-items,
            .cart-summary {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .cart-item-actions {
                flex-direction: column;
                align-items: flex-start;
            }

            .promo-input-group {
                flex-direction: column;
            }

            .promo-btn {
                width: 100%;
            }
        }
    </style>

    <script>
        // Cart state
        let cartItems = [];
        let appliedPromo = null;

        const validPromoCodes = {
            'DISKON10': {
                discount: 10,
                label: '10% OFF'
            },
            'DISKON20': {
                discount: 20,
                label: '20% OFF'
            },
            'DISKON5': {
                discount: 5,
                label: '5% OFF'
            },
            'DISKON15': {
                discount: 15,
                label: '15% OFF'
            }
        };

        function formatRupiah(amount) {
            return 'Rp ' + amount.toLocaleString('id-ID');
        }

        async function loadCart() {
            try {
                const response = await fetch('/cart/data');
                if (response.ok) {
                    const data = await response.json();
                    if (data.data && data.data.items) {
                        cartItems = data.data.items.map(transformCartItem);
                        renderCart(data.data.total_price);
                    } else {
                        cartItems = [];
                        renderCart(0);
                    }
                } else if (response.status === 401) {
                    // Not logged in, maybe show empty or redirect?
                    // For now show empty with login prompt if needed, generally restricted by middleware?
                    // User requested "UpdateCart, DeleteCart, and GetMyCart... ONLY if user is logged in"
                    // If we access this page as guest, we might see empty or error.
                    cartItems = [];
                    renderCart(0);
                }
            } catch (error) {
                console.error('Error loading cart:', error);
                cartItems = [];
                renderCart(0);
            }
        }

        // Transform API cart item to frontend format
        function transformCartItem(item) {
            let imageUrl = item.product.image;
            if (imageUrl && !imageUrl.startsWith('http')) {
                // If it's a relative path, prepend API URL
                // Check if it starts with / or not
                if (imageUrl.startsWith('/')) {
                    imageUrl = `https://tishopapi.naxgrinting.my.id${imageUrl}`;
                } else {
                    imageUrl = `https://tishopapi.naxgrinting.my.id/${imageUrl}`;
                }
            } else if (!imageUrl && item.product.Media && item.product.Media.length > 0) {
                // Fallback to media if image field is empty but media exists (similar to detail page)
                let mediaUrl = item.product.Media[0].media_url;
                if (mediaUrl.startsWith('/')) {
                    imageUrl = `https://tishopapi.naxgrinting.my.id${mediaUrl}`;
                } else {
                    imageUrl = `https://tishopapi.naxgrinting.my.id/${mediaUrl}`;
                }
            }

            return {
                id: item.cart_item_id,
                variantId: item.variant.id,
                name: item.product.name,
                category: item.product.slug,
                price: parseFloat(item.price),
                originalPrice: null,
                quantity: parseInt(item.qty),
                size: item.variant.value,
                color: 'N/A',
                image: imageUrl
            };
        }

        async function updateQuantity(itemId, change) {
            const item = cartItems.find(i => i.id === itemId);
            if (!item) return;

            // If reducing quantity to 0 or less, confirm removal
            if (item.quantity + change < 1) {
                removeItem(itemId);
                return;
            }

            try {
                if (change > 0) {
                    // Start Loading
                    // Optional: Add loading UI

                    // Increase Quantity (PUT adds the qty specified)
                    await fetch('/cart', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            item_id: itemId,
                            qty: change // Sending the delta to add
                        })
                    });
                } else {
                    // Decrease Quantity (DELETE reduces the qty specified)
                    await fetch('/cart', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            item_id: itemId,
                            qty: Math.abs(change) // Sending the delta to remove
                        })
                    });
                }

                loadCart(); // Reload to get fresh state
                showCartToast('Cart updated', 'success');

            } catch (e) {
                console.error(e);
                showCartToast('Failed to update cart', 'error');
            }
        }

        async function removeItem(itemId) {
            const item = cartItems.find(i => i.id === itemId);
            if (!item) return;

            const isDark = document.documentElement.classList.contains('dark');
            const result = await Swal.fire({
                title: 'Remove item?',
                text: `Are you sure you want to remove "${item.name}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, remove it!',
                background: isDark ? '#1b1b18' : '#ffffff',
                color: isDark ? '#ffffff' : '#1b1b18'
            });

            if (!result.isConfirmed) return;

            try {
                // DELETE /api/cart/delete with qty = current_qty
                await fetch('/cart', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        item_id: itemId,
                        qty: item.quantity
                    })
                });

                loadCart();
                showCartToast('Item removed from cart', 'info');
            } catch (e) {
                console.error(e);
                showCartToast('Failed to remove item', 'error');
            }
        }

        async function clearMyCart() {
            if (cartItems.length === 0) return;

            const isDark = document.documentElement.classList.contains('dark');
            const result = await Swal.fire({
                title: 'Clear Cart?',
                text: "Are you sure you want to remove all items?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, clear all!',
                background: isDark ? '#1b1b18' : '#ffffff',
                color: isDark ? '#ffffff' : '#1b1b18'
            });

            if (!result.isConfirmed) return;

            showCartToast('Clearing cart...', 'info');

            try {
                // Iteratively delete all items sequentially to avoid backend locking/race conditions
                let hasError = false;
                for (const item of cartItems) {
                    try {
                        const response = await fetch('/cart', {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                item_id: item.id,
                                qty: item.quantity
                            })
                        });
                        if (!response.ok) {
                            console.error(`Failed to delete item ${item.id}`, response.status);
                            hasError = true;
                        }
                    } catch (err) {
                        console.error(`Error deleting item ${item.id}`, err);
                        hasError = true;
                    }
                }

                await loadCart();

                if (hasError) {
                    showCartToast('Some items could not be removed', 'warning');
                } else {
                    showCartToast('Cart cleared', 'success');
                }

            } catch (e) {
                console.error('Error clearing cart:', e);
                showCartToast('Failed to clear cart', 'error');
                loadCart(); // Reload to safeguard state
            }
        }

        function saveCart() {
            // No-op for API-based cart
        }

        function applyPromoCode() {
            const promoInput = document.querySelector('.promo-input');
            if (!promoInput) return;

            const code = promoInput.value.trim().toUpperCase();

            if (!code) {
                showCartToast('Please enter a promo code', 'error');
                return;
            }

            if (validPromoCodes[code]) {
                appliedPromo = {
                    code: code,
                    ...validPromoCodes[code]
                };
                showCartToast(`Promo code applied! ${validPromoCodes[code].label}`, 'success');
                renderCart(); // Re-render to show discount
            } else {
                showCartToast('Invalid promo code', 'error');
            }
        }

        function removePromoCode() {
            appliedPromo = null;
            const promoInput = document.querySelector('.promo-input');
            if (promoInput) {
                promoInput.value = '';
            }
            showCartToast('Promo code removed', 'info');
            renderCart();
        }

        function showCartToast(message, type = 'info') {
            const isDark = document.documentElement.classList.contains('dark');

            // Map types to SweetAlert icons
            const swalType = type === 'error' ? 'error' :
                type === 'success' ? 'success' :
                type === 'info' ? 'info' : 'info'; // Default fallback

            const title = type === 'error' ? 'Error' :
                type === 'success' ? 'Success' :
                type === 'info' ? 'Info' : 'Notification';

            Swal.fire({
                title: title,
                text: message,
                icon: swalType,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: isDark ? '#1b1b18' : '#ffffff',
                color: isDark ? '#ffffff' : '#1b1b18',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        }

        function renderCart(totalPriceOverride = null) {
            const cartContent = document.getElementById('cartContent');

            if (cartItems.length === 0) {
                // Empty state logic...
                cartContent.innerHTML = `
                    <div class="empty-cart">
                        <div class="empty-cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h2 class="empty-cart-title">Your Cart is Empty</h2>
                        <p class="empty-cart-desc">Looks like you haven't added anything to your cart yet.</p>
                        <a href="{{ route('products.index') }}" class="shop-now-btn">Start Shopping</a>
                    </div>
                `;
                return;
            }

            const subtotal = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            // Discount logic logic...
            const discount = 0; // API doesn't seem to return original prices for calc, maybe we skip or use what we have? 
            // The API returns "total_price" at the top level. We should probably use that if possible?
            // "data": { "total_price": 792000, ... }
            // Let's rely on calculated sum for now unless we pass the total price in.

            const shipping = subtotal > 500000 ? 0 : 25000;

            let promoDiscount = 0;
            if (appliedPromo) {
                promoDiscount = Math.floor((subtotal * appliedPromo.discount) / 100);
            }

            const total = subtotal + shipping - promoDiscount;

            const cartItemsHTML = cartItems.map(item => `
                <div class="cart-item">
                    <div class="cart-item-image">
                         ${item.image ? `<img src="${item.image}" alt="${item.name}" onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\\'fas fa-tshirt\\'></i>';">` : `<i class="fas fa-tshirt"></i>`}
                    </div>
                    <div class="cart-item-details">
                        <div class="cart-item-header">
                            <h3 class="cart-item-name">${item.name}</h3>
                            <p class="cart-item-category">${item.category}</p>
                        </div>
                        <div class="cart-item-meta">
                            <span><i class="fas fa-ruler"></i> ${item.size}</span>
                        </div>
                        <div class="cart-item-actions">
                            <div class="quantity-control">
                                <button class="quantity-btn" onclick="updateQuantity(${item.id}, -1)">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <span class="quantity-value">${item.quantity}</span>
                                <button class="quantity-btn" onclick="updateQuantity(${item.id}, 1)">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <button class="remove-btn" onclick="removeItem(${item.id})">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                    <div class="cart-item-price-section">
                        <div>
                            <div class="cart-item-price">${formatRupiah(item.price * item.quantity)}</div>
                        </div>
                    </div>
                </div>
            `).join('');

            cartContent.innerHTML = `
                <div class="cart-layout">
                    <div class="cart-items">
                        ${cartItemsHTML}
                    </div>
                    <div class="cart-summary">
                        <h2 class="summary-title">Order Summary</h2>
                        
                         ${subtotal < 500000 ? `
                                                                                <div class="free-shipping-notice">
                                                                                    <i class="fas fa-truck"></i>
                                                                                    Add ${formatRupiah(500000 - subtotal)} more for FREE shipping!
                                                                                </div>
                                                                            ` : `
                                                                                <div class="free-shipping-notice">
                                                                                    <i class="fas fa-check-circle"></i>
                                                                                    You qualify for FREE shipping!
                                                                                </div>
                                                                            `}
                        
                        <div class="summary-row">
                            <span class="summary-label">Subtotal</span>
                            <span class="summary-value">${formatRupiah(subtotal)}</span>
                        </div>
                       
                        <div class="summary-row">
                            <span class="summary-label">Shipping</span>
                            <span class="summary-value">${shipping === 0 ? 'FREE' : formatRupiah(shipping)}</span>
                        </div>
                        ${appliedPromo ? `
                                                                                <div class="summary-row">
                                                                                    <span class="summary-label">Promo (${appliedPromo.code})</span>
                                                                                    <span class="summary-value discount">-${formatRupiah(promoDiscount)}</span>
                                                                                </div>
                                                                            ` : ''}
                        
                        <div class="promo-code">
                             ${appliedPromo ? `
                                                                                    <div style="background: linear-gradient(135deg, var(--rose) 0%, #c48b7f 100%); color: white; padding: 15px; border-radius: 8px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">
                                                                                        <div>
                                                                                            <div style="font-weight: 600; margin-bottom: 3px;">
                                                                                                <i class="fas fa-tag"></i> ${appliedPromo.code}
                                                                                            </div>
                                                                                            <div style="font-size: 0.85rem; opacity: 0.9;">
                                                                                                ${appliedPromo.label} Applied
                                                                                            </div>
                                                                                        </div>
                                                                                        <button onclick="removePromoCode()" style="background: rgba(255,255,255,0.2); border: none; color: white; padding: 8px 12px; border-radius: 6px; cursor: pointer;">
                                                                                            <i class="fas fa-times"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                ` : `
                                                                                    <div class="promo-input-group">
                                                                                        <input type="text" class="promo-input" placeholder="Enter promo code" onkeypress="if(event.key==='Enter') applyPromoCode()">
                                                                                        <button class="promo-btn" onclick="applyPromoCode()">Apply</button>
                                                                                    </div>
                                                                                `}
                        </div>
                        
                        <div class="summary-row total">
                            <span class="summary-label">Total</span>
                            <span class="summary-value">${formatRupiah(total)}</span>
                        </div>
                        
                        <button class="checkout-btn" onclick="checkout()">
                            <i class="fas fa-lock"></i> Proceed to Checkout
                        </button>
                        
                        <a href="/" class="continue-shopping">
                            <i class="fas fa-arrow-left"></i>
                            Continue Shopping
                        </a>
                    </div>
                </div>
            `;
        }

        function checkout() {
            showCartToast('Proceeding to checkout...', 'success');
            setTimeout(() => {
                window.location.href = '/checkout';
            }, 1000);
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', loadCart);
    </script>
@endsection
