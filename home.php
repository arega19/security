<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JoeStudy - Smart Study Planning Made Easy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* ===== HEADER ===== */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e1e5e9;
            z-index: 1000;
            padding: 15px 0;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            color: #667eea;
            text-decoration: none;
        }

        .logo span {
            color: #764ba2;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #667eea;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
        }

        /* ===== HERO SECTION ===== */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 120px 20px 80px;
            text-align: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 40px;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: white;
            color: #667eea;
            padding: 15px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            padding: 15px 30px;
            border: 2px solid white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: white;
            color: #667eea;
        }

        /* ===== ABOUT SECTION ===== */
        .about {
            padding: 100px 20px;
            background: #f8f9fa;
        }

        .section-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
        }

        .section-header p {
            font-size: 1.2rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        .about-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            align-items: center;
        }

        .about-text {
            padding-right: 40px;
        }

        .about-text h3 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .about-text p {
            font-size: 1.1rem;
            line-height: 1.7;
            color: #666;
            margin-bottom: 20px;
        }

        .about-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .feature-text h4 {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .feature-text p {
            color: #666;
            font-size: 0.9rem;
        }

        /* ===== WHY CHOOSE US ===== */
        .why-choose {
            padding: 100px 20px;
            background: white;
        }

        .why-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
        }

        .why-item {
            text-align: center;
            padding: 40px 20px;
            border-radius: 15px;
            background: #f8f9fa;
            transition: transform 0.3s ease;
        }

        .why-item:hover {
            transform: translateY(-5px);
        }

        .why-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin: 0 auto 20px;
        }

        .why-item h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        .why-item p {
            color: #666;
            line-height: 1.6;
        }

        /* ===== PLANS SECTION ===== */
        .plans {
            padding: 100px 20px;
            background: #f8f9fa;
        }

        .plans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .plan-card {
            background: white;
            border-radius: 15px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            position: relative;
        }

        .plan-card:hover {
            transform: translateY(-5px);
        }

        .plan-card.popular {
            border: 3px solid #667eea;
            transform: scale(1.05);
        }

        .plan-card.popular::before {
            content: 'Most Popular';
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            background: #667eea;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .plan-name {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #333;
        }

        .plan-price {
            font-size: 3rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 20px;
        }

        .plan-price span {
            font-size: 1rem;
            color: #666;
        }

        .plan-features {
            list-style: none;
            margin-bottom: 30px;
        }

        .plan-features li {
            padding: 8px 0;
            color: #666;
            border-bottom: 1px solid #eee;
        }

        .plan-features li::before {
            content: '✓';
            color: #4CAF50;
            font-weight: bold;
            margin-right: 10px;
        }

        /* ===== TIPS SECTION ===== */
        .tips {
            padding: 100px 20px;
            background: white;
        }

        .tips-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
        }

        .tip-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 30px;
            transition: transform 0.3s ease;
        }

        .tip-card:hover {
            transform: translateY(-5px);
        }

        .tip-number {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .tip-card h3 {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        .tip-card p {
            color: #666;
            line-height: 1.6;
        }

        /* ===== SIGNUP SECTION ===== */
        .signup-section {
            padding: 100px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
        }

        .signup-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .signup-section h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .signup-section p {
            font-size: 1.2rem;
            margin-bottom: 40px;
            opacity: 0.9;
        }

        .signup-form {
            display: flex;
            gap: 15px;
            max-width: 500px;
            margin: 0 auto;
            flex-wrap: wrap;
        }

        .signup-input {
            flex: 1;
            min-width: 250px;
            padding: 15px 20px;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
        }

        /* ===== FOOTER ===== */
        .footer {
            background: #2c3e50;
            color: white;
            padding: 60px 20px 30px;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-section h3 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #fff;
        }

        .footer-section p {
            color: #bdc3c7;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #667eea;
        }

        .footer-bottom {
            border-top: 1px solid #34495e;
            padding-top: 30px;
            text-align: center;
            color: #95a5a6;
        }

        .social-links {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-bottom: 20px;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: #34495e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .social-links a:hover {
            background: #667eea;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }

            .nav-links {
                display: none;
            }

            .plans-grid {
                grid-template-columns: 1fr;
            }

            .plan-card.popular {
                transform: none;
            }

            .signup-form {
                flex-direction: column;
            }

            .signup-input {
                min-width: auto;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="nav-container">
            <a href="#" class="logo">Joe<span>Study</span></a>
            <nav class="nav-links">
                <a href="#about">About</a>
                <a href="#why">Why Choose Us</a>
                <a href="#plans">Plans</a>
                <a href="#tips">Tips</a>
                <a href="login.php" class="btn-login">Login</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <h1>Master Your Studies with Smart Planning</h1>
            <p>Transform your study habits with our AI-powered planner. Track progress, stay focused, and achieve your academic goals with ease.</p>
            <div class="hero-buttons">
                <a href="signup.php" class="btn-primary">Start Free Trial</a>
                <a href="#about" class="btn-secondary">Learn More</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="section-container">
            <div class="section-header">
                <h2>About JoeStudy</h2>
                <p>Revolutionizing the way students organize and optimize their learning experience</p>
            </div>

            <div class="about-content">
                <div class="about-text">
                    <h3>Smart Study Planning Made Simple</h3>
                    <p>JoeStudy combines cutting-edge technology with proven study techniques to help you maximize your learning potential. Our platform adapts to your unique study style and helps you build better habits for long-term success.</p>
                    <p>Whether you're preparing for exams, learning new skills, or managing multiple subjects, JoeStudy provides the tools and insights you need to study smarter, not harder.</p>

                    <div class="about-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-brain"></i>
                            </div>
                            <div class="feature-text">
                                <h4>AI-Powered Insights</h4>
                                <p>Get personalized recommendations based on your study patterns</p>
                            </div>
                        </div>

                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="feature-text">
                                <h4>Progress Tracking</h4>
                                <p>Monitor your improvement with detailed analytics and reports</p>
                            </div>
                        </div>

                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="feature-text">
                                <h4>Pomodoro Timer</h4>
                                <p>Stay focused with built-in time management techniques</p>
                            </div>
                        </div>

                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="feature-text">
                                <h4>Community Support</h4>
                                <p>Connect with fellow students and share study strategies</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="about-image">
                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjZjhmOWZhIi8+CjxjaXJjbGUgY3g9IjIwMCIgY3k9IjE1MCIgcj0iNDAiIGZpbGw9IiM2NjdlZWEiLz4KPHA+PC9wPgo8L3N2Zz4K" alt="Study Planning" style="width: 100%; border-radius: 15px;">
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section id="why" class="why-choose">
        <div class="section-container">
            <div class="section-header">
                <h2>Why Choose JoeStudy?</h2>
                <p>Discover what makes our platform the perfect companion for your academic journey</p>
            </div>

            <div class="why-grid">
                <div class="why-item">
                    <div class="why-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3>Accelerated Learning</h3>
                    <p>Our data-driven approach helps you identify the most effective study methods for your learning style, potentially reducing study time by up to 40%.</p>
                </div>

                <div class="why-item">
                    <div class="why-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Secure & Private</h3>
                    <p>Your data is encrypted and stored securely. We never share your personal information or study data with third parties.</p>
                </div>

                <div class="why-item">
                    <div class="why-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Cross-Platform</h3>
                    <p>Access your study plans from any device. Our responsive design works perfectly on desktop, tablet, and mobile devices.</p>
                </div>

                <div class="why-item">
                    <div class="why-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3>Proven Results</h3>
                    <p>Join thousands of successful students who have improved their grades and study efficiency using our platform.</p>
                </div>

                <div class="why-item">
                    <div class="why-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>24/7 Support</h3>
                    <p>Our dedicated support team is always ready to help you make the most of your study planning experience.</p>
                </div>

                <div class="why-item">
                    <div class="why-icon">
                        <i class="fas fa-sync"></i>
                    </div>
                    <h3>Always Improving</h3>
                    <p>We continuously update our platform with the latest research in learning science and user feedback.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Plans Section -->
    <section id="plans" class="plans">
        <div class="section-container">
            <div class="section-header">
                <h2>Choose Your Plan</h2>
                <p>Start free and upgrade as you grow. All plans include our core study planning features.</p>
            </div>

            <div class="plans-grid">
                <div class="plan-card">
                    <div class="plan-name">Free</div>
                    <div class="plan-price">$0<span>/month</span></div>
                    <ul class="plan-features">
                        <li>Basic task management</li>
                        <li>Simple Pomodoro timer</li>
                        <li>Basic progress tracking</li>
                        <li>Community access</li>
                        <li>Email support</li>
                    </ul>
                    <a href="signup.php" class="btn-primary">Get Started</a>
                </div>

                <div class="plan-card popular">
                    <div class="plan-name">Pro</div>
                    <div class="plan-price">$9.99<span>/month</span></div>
                    <ul class="plan-features">
                        <li>Everything in Free</li>
                        <li>Advanced analytics</li>
                        <li>Custom study plans</li>
                        <li>Resource library</li>
                        <li>Priority support</li>
                        <li>Export reports</li>
                    </ul>
                    <a href="signup.php" class="btn-primary">Start Pro Trial</a>
                </div>

                <div class="plan-card">
                    <div class="plan-name">Premium</div>
                    <div class="plan-price">$19.99<span>/month</span></div>
                    <ul class="plan-features">
                        <li>Everything in Pro</li>
                        <li>AI study recommendations</li>
                        <li>Unlimited resources</li>
                        <li>Team collaboration</li>
                        <li>White-label option</li>
                        <li>Phone support</li>
                    </ul>
                    <a href="signup.php" class="btn-primary">Go Premium</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Study Tips Section -->
    <section id="tips" class="tips">
        <div class="section-container">
            <div class="section-header">
                <h2>Best Study Tips for Success</h2>
                <p>Maximize your learning potential with these proven study strategies</p>
            </div>

            <div class="tips-grid">
                <div class="tip-card">
                    <div class="tip-number">1</div>
                    <h3>Set Clear Goals</h3>
                    <p>Define specific, measurable study objectives for each session. Break down large goals into smaller, achievable tasks to maintain motivation and track progress effectively.</p>
                </div>

                <div class="tip-card">
                    <div class="tip-number">2</div>
                    <h3>Use Active Recall</h3>
                    <p>Test yourself regularly instead of just re-reading notes. Active recall strengthens memory retention and helps identify areas that need more attention.</p>
                </div>

                <div class="tip-card">
                    <div class="tip-number">3</div>
                    <h3>Space Your Learning</h3>
                    <p>Distribute your study sessions over time rather than cramming. Spaced repetition helps move information from short-term to long-term memory.</p>
                </div>

                <div class="tip-card">
                    <div class="tip-number">4</div>
                    <h3>Create Mind Maps</h3>
                    <p>Visualize connections between concepts using mind maps. This technique helps you understand relationships and improves information retention.</p>
                </div>

                <div class="tip-card">
                    <div class="tip-number">5</div>
                    <h3>Teach Others</h3>
                    <p>Explain concepts to someone else or even to an imaginary audience. Teaching reinforces your understanding and reveals knowledge gaps.</p>
                </div>

                <div class="tip-card">
                    <div class="tip-number">6</div>
                    <h3>Get Enough Sleep</h3>
                    <p>Prioritize quality sleep for optimal brain function. Sleep consolidates memories and improves problem-solving abilities.</p>
                </div>

                <div class="tip-card">
                    <div class="tip-number">7</div>
                    <h3>Stay Hydrated & Exercise</h3>
                    <p>Maintain proper hydration and incorporate regular physical activity. Both are crucial for cognitive function and concentration.</p>
                </div>

                <div class="tip-card">
                    <div class="tip-number">8</div>
                    <h3>Minimize Distractions</h3>
                    <p>Create a dedicated study environment free from distractions. Use focus techniques like the Pomodoro method to maintain concentration.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Signup Section -->
    <section class="signup-section">
        <div class="signup-container">
            <h2>Ready to Transform Your Study Habits?</h2>
            <p>Join thousands of students who are already studying smarter with JoeStudy. Start your free trial today and experience the difference.</p>

            <form class="signup-form" action="signup.php" method="GET">
                <input type="email" class="signup-input" placeholder="Enter your email address" required>
                <button type="submit" class="btn-primary" style="padding: 15px 30px;">Start Free Trial</button>
            </form>

            <p style="margin-top: 20px; opacity: 0.8;">No credit card required • 14-day free trial • Cancel anytime</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>JoeStudy</h3>
                    <p>Empowering students worldwide with intelligent study planning tools. Transform your academic performance with data-driven insights and proven techniques.</p>
                </div>

                <div class="footer-section">
                    <h3>Product</h3>
                    <ul class="footer-links">
                        <li><a href="#features">Features</a></li>
                        <li><a href="#plans">Pricing</a></li>
                        <li><a href="#tips">Study Tips</a></li>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="signup.php">Sign Up</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Company</h3>
                    <ul class="footer-links">
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="#careers">Careers</a></li>
                        <li><a href="#blog">Blog</a></li>
                        <li><a href="#press">Press</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Support</h3>
                    <ul class="footer-links">
                        <li><a href="#help">Help Center</a></li>
                        <li><a href="#community">Community</a></li>
                        <li><a href="#tutorials">Tutorials</a></li>
                        <li><a href="#api">API Docs</a></li>
                        <li><a href="#status">System Status</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
                <p>&copy; 2024 JoeStudy. All rights reserved. | <a href="#privacy" style="color: #95a5a6;">Privacy Policy</a> | <a href="#terms" style="color: #95a5a6;">Terms of Service</a></p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Header background on scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });

        // Animate elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Add animation to cards
        document.querySelectorAll('.why-item, .plan-card, .tip-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    </script>
</body>
</html>