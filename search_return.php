<?php
session_start();
include 'config/koneksi.php';

// Tangkap Data
$depart_id = $_GET['depart_id'];
$origin = $_GET['origin'];       
$destination = $_GET['destination'];
$class_type = 'Economy'; // Default kelas untuk return flight (bisa dikembangkan nanti)

// QUERY JOIN (Sama seperti search.php tapi dibalik rutenya)
$query = "SELECT 
            f.flight_id, f.flight_number, f.departure_time, f.arrival_time, 
            dep.city AS origin_city, arr.city AS dest_city,
            
            -- PERBAIKAN DI SINI --
            dep.airport_id AS origin_code, 
            arr.airport_id AS dest_code,
            -----------------------

            a.airline_name, a.image_url, 
            fp.price
          FROM flights f
          JOIN aircraft ac ON f.aircraft_id = ac.aircraft_id
          JOIN airlines a ON ac.airline_id = a.airline_id
          JOIN flight_prices fp ON f.flight_id = fp.flight_id
          JOIN seat_classes sc ON fp.class_id = sc.class_id
          JOIN airports dep ON f.departure_airport_id = dep.airport_id
          JOIN airports arr ON f.arrival_airport_id = arr.airport_id
          WHERE 
            dep.city LIKE '%$origin%' 
            AND arr.city LIKE '%$destination%'
            AND sc.class_name = '$class_type'";
            
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Select Return Flight - VOLO Enterprise</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-brand">
            <svg style="width: 24px; height: 24px; fill: #00f2fe; margin-right: 10px;" viewBox="0 0 24 24"><path d="M21,16v-2l-8-5V3.5c0-0.83-0.67-1.5-1.5-1.5S10,2.67,10,3.5V9l-8,5v2l8-2.5V19l-2,1.5V22l3.5-1l3.5,1v-1.5L13,19v-5.5L21,16z"/></svg>
            VOLO
        </div>
        <div class="nav-links"><a href="dashboard.php">Cancel</a></div>
    </nav>

    <div class="section-container" style="margin-top: 50px; background: transparent; border: none;">
        <h2 class="section-title">Select Return Flight ↩️</h2>
        <p class="section-subtitle">Flying back from <b><?= $origin ?></b> to <b><?= $destination ?></b></p>

        <div style="display: flex; flex-direction: column; gap: 20px;">
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="promo-card" style="display: flex; justify-content: space-between; align-items: center; padding: 30px; border-left: 5px solid #ffd700;">
                        
                        <div style="display: flex; align-items: center; gap: 20px;">
                            <?php if(!empty($row['image_url'])): ?>
                                <img src="<?= $row['image_url']; ?>" style="width: 50px; height: 50px; object-fit: contain; background: rgba(255,255,255,0.1); padding: 8px; border-radius: 50%;">
                            <?php else: ?>
                                <div style="font-size: 1.5em;">✈️</div>
                            <?php endif; ?>
                            <div>
                                <h3 style="margin: 0;"><?= $row['airline_name']; ?></h3>
                                <p style="font-size: 0.9em; color: #aaa;"><?= $row['flight_number']; ?></p>
                            </div>
                        </div>

                        <div style="text-align: center;">
                            <div style="font-size: 1.5em; font-weight: bold;"><?= date('H:i', strtotime($row['departure_time'])); ?></div>
                        </div>
                        <div style="color: #ffd700; font-size: 1.5em;">←</div> 
                        <div style="text-align: center;">
                            <div style="font-size: 1.5em; font-weight: bold;"><?= date('H:i', strtotime($row['arrival_time'])); ?></div>
                        </div>

                        <div style="text-align: right;">
                            <h3 style="color: #00f2fe; margin-bottom: 10px;">IDR <?= number_format($row['price']); ?></h3>
                            <a href="booking_confirm.php?flight_id=<?= $depart_id; ?>&return_id=<?= $row['flight_id']; ?>&class=<?= $class_type; ?>" 
                               class="btn-search" style="padding: 10px 30px; background: linear-gradient(45deg, #ffd700, #ffaa00);">
                                Finish Selection
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="promo-card" style="text-align: center; padding: 50px;">
                    <h3>No Return Flights Found 😢</h3>
                    <p>Try different dates or route.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>