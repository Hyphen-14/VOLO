<?php
session_start();
include 'config/koneksi.php';

$trip_type = $_GET['trip_type'] ?? 'one_way';
$return_date = $_GET['return_date'] ?? '';
$origin = $_GET['origin'] ?? '';
$destination = $_GET['destination'] ?? '';
$class_type = $_GET['class'] ?? 'Economy'; 

// QUERY FINAL (Fixed: Airline Name & Airport ID)
$query = "SELECT 
            f.flight_id, f.flight_number, f.departure_time, f.arrival_time,
            dep.city AS origin_city, arr.city AS dest_city, 
            dep.airport_id AS origin_code, arr.airport_id AS dest_code,
            a.airline_name, a.image_url,
            fp.price
          FROM flights f
          JOIN aircraft ac ON f.aircraft_id = ac.aircraft_id       
          JOIN airlines a ON ac.airline_id = a.airline_id          
          JOIN airports dep ON f.departure_airport_id = dep.airport_id
          JOIN airports arr ON f.arrival_airport_id = arr.airport_id
          JOIN flight_prices fp ON f.flight_id = fp.flight_id
          JOIN seat_classes sc ON fp.class_id = sc.class_id
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
    <title>Search Results - VOLO Enterprise</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-brand">
            <svg style="width: 24px; height: 24px; fill: #00f2fe; margin-right: 10px;" viewBox="0 0 24 24"><path d="M21,16v-2l-8-5V3.5c0-0.83-0.67-1.5-1.5-1.5S10,2.67,10,3.5V9l-8,5v2l8-2.5V19l-2,1.5V22l3.5-1l3.5,1v-1.5L13,19v-5.5L21,16z"/></svg>
            VOLO
        </div>
        <div class="nav-links"><a href="dashboard.php">← Back to Dashboard</a></div>
    </nav>

    <div class="section-container" style="margin-top: 50px; background: transparent; border: none;">
        <h2 class="section-title">Flight Results ✈</h2>
        <p class="section-subtitle">Showing <b><?= $class_type; ?></b> class from <b><?= $origin ?></b> to <b><?= $destination ?></b></p>

        <div style="display: flex; flex-direction: column; gap: 20px;">
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="promo-card" style="display: flex; justify-content: space-between; align-items: center; padding: 30px;">
                        
                        <div style="display: flex; align-items: center; gap: 20px;">
                            <div style="width: 60px; height: 60px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                <?php if(!empty($row['image_url'])): ?>
                                    <img src="<?= $row['image_url']; ?>" alt="Logo" style="width: 80%; height: 80%; object-fit: contain;">
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
                        <div style="color: #4facfe; font-size: 1.5em;">➝</div>
                        <div style="text-align: center;">
                            <div style="font-size: 1.5em; font-weight: bold;"><?= date('H:i', strtotime($row['arrival_time'])); ?></div>
                            <div style="font-size: 0.9em; color: #aaa;"><?= $row['dest_city']; ?> (<?= $row['dest_code']; ?>)</div>
                        </div>

                        <div style="text-align: right;">
                            <h3 style="color: #00f2fe; margin-bottom: 10px;">IDR <?= number_format($row['price']); ?></h3>
                            <?php if($trip_type == 'round_trip' && !empty($return_date)): ?>
                                <a href="search_return.php?depart_id=<?= $row['flight_id']; ?>&origin=<?= $destination; ?>&destination=<?= $origin; ?>&date=<?= $return_date; ?>&class=<?= $class_type; ?>" 
                                   class="btn-search" style="padding: 10px 30px; background: linear-gradient(45deg, #ffd700, #ffaa00);">
                                   Select Return ➝
                                </a>
                            <?php else: ?>
                                <a href="booking_confirm.php?flight_id=<?= $row['flight_id']; ?>&class=<?= $class_type; ?>" 
                                   class="btn-search" style="padding: 10px 30px;">
                                   Choose
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="promo-card" style="text-align: center; color: #ff6b6b; padding: 50px;">
                    <h3>No Flights Found 😢</h3>
                    <p>Try changing the class or date.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>