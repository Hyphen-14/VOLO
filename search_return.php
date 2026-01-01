<?php
session_start();
include 'config/koneksi.php';

// Tangkap Data dari URL
$depart_id = $_GET['depart_id']; 
$origin = $_GET['origin'];       
$destination = $_GET['destination'];
$date = $_GET['date'];           
$class_type = $_GET['class'] ?? 'Economy'; 
$passengers = $_GET['passengers'] ?? 1;

// 1. AMBIL INFO TIKET BERANGKAT (YANG SUDAH DIPILIH SEBELUMNYA)
$query_selected = mysqli_query($conn, "
    SELECT f.*, a.airline_name, a.image_url, dep.city AS origin_city, arr.city AS dest_city, 
           dep.airport_id AS origin_code, arr.airport_id AS dest_code
    FROM flights f
    JOIN aircraft ac ON f.aircraft_id = ac.aircraft_id
    JOIN airlines a ON ac.airline_id = a.airline_id
    JOIN airports dep ON f.departure_airport_id = dep.airport_id
    JOIN airports arr ON f.arrival_airport_id = arr.airport_id
    WHERE f.flight_id = '$depart_id'
");
$selected_flight = mysqli_fetch_assoc($query_selected);


// 2. CARI TIKET PULANG (DAFTAR PILIHAN)
$query = "SELECT 
            f.flight_id, f.flight_number, f.departure_time, f.arrival_time, 
            dep.city AS origin_city, arr.city AS dest_city,
            dep.airport_id AS origin_code, arr.airport_id AS dest_code,
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
    <title>Select Return Flight - VOLO</title>
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
        
        <h2 class="section-title">Step 2: Select Return Flight ↩️</h2>
        <p class="section-subtitle">Flying back from <b><?= $origin ?></b> to <b><?= $destination ?></b></p>

        <div style="background: rgba(0, 242, 254, 0.1); border: 1px solid #00f2fe; padding: 20px; border-radius: 15px; margin-bottom: 30px; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <p style="color: #00f2fe; font-size: 0.8em; font-weight: bold; margin-bottom: 5px;">✅ YOUR DEPARTURE FLIGHT</p>
                <div style="display: flex; align-items: center; gap: 15px;">
                    <img src="<?= $selected_flight['image_url']; ?>" style="width: 40px; height: 40px; object-fit: contain; background: white; border-radius: 50%;">
                    <div>
                        <h3 style="margin: 0; font-size: 1.1em;"><?= $selected_flight['airline_name']; ?> (<?= $selected_flight['flight_number']; ?>)</h3>
                        <p style="font-size: 0.9em; color: #ccc;">
                            <?= date('H:i', strtotime($selected_flight['departure_time'])); ?> <?= $selected_flight['origin_city']; ?> 
                            ➝ 
                            <?= date('H:i', strtotime($selected_flight['arrival_time'])); ?> <?= $selected_flight['dest_city']; ?>
                        </p>
                    </div>
                </div>
            </div>
            <div style="text-align: right;">
                <span style="background: #00f2fe; color: black; padding: 5px 15px; border-radius: 20px; font-size: 0.8em; font-weight: bold;">Selected</span>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 20px;">
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="promo-card" style="display: flex; justify-content: space-between; align-items: center; padding: 30px; border-left: 5px solid #ffd700;">
                        
                        <div style="display: flex; align-items: center; gap: 20px;">
                            <div style="width: 60px; height: 60px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                <?php if(!empty($row['image_url'])): ?>
                                    <img src="<?= $row['image_url']; ?>" style="width: 80%; height: 80%; object-fit: contain;">
                                <?php else: ?>
                                    <span style="font-size: 2em;">✈️</span>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h3 style="margin: 0;"><?= $row['airline_name']; ?></h3>
                                <p style="font-size: 0.9em; color: #aaa;"><?= $row['flight_number']; ?></p>
                            </div>
                        </div>

                        <div style="text-align: center;">
                            <div style="font-size: 1.5em; font-weight: bold;"><?= date('H:i', strtotime($row['departure_time'])); ?></div>
                            <div style="font-size: 0.9em; color: #aaa;"><?= $row['origin_city']; ?> (<?= $row['origin_code']; ?>)</div>
                        </div>
                        <div style="color: #ffd700; font-size: 1.5em;">←</div> 
                        <div style="text-align: center;">
                            <div style="font-size: 1.5em; font-weight: bold;"><?= date('H:i', strtotime($row['arrival_time'])); ?></div>
                            <div style="font-size: 0.9em; color: #aaa;"><?= $row['dest_city']; ?> (<?= $row['dest_code']; ?>)</div>
                        </div>

                        <div style="text-align: right;">
                            <h3 style="color: #00f2fe; margin-bottom: 10px;">IDR <?= number_format($row['price']); ?></h3>
                            
                            <a href="booking_confirm.php?flight_id=<?= $depart_id; ?>&return_id=<?= $row['flight_id']; ?>&class=<?= $class_type; ?>&passengers=<?= $passengers; ?>" 
                            class="btn-search" style="padding: 10px 30px; background: linear-gradient(45deg, #ffd700, #ffaa00); color: black; font-weight: bold;">
                                Finish & Book 2 Flights ➝
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