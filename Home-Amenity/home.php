<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Amenity - Trusted Home Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        /* ================= RESET ================= */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* ================= NAVBAR ================= */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(10px);
            padding: 12px 5%;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            flex-wrap: wrap;
            gap: 15px;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logo {
            width: 65px;
            height: 48px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 122, 204, 0.25);
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 4px;
        }

        .brand-name {
            font-size: 1.6rem;
            font-weight: 800;
            background: linear-gradient(135deg, #007acc, #009900);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .nav-center {
            display: flex;
            gap: 24px;
            align-items: center;
            flex-wrap: wrap;
        }

        .nav-center a {
            text-decoration: none;
            color: #334155;
            font-weight: 600;
            position: relative;
        }

        .nav-center a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -6px;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #007acc, #009900);
            transition: 0.3s;
            border-radius: 20px;
        }

        .nav-center a:hover::after {
            width: 100%;
        }

        .nav-right {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-login,
        .btn-signup {
            padding: 10px 22px;
            border-radius: 30px;
            border: none;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            white-space: nowrap;
        }

        .btn-login {
            background: white;
            border: 2px solid #e2e8f0;
        }

        .btn-login:hover {
            background: #f0fdf4;
            border-color: #009900;
        }

        .btn-signup {
            background: linear-gradient(135deg, #009900, #007acc);
            color: white;
        }

        .btn-signup:hover {
            transform: translateY(-2px);
        }

        .btn-login a,
        .btn-signup a {
            text-decoration: none;
            color: inherit;
        }

        /* ================= HERO ================= */
        .hero {
            position: relative;
            height: 92vh;
            overflow: hidden;
            border-radius: 0 0 40px 40px;
        }

        .hero-slideshow span {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0;
            animation: slideShow 30s infinite;
        }

        .hero-slideshow span:nth-child(1) {
            background-image: url("images/plumber.jpg");
            animation-delay: 0s;
        }

        .hero-slideshow span:nth-child(2) {
            background-image: url("images/electrician.jpg");
            animation-delay: 6s;
        }

        .hero-slideshow span:nth-child(3) {
            background-image: url("images/painter.jpeg");
            animation-delay: 12s;
        }

        .hero-slideshow span:nth-child(4) {
            background-image: url("images/carpenter.jpg");
            animation-delay: 18s;
        }

        .hero-slideshow span:nth-child(5) {
            background-image: url("images/cleaner.jpg");
            animation-delay: 24s;
        }

        @keyframes slideShow {
            0%, 20% { opacity: 0; }
            10% { opacity: 1; }
            30% { opacity: 1; }
            40% { opacity: 0; }
            100% { opacity: 0; }
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.7));
            z-index: 2;
        }

        .hero-content {
            position: relative;
            z-index: 3;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .hero-content h1 {
            color: white;
            font-size: 4rem;
            max-width: 950px;
            line-height: 1.2;
            font-weight: 800;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        /* ================= FLOATING STATS ================= */
        .floating-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
            padding: 80px 8%;
        }

        .floating-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(14px);
            border-radius: 24px;
            padding: 35px;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        .floating-card:hover {
            transform: translateY(-10px);
        }

        .floating-card h2 {
            font-size: 2.6rem;
            color: #007acc;
            margin-bottom: 8px;
        }

        /* ================= EXPERIENCE ================= */
        .experience-section {
            padding: 100px 8%;
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .mini-badge {
            display: inline-block;
            padding: 8px 18px;
            background: #dff6e8;
            color: #009900;
            border-radius: 30px;
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 0.85rem;
        }

        .experience-left h2 {
            font-size: 3rem;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .experience-left p {
            color: #64748b;
            font-size: 1.05rem;
            margin-bottom: 30px;
        }

        .experience-points {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .point {
            background: white;
            padding: 18px;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            font-weight: 600;
        }

        .point i {
            color: #007acc;
            margin-right: 10px;
        }

        /* ================= GLASS CARD ================= */
        .glass-card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(18px);
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .live-dot {
            width: 12px;
            height: 12px;
            background: #00cc00;
            border-radius: 50%;
            position: absolute;
            top: 25px;
            right: 25px;
            box-shadow: 0 0 12px #00cc00;
        }

        .live-text {
            color: #007acc;
            font-weight: 700;
        }

        .booking-ui {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .booking-item {
            background: white;
            padding: 20px;
            border-radius: 18px;
            display: flex;
            justify-content: space-between;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        /* ================= FEATURE STRIP ================= */
        .feature-strip {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            padding: 20px 8% 100px;
        }

        .strip-card {
            background: white;
            padding: 30px;
            border-radius: 22px;
            text-align: center;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.06);
            transition: 0.3s;
        }

        .strip-card:hover {
            transform: translateY(-8px);
        }

        .strip-card i {
            font-size: 2rem;
            color: #009900;
            margin-bottom: 16px;
        }

        /* ================= CTA ================= */
        .premium-cta {
            padding: 0 8% 100px;
        }

        .cta-content {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: white;
            padding: 80px 50px;
            border-radius: 40px;
            text-align: center;
        }

        .cta-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .cta-content h2 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .cta-content p {
            color: #cbd5e1;
            max-width: 700px;
            margin: 0 auto 35px;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 18px;
            flex-wrap: wrap;
        }

        .cta-primary,
        .cta-secondary {
            padding: 14px 28px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 700;
            white-space: nowrap;
        }

        .cta-primary {
            background: #00b300;
            color: white;
        }

        .cta-secondary {
            background: white;
            color: #0f172a;
        }

        /* ================= FOOTER ================= */
        .modern-footer {
            width: 100%;
            padding: 28px 6%;
            background: white;
            border-top: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        /* LEFT */
        .footer-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .footer-left img {
            width: 50px;
        }

        .footer-left span {
            font-size: 1.3rem;
            font-weight: 800;
            background: linear-gradient(135deg, #007acc, #009900);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* CENTER */
        .footer-center {
            font-size: 1rem;
            color: #64748b;
            font-weight: 600;
            text-align: center;
        }

        /* RIGHT */
        .footer-right {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .feedback-btn {
            padding: 12px 24px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 700;
            background: linear-gradient(135deg, #009900, #007acc);
            color: white;
            transition: 0.3s;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .feedback-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
        }

        /* ================= RESPONSIVE IMPROVEMENTS ================= */

        /* --- Tablet Landscape (≤1024px) --- */
        @media (max-width: 1024px) {
            .hero {
                height: 70vh;
            }

            .hero-content h1 {
                font-size: 3rem;
            }

            .experience-left h2 {
                font-size: 2.4rem;
            }

            .cta-content h2 {
                font-size: 2.4rem;
            }

            .floating-stats {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            }
        }

        /* --- Tablet Portrait (≤900px) --- */
        @media (max-width: 900px) {
            .experience-section {
                grid-template-columns: 1fr;
            }

            .hero-content h1 {
                font-size: 2.6rem;
            }

            .experience-left h2 {
                font-size: 2.3rem;
            }

            .cta-content h2 {
                font-size: 2.2rem;
            }
        }

        /* --- Mobile Landscape (≤768px) --- */
        @media (max-width: 768px) {
            /* Navbar stacks vertically for better readability */
            .navbar {
                flex-direction: column;
                align-items: center;
                padding: 15px 5%;
            }

            .nav-center {
                justify-content: center;
                gap: 20px;
            }

            .nav-right {
                justify-content: center;
            }

            .hero {
                height: 60vh;
            }

            .hero-content h1 {
                font-size: 2.2rem;
                padding: 0 10px;
            }

            .floating-stats {
                grid-template-columns: repeat(2, 1fr);
                padding: 60px 5%;
            }

            .experience-section {
                padding: 80px 5%;
                gap: 40px;
            }

            .feature-strip {
                grid-template-columns: repeat(2, 1fr);
                padding: 0 5% 80px;
            }

            .premium-cta {
                padding: 0 5% 80px;
            }

            .cta-content {
                padding: 60px 30px;
            }

            .cta-content h2 {
                font-size: 2rem;
            }

            /* Footer stacks vertically */
            .modern-footer {
                flex-direction: column;
                text-align: center;
                padding: 30px 20px;
            }

            .footer-left {
                justify-content: center;
            }

            .footer-right {
                justify-content: center;
                width: 100%;
            }

            .footer-center {
                order: 3;
                width: 100%;
            }
        }

        /* --- Mobile (≤600px) --- */
        @media (max-width: 600px) {
            .experience-points {
                grid-template-columns: 1fr;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .cta-content {
                padding: 50px 25px;
            }

            .btn-login,
            .btn-signup {
                padding: 10px 18px;
                font-size: 0.9rem;
            }

            .nav-center {
                gap: 15px;
            }
        }

        /* --- Small Mobile (≤480px) --- */
        @media (max-width: 480px) {
            .footer-left span {
                font-size: 1.1rem;
            }

            .feedback-btn {
                width: 100%;
                text-align: center;
            }

            .footer-right {
                width: 100%;
            }

            .floating-stats {
                grid-template-columns: 1fr;
            }

            .feature-strip {
                grid-template-columns: 1fr;
            }

            .hero {
                height: 55vh;
            }

            .hero-content h1 {
                font-size: 1.8rem;
            }

            .brand-name {
                font-size: 1.3rem;
            }

            .logo {
                width: 50px;
                height: 38px;
            }
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="nav-left">
            <div class="logo">
                <img src="images/Home.png" alt="logo">
            </div>
            <div class="brand-name">Home Amenity</div>
        </div>
        <div class="nav-center">
            <a href="home.php">Home</a>
            <a href="services.php">All Services</a>
        </div>
        <div class="nav-right">
            <button class="btn-login">
                <a href="login.php"><i class="fas fa-user"></i> Login/Signin</a>
            </button>
            <button class="btn-signup">
                <a href="worker.php">Become a Tasker</a>
            </button>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-slideshow">
            <span></span><span></span><span></span><span></span><span></span>
        </div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>BOOK YOUR TRUSTED TASKER FOR HOME TASKS</h1>
        </div>
    </section>

    <!-- FLOATING STATS -->
    <section class="floating-stats">
        <div class="floating-card"><h2>15K+</h2><p>Monthly Bookings</p></div>
        <div class="floating-card"><h2>4.9★</h2><p>Customer Rating</p></div>
        <div class="floating-card"><h2>500+</h2><p>Verified Taskers</p></div>
        <div class="floating-card"><h2>24/7</h2><p>Service Support</p></div>
    </section>

    <!-- EXPERIENCE -->
    <section class="experience-section">
        <div class="experience-left">
            <span class="mini-badge">NEXT GENERATION HOME SERVICES</span>
            <h2>Seamless Booking Experience For Modern Homes</h2>
            <p>Home Amenity connects customers with trusted professionals through a clean and fast digital experience.</p>
            <div class="experience-points">
                <div class="point"><i class="fas fa-shield-alt"></i> Verified workers only</div>
                <div class="point"><i class="fas fa-location-dot"></i> Nearby smart matching</div>
                <div class="point"><i class="fas fa-comments"></i> Real-time customer chat</div>
                <div class="point"><i class="fas fa-star"></i> Transparent reviews</div>
            </div>
        </div>
        <div class="experience-right">
            <div class="glass-card">
                <div class="live-dot"></div>
                <span class="live-text">LIVE BOOKINGS</span>
                <div class="booking-ui">
                    <div class="booking-item"><span>Electrician</span><strong>Booked</strong></div>
                    <div class="booking-item"><span>Cleaner</span><strong>Available</strong></div>
                    <div class="booking-item"><span>Painter</span><strong>Nearby</strong></div>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURE STRIP -->
    <section class="feature-strip">
        <div class="strip-card"><i class="fas fa-bolt"></i><h3>Fast Booking</h3></div>
        <div class="strip-card"><i class="fas fa-user-check"></i><h3>Trusted Experts</h3></div>
        <div class="strip-card"><i class="fas fa-mobile-screen"></i><h3>Modern Experience</h3></div>
        <div class="strip-card"><i class="fas fa-clock"></i><h3>Quick Response</h3></div>
    </section>

    <!-- CTA -->
    <section class="premium-cta">
        <div class="cta-content">
            <span class="cta-badge">JOIN HOME AMENITY</span>
            <h2>Find Trusted Help Without The Hassle</h2>
            <p>Book skilled workers in minutes with a premium, modern and reliable platform.</p>
            <div class="cta-buttons">
                <a href="services.php" class="cta-primary">Explore Services</a>
                <a href="worker.php" class="cta-secondary">Become a Tasker</a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="modern-footer">
        <div class="footer-left">
            <img src="images/Home.png" alt="logo">
            <span>Home Amenity</span>
        </div>
        <div class="footer-center">Smart Home Services Platform-2026</div>
        <div class="footer-right">
            <a href="form.php" class="feedback-btn">Feedback</a>
        </div>
    </footer>
</body>
</html>