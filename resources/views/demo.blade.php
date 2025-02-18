<?php
  $launchDate = strtotime("2025-03-01 00:00:00");
  $currentTime = time();
  $timeLeft = $launchDate - $currentTime;

  $days = floor($timeLeft / (60 * 60 * 24));
  $hours = floor(($timeLeft % (60 * 60 * 24)) / (60 * 60));
  $minutes = floor(($timeLeft % (60 * 60)) / 60);
  $seconds = $timeLeft % 60;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Launching Soon</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #1a1a1a;
            color: white;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .countdown {
            display: flex;
            gap: 10px;
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Project Launching Soon</h1>
    <p>Stay tuned for something amazing!</p>
    <a href="/login" style="text-decoration:none; color:#fff">Go to Dashboard</a>
</body>
</html>
