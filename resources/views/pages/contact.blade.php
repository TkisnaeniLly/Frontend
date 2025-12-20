@extends('layouts.app')

@section('content')
    <div class="contact-container">
        <div class="contact-header">
            <h1 class="contact-title">Contact Us</h1>
            <p class="contact-subtitle">We'd love to hear from you</p>
        </div>

        <div class="contact-grid">
            <!-- Contact Info -->
            <div class="contact-info">
                <div class="info-card">
                    <i class="fas fa-map-marker-alt"></i>
                    <h3>Visit Us</h3>
                    <p>123 Fashion Street,<br>Jakarta Selatan, 12345</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-envelope"></i>
                    <h3>Email Us</h3>
                    <p>hello@tishop.com<br>support@tishop.com</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-phone"></i>
                    <h3>Call Us</h3>
                    <p>+62 812 3456 7890<br>Mon-Fri, 9am - 6pm</p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-container">
                <form class="contact-form"
                    onsubmit="event.preventDefault(); showToast('success', 'Message Sent', 'We will get back to you soon!'); this.reset();">
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-input" required placeholder="Your Name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-input" required placeholder="your@email.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Message</label>
                        <textarea class="form-input" rows="5" required placeholder="How can we help?"></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Send Message</button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .contact-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 120px 20px 80px;
        }

        .contact-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .contact-title {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .contact-subtitle {
            color: var(--text-secondary);
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 50px;
        }

        @media (max-width: 768px) {
            .contact-grid {
                grid-template-columns: 1fr;
            }
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .info-card {
            background: var(--bg-card);
            padding: 30px;
            border-radius: 12px;
            text-align: center;
        }

        .info-card i {
            font-size: 2rem;
            color: var(--rose);
            margin-bottom: 15px;
        }

        .info-card h3 {
            margin-bottom: 10px;
            font-size: 1.2rem;
        }

        .info-card p {
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .contact-form-container {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }
    </style>
@endsection
