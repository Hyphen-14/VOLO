<?php
session_start();
include 'config/koneksi.php';

$origin = $_GET['origin'] ?? '';
$destination = $_GET['destination'] ?? '';
$query = "SELECT * FROM flights WHERE origin LIKE '%$origin%' AND destination LIKE '%$destination%'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Search Results - VOLO</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <nav class="navbar">
        <div class="nav-brand">VOLO</div>
        <div class="nav-links">
            <a href="dashboard.php">← Back to Dashboard</a>
        </div>
    </nav>

    <div class="section-container" style="margin-top: 50px; background: transparent; border: none;">
        
        <h2 class="section-title">Flight Results ✈</h2>
        <p class="section-subtitle">Showing flights from <b><?= $origin ?></b> to <b><?= $destination ?></b></p>

        <div style="display: flex; flex-direction: column; gap: 20px;">
            
            <?php if(mysqli_num_rows($result) > 0): ?>
                
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="promo-card" style="display: flex; justify-content: space-between; align-items: center; padding: 30px;">
                        
                        <div style="display: flex; align-items: center; gap: 20px;">
                            <div style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 50%; font-size: 1.5em;">
                                ✈️
                            </div>
                            <div>
                                <h3 style="margin: 0; font-size: 1.2em;"><?= $row['airline']; ?></h3>
                                <p style="font-size: 0.9em; color: #aaa;"><?= $row['code']; ?></p>
                            </div>
                        </div>

                        <div style="text-align: center;">
                            <div style="font-size: 1.5em; font-weight: bold;">
                                <?= date('H:i', strtotime($row['departure_time'])); ?>
                            </div>
                            <div style="font-size: 0.9em; color: #aaa;"><?= $row['origin']; ?></div>
                        </div>

                        <div style="color: #4facfe; font-size: 1.5em;">➝</div>

                        <div style="text-align: center;">
                            <div style="font-size: 1.5em; font-weight: bold;">
                                <?= date('H:i', strtotime($row['arrival_time'])); ?>
                            </div>
                            <div style="font-size: 0.9em; color: #aaa;"><?= $row['destination']; ?></div>
                        </div>

                        <div style="text-align: right;">
                            <h3 style="color: #00f2fe; margin-bottom: 10px; font-size: 1.3em;">
                                IDR <?= number_format($row['price']); ?>
                            </h3>
                            <a href="#" class="btn-search" style="padding: 10px 30px; font-size: 0.9em; text-decoration: none; width: auto;">
                                Choose
                            </a>
                        </div>

                    </div>
                <?php endwhile; ?>

            <?php else: ?>
                <div class="promo-card" style="text-align: center; color: #ff6b6b; padding: 50px;">
                    <h3 style="font-size: 2em;">No Flights Found 😢</h3>
                    <p style="margin-top: 10px;">Try searching for "Jakarta" to "Bali".</p>
                </div>
            <?php endif; ?>

        </div>
    </div>

</body>
</html>