<?php
// Remove the countdown-related PHP code since we're no longer using it.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Launched, But In Progress</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #1e1e1e; /* Darker background for a developer look */
            color: #f5f5f5;
            font-family: 'Courier New', Courier, monospace; /* Monospace font for developer look */
            text-align: center;
            overflow: hidden;
            position: relative;
        }

        h1 {
            font-size: 40px;
            margin-bottom: 20px;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
        }

        p {
            font-size: 18px;
            margin-bottom: 30px;
            color: #aaa;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
        }

        .quote {
            font-size: 18px;
            font-style: italic;
            margin-bottom: 30px;
            color: #50fa7b; /* Greenish tone for quote */
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
            max-width: 80%;
            line-height: 1.5;
        }

        .link, .login-btn {
            padding: 12px 30px;
            background-color: #282828; /* Dark button */
            color: #f5f5f5;
            font-size: 16px;
            border: 1px solid #50fa7b; /* Green border to match the developer look */
            border-radius: 5px;
            text-decoration: none;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.2);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            letter-spacing: 1px;
        }

        .link:hover, .login-btn:hover {
            background-color: #50fa7b;
            color: #1e1e1e;
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.4);
        }

        .login-btn {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .heart {
            position: absolute;
            bottom: 30px;
            font-size: 24px;
            animation: heartbeat 1.5s infinite ease-in-out;
            color: #50fa7b;
        }

        @keyframes heartbeat {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.2);
            }
        }

        .link.dashboard {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <h1>Project Launched, But In Progress</h1>
    <p>We're live, but still working on some exciting features!</p>

    <!-- Unique Developer-Inspired Quote -->
    <div class="quote">"Code, coffee, and collaboration—just a few elements in our development pipeline."</div>

    <!-- Dashboard Link -->
    <a href="https://thebitterreality.com" class="link dashboard">Go to Website</a>

    <!-- Login Button -->
    <a href="/login" class="login-btn">Login</a>

    <div class="heart">❤️</div>

    <!-- Floating Particle Effect -->
    <div class="particles">
        <canvas id="particles-js"></canvas>
    </div>

    <!-- Particle.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
        particlesJS('particles-js', {
            particles: {
                number: {
                    value: 80,
                    density: {
                        enable: true,
                        value_area: 800
                    }
                },
                shape: {
                    type: 'circle',
                    stroke: {
                        width: 0,
                        color: '#ffffff'
                    }
                },
                opacity: {
                    value: 0.5,
                    random: true,
                    anim: {
                        enable: true,
                        speed: 0.3,
                        opacity_min: 0.1
                    }
                },
                size: {
                    value: 5,
                    random: true,
                    anim: {
                        enable: true,
                        speed: 4,
                        size_min: 0.1
                    }
                },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: '#ffffff',
                    opacity: 0.5,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 3,
                    direction: 'none',
                    random: true,
                    straight: false,
                    out_mode: 'out',
                    bounce: false
                }
            },
            interactivity: {
                detect_on: 'canvas',
                events: {
                    onhover: {
                        enable: true,
                        mode: 'repulse'
                    },
                    onclick: {
                        enable: true,
                        mode: 'push'
                    }
                }
            },
            retina_detect: true
        });
    </script>
</body>
</html>
