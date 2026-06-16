@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $labels = require base_path('lang/' . $locale . '.php');
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $labels['special_offers'] ?? 'العروض الخاصة' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/offers.css') }}">
</head>
<body>
    <!-- Header -->
    <header style="background: #131921; color: white; padding: 1rem 2rem; position: sticky; top: 0; z-index: 100;">
        <div style="display: flex; justify-content: space-between; align-items: center; max-width: 1400px; margin: 0 auto;">
            <a href="/" style="color: white; text-decoration: none; font-size: 1.5rem; font-weight: 700;">
                MyStore<span style="color: #febd69;">.com</span>
            </a>
            <nav style="display: flex; gap: 2rem; align-items: center;">
                <a href="/products" style="color: white; text-decoration: none;">{{ $labels['products'] ?? 'المنتجات' }}</a>
                <a href="/contact" style="color: white; text-decoration: none;">{{ $labels['support'] ?? 'الدعم' }}</a>
                @guest
                    <a href="{{ route('login') }}" style="color: white; text-decoration: none;">{{ $labels['login'] ?? 'تسجيل الدخول' }}</a>
                @else
                    <span style="color: white;">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: white; cursor: pointer; font-size: 0.9rem;">
                            {{ $labels['logout'] ?? 'تسجيل الخروج' }}
                        </button>
                    </form>
                @endguest
            </nav>
        </div>
    </header>

    <!-- Offers Section -->
    <section class="offers-section">
        <div class="offers-container">
            <h1 class="offers-title">{{ $labels['special_offers'] ?? 'العروض الخاصة' }}</h1>

            <div class="offers-grid">
                @forelse($offers as $offer)
                    <div class="offer-card">
                        <div class="offer-badge">
                            {{ $labels['discount'] ?? 'خصم' }} {{ round((($offer->old_price - $offer->price) / $offer->old_price) * 100) }}%
                        </div>
                        <img src="{{ asset('storage/' . $offer->image) }}" alt="{{ $offer->name }}" class="offer-image">
                        <div class="offer-content">
                            <h3 class="offer-title">{{ $offer->name }}</h3>
                            <p class="offer-description">{{ Str::limit($offer->description, 100) }}</p>
                            <div class="offer-price">
                                <span class="offer-current-price">${{ number_format($offer->price, 2) }}</span>
                                @if($offer->old_price)
                                    <span class="offer-old-price">${{ number_format($offer->old_price, 2) }}</span>
                                @endif
                            </div>
                            <div class="offer-timer">
                                <i class="fas fa-clock timer-icon"></i>
                                <div class="timer-display">
                                    <div class="timer-unit">
                                        <span class="timer-value" id="days-{{ $offer->id }}">02</span>
                                        <span class="timer-label">{{ $labels['days'] ?? 'أيام' }}</span>
                                    </div>
                                    <div class="timer-unit">
                                        <span class="timer-value" id="hours-{{ $offer->id }}">18</span>
                                        <span class="timer-label">{{ $labels['hours'] ?? 'ساعات' }}</span>
                                    </div>
                                    <div class="timer-unit">
                                        <span class="timer-value" id="minutes-{{ $offer->id }}">45</span>
                                        <span class="timer-label">{{ $labels['minutes'] ?? 'دقائق' }}</span>
                                    </div>
                                    <div class="timer-unit">
                                        <span class="timer-value" id="seconds-{{ $offer->id }}">30</span>
                                        <span class="timer-label">{{ $labels['seconds'] ?? 'ثواني' }}</span>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('products.show', $offer->id) }}" class="offer-button">
                                <i class="fas fa-shopping-cart"></i>
                                {{ $labels['view_offer'] ?? 'عرض العرض' }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: white;">
                        <i class="fas fa-gift" style="font-size: 4rem; margin-bottom: 1rem;"></i>
                        <p style="font-size: 1.2rem;">{{ $labels['no_offers'] ?? 'لا توجد عروض حالياً' }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Cart Toggle Button -->
    <button class="cart-toggle" onclick="toggleCart()">
        <i class="fas fa-shopping-cart cart-toggle-icon"></i>
        <span class="cart-badge" id="cart-count">{{ $cartCount ?? 0 }}</span>
    </button>

    <!-- Floating Cart -->
    <div class="floating-cart" id="cart-panel" style="display: none;">
        <div class="cart-header">
            <div class="cart-title">
                <i class="fas fa-shopping-cart"></i>
                {{ $labels['shopping_cart'] ?? 'سلة التسوق' }}
            </div>
            <button class="cart-close" onclick="toggleCart()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="cart-items" id="cart-items">
            @if(isset($cartItems) && count($cartItems) > 0)
                @foreach($cartItems as $item)
                    <div class="cart-item">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="cart-item-image">
                        <div class="cart-item-details">
                            <div class="cart-item-name">{{ $item->name }}</div>
                            <div class="cart-item-price">${{ number_format($item->price * $item->quantity, 2) }}</div>
                            <div class="cart-item-quantity">
                                <button class="quantity-btn" onclick="updateQuantity({{ $item->id }}, -1)">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <span class="quantity-value">{{ $item->quantity }}</span>
                                <button class="quantity-btn" onclick="updateQuantity({{ $item->id }}, 1)">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button class="cart-item-remove" onclick="removeFromCart({{ $item->id }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                @endforeach
            @else
                <div style="text-align: center; padding: 2rem; color: #636e72;">
                    <i class="fas fa-shopping-cart" style="font-size: 3rem; margin-bottom: 1rem; color: #b2bec3;"></i>
                    <p>{{ $labels['empty_cart'] ?? 'السلة فارغة' }}</p>
                </div>
            @endif
        </div>

        @if(isset($cartItems) && count($cartItems) > 0)
            <div class="cart-footer">
                <div class="cart-discount">
                    <span>{{ $labels['discount'] ?? 'الخصم' }}</span>
                    <span>-${{ number_format($discount ?? 0, 2) }}</span>
                </div>
                <div class="cart-shipping">
                    <span>{{ $labels['shipping'] ?? 'الشحن' }}</span>
                    <span>{{ $labels['free_shipping'] ?? 'مجاني' }}</span>
                </div>
                <div class="cart-total">
                    <span class="cart-total-label">{{ $labels['total'] ?? 'المجموع' }}</span>
                    <span class="cart-total-value">${{ number_format($total ?? 0, 2) }}</span>
                </div>
                <a href="{{ route('checkout') }}" class="cart-button">
                    <i class="fas fa-lock"></i>
                    {{ $labels['checkout'] ?? 'إتمام الشراء' }}
                </a>
            </div>
        @endif
    </div>

    <script>
        // Toggle Cart
        function toggleCart() {
            const cart = document.getElementById('cart-panel');
            if (cart.style.display === 'none') {
                cart.style.display = 'block';
            } else {
                cart.style.display = 'none';
            }
        }

        // Update Quantity
        function updateQuantity(itemId, change) {
            fetch(`/cart/update/${itemId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ quantity: change })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }

        // Remove from Cart
        function removeFromCart(itemId) {
            if (confirm('{{ $labels['confirm_remove'] ?? 'هل أنت متأكد من إزالة هذا المنتج؟' }}')) {
                fetch(`/cart/remove/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
            }
        }

        // Countdown Timer for each offer
        @foreach($offers ?? [] as $offer)
            (function() {
                const offerId = {{ $offer->id }};
                const endDate = new Date('{{ $offer->offer_end ?? now()->addDays(7)->format('Y-m-d H:i:s') }}');

                function updateTimer() {
                    const now = new Date();
                    const diff = endDate - now;

                    if (diff <= 0) {
                        document.getElementById(`days-${offerId}`).textContent = '00';
                        document.getElementById(`hours-${offerId}`).textContent = '00';
                        document.getElementById(`minutes-${offerId}`).textContent = '00';
                        document.getElementById(`seconds-${offerId}`).textContent = '00';
                        return;
                    }

                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                    document.getElementById(`days-${offerId}`).textContent = String(days).padStart(2, '0');
                    document.getElementById(`hours-${offerId}`).textContent = String(hours).padStart(2, '0');
                    document.getElementById(`minutes-${offerId}`).textContent = String(minutes).padStart(2, '0');
                    document.getElementById(`seconds-${offerId}`).textContent = String(seconds).padStart(2, '0');
                }

                updateTimer();
                setInterval(updateTimer, 1000);
            })();
        @endforeach
    </script>
</body>
</html>