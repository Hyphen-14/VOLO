<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOLO - Fly Higher</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="center-mode">

    <div class="glass-container">
        <svg class="logo-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M21,16v-2l-8-5V3.5c0-0.83-0.67-1.5-1.5-1.5S10,2.67,10,3.5V9l-8,5v2l8-2.5V19l-2,1.5V22l3.5-1l3.5,1v-1.5L13,19v-5.5L21,16z" fill="currentColor"/>
        </svg>

        <h1>VOLO</h1>
        <p style="margin-bottom: 20px; color: #eee;">Experience the Future of Flight Booking.</p>
        
        <div style="margin-bottom: 30px; font-size: 0.8em;">
            <?php 
            if($conn){
                echo "<span style='color: #00ff88; text-shadow: 0 0 10px #00ff88;'>● System Online</span>";
            } else {
                echo "<span style='color: #ff4444;'>● System Offline</span>";
            }
            ?>
        </div>

        <a href="login.php" class="btn-start">Login Now ✈</a>
    </div>

</body>
</html>