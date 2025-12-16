<?php
session_start();
include 'config/koneksi.php';

$trip_type = $_GET['trip_type'] ?? 'one_way';
$return_date = $_GET['return_date'] ?? '';
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
        <div class="nav-brand">
            <svg style="width: 24px; height: 24px; fill: #00f2fe; margin-right: 10px;" viewBox="0 0 24 24">
                <path d="M21,16v-2l-8-5V3.5c0-0.83-0.67-1.5-1.5-1.5S10,2.67,10,3.5V9l-8,5v2l8-2.5V19l-2,1.5V22l3.5-1l3.5,1v-1.5L13,19v-5.5L21,16z"/>
            </svg>
            VOLO
        </div>
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
                            
                            <?php if(!empty($row['image_url'])): ?>
                                <img src="<?= $row['image_url']; ?>" alt="<?= $row['airline']; ?>" 
                                     style="width: 60px; height: 60px; object-fit: contain; background: rgba(255,255,255,0.1); padding: 10px; border-radius: 50%;">
                            <?php else: ?>
                                <div style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 50%; font-size: 1.5em;">
                                    ✈️
                                </div>
                            <?php endif; ?>

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

                            <?php if($trip_type == 'round_trip' && !empty($return_date)): ?>
                                <a href="search_return.php?depart_id=<?= $row['id']; ?>&origin=<?= $destination; ?>&destination=<?= $origin; ?>&date=<?= $return_date; ?>" 
                                class="btn-search" style="padding: 10px 30px; font-size: 0.9em; text-decoration: none; width: auto; background: linear-gradient(45deg, #ffd700, #ffaa00);">
                                    Select Return ➝
                                </a>
                            <?php else: ?>
                                <a href="booking_confirm.php?flight_id=<?= $row['id']; ?>" 
                                class="btn-search" style="padding: 10px 30px; font-size: 0.9em; text-decoration: none; width: auto;">
                                    Choose
                                </a>
                            <?php endif; ?>
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