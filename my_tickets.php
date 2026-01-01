<?php
session_start();
include 'config/koneksi.php';

// Cek Login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// CORE LOGIC: JOIN TABLE
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
        <p class="section-subtitle">Manage your bookings and payments.</p>

        <div style="display: flex; flex-direction: column; gap: 20px;">
            
            <?php if(mysqli_num_rows($result) > 0): ?>
                
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <?php 
                        $borderColor = "#00f2fe"; // Default Paid
                        if($row['status'] == 'waiting_payment') $borderColor = "#ffd700"; // Kuning
                        if($row['status'] == 'cancelled') $borderColor = "#ff6b6b"; // Merah
                    ?>

                    <div class="promo-card" style="display: flex; justify-content: space-between; align-items: center; padding: 30px; border-left: 5px solid <?= $borderColor; ?>;">
                        
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
                                <div style="color: <?= $borderColor; ?>;">➝</div>
                                <div style="text-align: left;">
                                    <div style="font-weight: bold; font-size: 1.2em;"><?= date('H:i', strtotime($row['arrival_time'])); ?></div>
                                    <div style="font-size: 0.8em; color: #aaa;"><?= $row['dest_city']; ?> (<?= $row['dest_code']; ?>)</div>
                                </div>
                            </div>
                            <div style="margin-top: 10px; font-size: 0.9em; color: #fff; background: rgba(255,255,255,0.1); display: inline-block; padding: 2px 10px; border-radius: 10px;">
                                <?= date('d M Y', strtotime($row['departure_time'])); ?>
                            </div>
                        </div>

                        <div style="text-align: right; min-width: 150px;">
                            <p style="font-size: 0.8em; color: #aaa; margin-bottom: 5px;">Booking ID: #<?= $row['booking_id']; ?></p>
                            
                            <?php 
                                $statusBadge = "gray";
                                if($row['status'] == 'paid') $statusBadge = "#00ff88"; 
                                if($row['status'] == 'waiting_payment') $statusBadge = "#ffd700";
                                if($row['status'] == 'cancelled') $statusBadge = "#ff6b6b";
                            ?>
                            <span class="badge" style="background: <?= $statusBadge; ?>; color: black; font-size: 0.8em; margin-bottom: 10px; display: inline-block; font-weight: bold;">
                                <?= strtoupper(str_replace('_', ' ', $row['status'])); ?>
                            </span>
                            <br>

                            <?php if($row['status'] == 'waiting_payment'): ?>
                                <a href="payment.php?booking_id=<?= $row['booking_id']; ?>" class="btn-search" style="padding: 8px 20px; font-size: 0.8em; width: 100%; display:inline-block; margin-bottom: 5px; background: linear-gradient(45deg, #ffd700, #ffaa00); color: black;">
                                    Pay Now 💳
                                </a>
                                <br>
                                <a href="ticket_cancel.php?id=<?= $row['booking_id']; ?>" 
                                   onclick="return confirm('Are you sure want to cancel this booking?')"
                                   style="font-size: 0.8em; color: #ff6b6b; text-decoration: none; border: 1px solid #ff6b6b; padding: 5px 10px; border-radius: 5px; display: inline-block; width: 100%; text-align: center;">
                                   Cancel Booking
                                </a>

                            <?php elseif($row['status'] == 'paid'): ?>
                                <button onclick="alert('Ini nanti download E-Ticket PDF')" 
                                        style="background: transparent; border: 1px solid #00f2fe; color: #00f2fe; padding: 8px 20px; border-radius: 5px; cursor: pointer; width: 100%;">
                                    View E-Ticket 🎫
                                </button>
                            
                            <?php elseif($row['status'] == 'cancelled'): ?>
                                <span style="color: #666; font-size: 0.8em;">Ticket Inactive</span>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="promo-card" style="text-align: center; padding: 50px;">
                    <h3>No tickets yet 🍃</h3>
                    <p>You haven't booked any flights.</p>
                    <a href="dashboard.php" class="btn-search" style="margin-top: 20px; width: auto; display: inline-block;">Book Now</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>