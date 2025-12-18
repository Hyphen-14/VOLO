<?php
session_start();
include 'config/koneksi.php';

// Cek Login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// CORE LOGIC: JOIN TABLE (Versi Bersih & Enterprise)
$query = "SELECT 
            b.booking_id, b.status, b.total_amount, b.booking_date,
            f.flight_number, f.departure_time, f.arrival_time,
            a.airline_name, a.image_url,
            dep.city AS origin_city, arr.city AS dest_city,
            dep.airport_id AS origin_code, 
            arr.airport_id AS dest_code
          FROM bookings b
          JOIN booking_details bd ON b.booking_id = bd.booking_id
          JOIN flights f ON bd.flight_id = f.flight_id
          JOIN aircraft ac ON f.aircraft_id = ac.aircraft_id
          JOIN airlines a ON ac.airline_id = a.airline_id
          JOIN airports dep ON f.departure_airport_id = dep.airport_id
          JOIN airports arr ON f.arrival_airport_id = arr.airport_id
          WHERE b.user_id = '$user_id'
          ORDER BY b.booking_date DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>My Tickets - VOLO</title>
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
        <h2 class="section-title">My Tickets 🎫</h2>
        <p class="section-subtitle">Your upcoming and past flights.</p>

        <div style="display: flex; flex-direction: column; gap: 20px;">
            
            <?php if(mysqli_num_rows($result) > 0): ?>
                
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="promo-card" style="display: flex; justify-content: space-between; align-items: center; padding: 30px; border-left: 5px solid #00f2fe;">
                        
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

                        <div style="text-align: center; flex-grow: 1;">
                            <div style="display: flex; justify-content: center; align-items: center; gap: 20px;">
                                <div style="text-align: right;">
                                    <div style="font-weight: bold; font-size: 1.2em;"><?= date('H:i', strtotime($row['departure_time'])); ?></div>
                                    <div style="font-size: 0.8em; color: #aaa;"><?= $row['origin_city']; ?> (<?= $row['origin_code']; ?>)</div>
                                </div>
                                <div style="color: #4facfe;">➝</div>
                                <div style="text-align: left;">
                                    <div style="font-weight: bold; font-size: 1.2em;"><?= date('H:i', strtotime($row['arrival_time'])); ?></div>
                                    <div style="font-size: 0.8em; color: #aaa;"><?= $row['dest_city']; ?> (<?= $row['dest_code']; ?>)</div>
                                </div>
                            </div>
                            <div style="margin-top: 10px; font-size: 0.9em; color: #fff; background: rgba(255,255,255,0.1); display: inline-block; padding: 2px 10px; border-radius: 10px;">
                                <?= date('d M Y', strtotime($row['departure_time'])); ?>
                            </div>
                        </div>

                        <div style="text-align: right;">
                            <p style="font-size: 0.8em; color: #aaa;">Booking ID: #<?= $row['booking_id']; ?></p>
                            
                            <?php 
                                $statusColor = "gray";
                                if($row['status'] == 'paid') $statusColor = "#00ff88"; 
                                if($row['status'] == 'waiting_payment') $statusColor = "#ffd700";
                                if($row['status'] == 'pending') $statusColor = "gray";
                                if($row['status'] == 'cancelled') $statusColor = "#ff6b6b";
                            ?>
                            <span class="badge" style="background: <?= $statusColor; ?>; color: black; font-size: 0.9em; margin-bottom: 10px; display: inline-block;">
                                <?= strtoupper($row['status']); ?>
                            </span>

                            <?php if($row['status'] == 'waiting_payment'): ?>
                                <br>
                                <a href="payment.php?booking_id=<?= $row['booking_id']; ?>" class="btn-search" style="padding: 5px 15px; font-size: 0.8em; width: auto; margin-top: 5px;">
                                    Pay Now
                                </a>
                            <?php endif; ?>

                            <?php if($row['status'] != 'cancelled' && $row['status'] != 'paid'): ?>
                                <br>
                                <a href="ticket_cancel.php?id=<?= $row['booking_id']; ?>" 
                                   onclick="return confirm('Are you sure want to cancel this flight?')"
                                   style="font-size: 0.8em; color: #ff6b6b; text-decoration: none; border: 1px solid #ff6b6b; padding: 5px 10px; border-radius: 5px; display: inline-block; margin-top: 5px;">
                                   Cancel
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="promo-card" style="text-align: center; padding: 50px;">
                    <h3>No tickets yet 🍃</h3>
                    <p>You haven't booked any flights.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>