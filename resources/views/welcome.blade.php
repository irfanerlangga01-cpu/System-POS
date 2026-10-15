<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rohman Percetakan dan Fotokopi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #0D5EFF;
            --primary-dark: #0A4EDC;
            --dark-navy: #070B2B;
            --light-gray: #F5F7FC;
            --text-gray: #6B7280;
            --white: #FFFFFF;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light-gray);
            color: var(--text-gray);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: var(--white);
            box-shadow: 0 2px 20px rgba(7, 11, 43, 0.1);
            z-index: 1000;
        }
        
        .navbar .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
        }
        
        .logo {
            display: flex;
            flex-direction: column;
        }
        
        .logo-text {
            font-size: 24px;
            font-weight: 800;
            color: var(--dark-navy);
            letter-spacing: -0.5px;
        }
        
        .logo-sub {
            font-size: 12px;
            color: var(--text-gray);
            font-weight: 400;
        }
        
        .nav-menu {
            display: flex;
            gap: 40px;
        }
        
        .nav-menu a {
            color: var(--dark-navy);
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: color 0.3s;
        }
        
        .nav-menu a:hover {
            color: var(--primary);
        }
        
        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .nav-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--light-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-navy);
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .nav-icon:hover {
            background: var(--primary);
            color: var(--white);
        }
        
        .btn-consult {
            background: var(--primary);
            color: var(--white);
            padding: 12px 24px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(13, 94, 255, 0.3);
        }
        
        .btn-consult:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 94, 255, 0.4);
        }
        
        /* Hero Section */
        .hero {
            height: 700px;
            position: relative;
            margin-top: 80px;
            display: flex;
            align-items: center;
        }
        
        .hero-bg {
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=900&w=1600&q=80') center/cover;
        }
        
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, var(--dark-navy) 0%, transparent 100%);
        }
        
        .hero-content {
            position: relative;
            z-index: 10;
            max-width: 500px;
        }
        
        .hero-badge {
            display: inline-block;
            background: rgba(255,255,255,0.1);
            color: var(--white);
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }
        
        .hero-title {
            font-size: 56px;
            font-weight: 800;
            color: var(--white);
            line-height: 1.1;
            margin-bottom: 20px;
        }
        
        .hero-title span {
            display: block;
        }
        
        .hero-desc {
            color: rgba(255,255,255,0.8);
            font-size: 16px;
            margin-bottom: 30px;
            max-width: 400px;
        }
        
        .btn-primary {
            background: var(--primary);
            color: var(--white);
            padding: 16px 40px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(13, 94, 255, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 94, 255, 0.4);
        }
        
        .hero-nav {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 15px;
        }
        
        .nav-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255,255,255,0.4);
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .nav-dot.active {
            background: var(--primary);
            transform: scale(1.3);
        }
        
        /* Section */
        .section {
            padding: 100px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-badge {
            display: inline-block;
            background: var(--primary);
            color: var(--white);
            padding: 6px 20px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }
        
        .section-heading {
            font-size: 42px;
            font-weight: 800;
            color: var(--dark-navy);
            line-height: 1.2;
        }
        
        .section-heading span {
            display: block;
        }
        
        /* Services Intro */
        .services-intro {
            background: var(--white);
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        
        .service-card {
            background: var(--white);
            border: 1px solid #E5E7EB;
            border-radius: 16px;
            padding: 30px 20px;
            text-align: center;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(7, 11, 43, 0.05);
        }
        
        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(7, 11, 43, 0.1);
        }
        
        .service-card.active {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
        }
        
        .service-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--primary);
        }
        
        .service-card.active .service-icon {
            color: var(--white);
        }
        
        .service-card h4 {
            font-size: 16px;
            font-weight: 600;
            color: var(--dark-navy);
        }
        
        .service-card.active h4 {
            color: var(--white);
        }
        
        /* Dark CTA */
        .dark-cta {
            position: relative;
            background: url('https://images.unsplash.com/photo-1552664730-d307ca884978?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=700&w=1600&q=80') center/cover;
            padding: 120px 0;
        }
        
        .dark-cta::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--dark-navy);
            opacity: 0.85;
        }
        
        .dark-cta .container {
            position: relative;
            z-index: 10;
        }
        
        .cta-box {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 50px;
            max-width: 400px;
        }
        
        .cta-box h3 {
            font-size: 32px;
            font-weight: 800;
            color: var(--white);
            line-height: 1.2;
            margin-bottom: 20px;
        }
        
        .cta-box h3 span {
            display: block;
        }
        
        /* Services Grid */
        .services-section {
            background: var(--white);
        }
        
        .services-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }
        
        .service-item {
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(7, 11, 43, 0.08);
            transition: all 0.3s;
        }
        
        .service-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(7, 11, 43, 0.15);
        }
        
        .service-img {
            height: 180px;
            overflow: hidden;
        }
        
        .service-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .service-item:hover .service-img img {
            transform: scale(1.1);
        }
        
        .service-content {
            padding: 25px;
        }
        
        .service-content h4 {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark-navy);
            margin-bottom: 10px;
        }
        
        .service-content p {
            font-size: 14px;
            color: var(--text-gray);
            margin-bottom: 15px;
        }
        
        .service-content .btn-outline {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
        }
        
        /* Footer */
        .footer {
            background: var(--dark-navy);
            color: var(--text-gray);
            padding: 80px 0 30px;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 50px;
        }
        
        .footer-logo {
            font-size: 28px;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 15px;
        }
        
        .footer-desc {
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .footer-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 20px;
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 12px;
        }
        
        .footer-links a {
            color: var(--text-gray);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: var(--primary);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
            text-align: center;
            font-size: 13px;
            color: var(--text-gray);
        }
        
        @media (max-width: 992px) {
            .services-grid { grid-template-columns: repeat(2, 1fr); }
            .services-cards { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .hero-title { font-size: 42px; }
        }
        
        @media (max-width: 768px) {
            .nav-menu { display: none; }
            .section { padding: 60px 0; }
            .hero { height: 500px; }
            .hero-title { font-size: 32px; }
            .services-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <div class="logo-text">OmniVus.</div>
                <div class="logo-sub">IT Solutions Business</div>
            </div>
            
            <div class="nav-menu">
                <a href="#">Home</a>
                <a href="#">Company</a>
                <a href="#">Blog</a>
                <a href="#">Portfolio</a>
                <a href="#">Shop</a>
                <a href="#">Contacts</a>
            </div>
            
            <div class="nav-right">
                <div class="nav-icon">
                    <i class="fas fa-search"></i>
                </div>
                <div class="nav-icon">
                    <i class="fas fa-bars"></i>
                </div>
                <a href="#" class="btn-consult">Free Consultation</a>
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge">IT Business Consulting</div>
                <h1 class="hero-title">
                    Best IT Solutions<br>
                    <span>Provider Agency</span>
                </h1>
                <p class="hero-desc">
                    We provide innovative IT solutions for your business growth and transformation.
                </p>
                <a href="#" class="btn-primary">Our Services</a>
            </div>
            <div class="hero-nav">
                <div class="nav-dot"></div>
                <div class="nav-dot active"></div>
                <div class="nav-dot"></div>
            </div>
        </div>
    </section>
    
    <!-- Services Intro -->
    <section class="section services-intro">
        <div class="container">
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h4>IT Solutions</h4>
                </div>
                <div class="service-card active">
                    <div class="service-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4>Security System</h4>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <h4>Web Development</h4>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h4>Database & Security</h4>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Dark CTA -->
    <section class="dark-cta">
        <div class="container">
            <div class="cta-box">
                <h3>
                    Get Better Solution<br>
                    <span>For Your Business</span>
                </h3>
            </div>
        </div>
    </section>
    
    <!-- Services Grid -->
    <section class="section services-section">
        <div class="container">
            <div class="section-title">
                <div class="section-badge">WHAT WE OFFER</div>
                <h2 class="section-heading">
                    We Offer Better Solution<br>
                    <span>For Your IT Business</span>
                </h2>
            </div>
            
            <div class="services-cards">
                <div class="service-item">
                    <div class="service-img">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=300&w=400&q=80" alt="Service">
                    </div>
                    <div class="service-content">
                        <h4>Web Development</h4>
                        <p>Custom web applications built with modern technologies for your business.</p>
                        <a href="#" class="btn-outline">Read More →</a>
                    </div>
                </div>
                
                <div class="service-item">
                    <div class="service-img">
                        <img src="https://images.unsplash.com/photo-1512941857-6383e226293d?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=300&w=400&q=80" alt="Service">
                    </div>
                    <div class="service-content">
                        <h4>Mobile Apps</h4>
                        <p>Native and cross-platform mobile solutions for your customers.</p>
                        <a href="#" class="btn-outline">Read More →</a>
                    </div>
                </div>
                
                <div class="service-item">
                    <div class="service-img">
                        <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=300&w=400&q=80" alt="Service">
                    </div>
                    <div class="service-content">
                        <h4>Cloud Services</h4>
                        <p>Secure and scalable cloud infrastructure for modern business.</p>
                        <a href="#" class="btn-outline">Read More →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="footer-logo">OmniVus.</div>
                    <p class="footer-desc">
                        We provide comprehensive IT solutions that drive business growth and innovation. 
                        Our expert team delivers cutting-edge technology services tailored to your needs.
                    </p>
                </div>
                
                <div>
                    <h4 class="footer-title">Our Services</h4>
                    <ul class="footer-links">
                        <li><a href="#">Web Development</a></li>
                        <li><a href="#">Mobile Apps</a></li>
                        <li><a href="#">Cloud Services</a></li>
                        <li><a href="#">UI/UX Design</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="footer-title">Recent News</h4>
                    <ul class="footer-links">
                        <li><a href="#">Latest Updates</a></li>
                        <li><a href="#">Tech Insights</a></li>
                        <li><a href="#">Case Studies</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="footer-title">Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Login</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                © 2024 OmniVus IT Solutions. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>