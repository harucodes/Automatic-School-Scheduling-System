<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Automated Class Scheduling System</title>
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
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
            background-color: var(--bg);
            color: var(--text);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            position: sticky;
            top: 0;
            z-index: 10;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
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
            color: var(--text-light);
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        nav a:hover {
            color: var(--primary);
        }

        nav a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary);
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
        }

        .hero-content {
            max-width: 700px;
            animation: fadeIn 1s ease-out;
        }

        .hero h1 {
            font-size: 2.75rem;
            margin-bottom: 1.5rem;
            font-weight: 800;
            line-height: 1.2;
            background: linear-gradient(to right, var(--primary), #7c3aed);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero p {
            font-size: 1.25rem;
            color: var(--text-light);
            margin-bottom: 2.5rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta {
            display: inline-block;
            background: linear-gradient(to right, var(--primary), var(--primary-dark));
            color: white;
            padding: 0.9rem 2.25rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(99, 102, 241, 0.2);
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(99, 102, 241, 0.3);
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
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .cta:hover::before {
            left: 100%;
        }

        footer {
            text-align: center;
            padding: 1.5rem;
            font-size: 0.9rem;
            color: var(--text-light);
            background-color: rgba(255, 255, 255, 0.8);
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
            <p>Intelligently plan and organize your academic schedule with our automated system. Eliminate conflicts and save time with smart scheduling.</p>
            <a href="/register" class="cta">Get Started</a>
        </div>
    </section>

    <footer>
        &copy; 2025 Automated Class Scheduling System. All rights reserved.
    </footer>
</body>

</html>