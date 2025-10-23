<?php
session_start();

// If user is already logged in, redirect to quiz
if (isset($_SESSION['user_id'])) {
    header("Location: quiz.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime Quiz System - Welcome</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Orbitron', monospace;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #667eea, #764ba2, #f093fb, #f5576c);
            background-size: 400% 400%;
            animation: gradientWave 8s ease infinite;
            z-index: -2;
        }

        /* Floating Geometric Shapes */
        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.3) 0%, transparent 50%);
            animation: floatingShapes 12s ease-in-out infinite;
            z-index: -1;
        }

        @keyframes gradientWave {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        @keyframes floatingShapes {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            padding: 60px 40px;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 90%;
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shine 3s linear infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .logo {
            font-family: 'Press Start 2P', cursive;
            font-size: 2.5rem;
            color: #fff;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.8);
            margin-bottom: 20px;
            animation: textGlow 2s ease-in-out infinite alternate;
        }

        @keyframes textGlow {
            0% { text-shadow: 0 0 20px rgba(255, 255, 255, 0.8); }
            100% { text-shadow: 0 0 30px rgba(255, 255, 255, 1), 0 0 40px rgba(120, 119, 198, 0.8); }
        }

        .welcome-text {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 40px;
            line-height: 1.6;
            font-weight: 400;
        }

        .welcome-text .highlight {
            color: #ffd700;
            font-weight: 700;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
        }

        .button-container {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 40px;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 50px;
            font-family: 'Orbitron', monospace;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            min-width: 150px;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            color: white;
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .btn:active {
            transform: translateY(-1px) scale(1.02);
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .features {
            margin-top: 50px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
        }

        .feature {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .feature:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
        }

        .feature-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            display: block;
        }

        .feature-title {
            font-size: 0.9rem;
            color: #fff;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .feature-desc {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
        }

        /* Floating Bubbles */
        .bubbles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .bubble {
            position: absolute;
            bottom: -100px;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: bubbleFloat 6s infinite linear;
        }

        .bubble:nth-child(1) { left: 10%; animation-delay: 0s; }
        .bubble:nth-child(2) { left: 20%; animation-delay: 2s; }
        .bubble:nth-child(3) { left: 35%; animation-delay: 4s; }
        .bubble:nth-child(4) { left: 50%; animation-delay: 0s; }
        .bubble:nth-child(5) { left: 70%; animation-delay: 3s; }
        .bubble:nth-child(6) { left: 85%; animation-delay: 1s; }

        @keyframes bubbleFloat {
            0% {
                bottom: -100px;
                transform: translateX(0);
            }
            100% {
                bottom: 100vh;
                transform: translateX(100px);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 40px 20px;
                margin: 20px;
            }

            .logo {
                font-size: 2rem;
            }

            .welcome-text {
                font-size: 1rem;
            }

            .button-container {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 250px;
            }

            .features {
                grid-template-columns: 1fr;
            }
        }

        /* Loading Animation */
        .loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top: 3px solid #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Floating Bubbles -->
    <div class="bubbles">
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
    </div>

    <div class="container">
        <h1 class="logo">⚡ONLINE QUIZ SYSTEM ⚡</h1>
        
        <div class="welcome-text">
            Welcome to the most <span class="highlight">epic quiz experience</span> ever created! 
            <br><br>
            Test your knowledge with our <span class="highlight">anime-style interface</span> 
            <br><br>
            Join thousands of users who have already discovered the future of online learning!
        </div>

        <div class="button-container">
            <a href="login.php" class="btn btn-primary" onclick="showLoading()">
                🚀 LOGIN
            </a>
            <a href="register.php" class="btn btn-secondary" onclick="showLoading()">
                ✨ REGISTER
            </a>
        </div>

        <div class="features">
            <div class="feature">
                <span class="feature-icon">🎯</span>
                <div class="feature-title">Smart Quizzes</div>
                <div class="feature-desc">Intelligent question selection</div>
            </div>
            <div class="feature">
                <span class="feature-icon">⚡</span>
                <div class="feature-title">Fast Results</div>
                <div class="feature-desc">Instant score calculation</div>
            </div>
            <div class="feature">
                <span class="feature-icon">🎨</span>
                <div class="feature-title">Anime Style</div>
                <div class="feature-desc">Beautiful visual design</div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading" id="loading">
        <div class="spinner"></div>
    </div>

    <script>
        function showLoading() {
            document.getElementById('loading').style.display = 'flex';
        }

        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects to features
            const features = document.querySelectorAll('.feature');
            features.forEach(feature => {
                feature.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px) scale(1.05)';
                });
                feature.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Add click effects to buttons
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    // Create ripple effect
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple');
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });

        // Add ripple effect CSS
        const style = document.createElement('style');
        style.textContent = `
            .btn {
                position: relative;
                overflow: hidden;
            }
            .ripple {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            }
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
