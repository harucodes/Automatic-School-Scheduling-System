<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Automated Class Scheduling System</title>
    <style>
        :root {
            --maroon: #9b1a1a;
            --maroon-dark: #5e1010;
            --maroon-light: #f5e8e8;
            --mustard: #ffc438;
            --mustard-dark: #e6b032;
            --bg: #f8fafc;
            --text: #334155;
            --text-light: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        header {
            padding: 1.5rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: rgba(155, 26, 26, 0.9);
            backdrop-filter: blur(8px);
            position: sticky;
            top: 0;
            z-index: 10;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            letter-spacing: -0.5px;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        nav {
            display: flex;
            gap: 1.5rem;
        }

        nav a {
            text-decoration: none;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            padding: 0.5rem 0;
        }

        nav a:hover {
            color: var(--mustard);
        }

        nav a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--mustard);
            transition: width 0.3s ease;
        }

        nav a:hover::after {
            width: 100%;
        }

        .hero {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem 5%;
            text-align: center;
            color: white;
        }

        .hero-content {
            max-width: 800px;
            animation: fadeIn 1s ease-out;
            background-color: rgba(155, 26, 26, 0.85);
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .hero h1 {
            font-size: 2.75rem;
            margin-bottom: 1.5rem;
            font-weight: 800;
            line-height: 1.2;
            color: white;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }

        .hero p {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2.5rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta {
            display: inline-block;
            background: linear-gradient(to right, var(--mustard), var(--mustard-dark));
            color: var(--maroon-dark);
            padding: 0.9rem 2.25rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 196, 56, 0.3);
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 196, 56, 0.4);
            color: var(--maroon);
        }

        .cta:active {
            transform: translateY(0);
        }

        .cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: 0.5s;
        }

        .cta:hover::before {
            left: 100%;
        }

        .features {
            display: flex;
            justify-content: center;
            gap: 2rem;
            padding: 3rem 5%;
            flex-wrap: wrap;
        }

        .feature-card {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            text-align: center;
            border-top: 4px solid var(--mustard);
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-card h3 {
            color: var(--maroon);
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: var(--text-light);
        }

        footer {
            text-align: center;
            padding: 1.5rem;
            font-size: 0.9rem;
            color: white;
            background-color: rgba(155, 26, 26, 0.9);
            backdrop-filter: blur(8px);
        }

        @media (max-width: 768px) {
            header {
                padding: 1rem 5%;
            }

            nav {
                gap: 1rem;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .hero-content {
                padding: 2rem;
            }

            .features {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">Class Scheduler</div>
        <nav>
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Automated Class Scheduling System</h1>
            <p>Intelligently plan and organize your academic schedule with our automated system. Eliminate conflicts and save time with smart scheduling designed for educational excellence.</p>
            <a href="/register" class="cta">Get Started</a>
        </div>
    </section>

    <div class="features">
        <div class="feature-card">
            <h3>Smart Scheduling</h3>
            <p>Our algorithm automatically creates conflict-free schedules based on your preferences and constraints.</p>
        </div>
        <div class="feature-card">
            <h3>Real-time Updates</h3>
            <p>Get instant notifications about schedule changes and room assignments.</p>
        </div>
        <div class="feature-card">
            <h3>Easy Management</h3>
            <p>Simple interface for administrators to manage courses, rooms, and faculty assignments.</p>
        </div>
    </div>

    <footer>
        &copy; 2025 Automated Class Scheduling System. All rights reserved.
    </footer>
</body>

</html>