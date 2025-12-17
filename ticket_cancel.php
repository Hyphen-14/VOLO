<?php
session_start();
include 'config/koneksi.php';

// 1. CEK LOGIN
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php");
    exit;
}

// 2. TANGKAP ID BOOKING
$booking_id = $_GET['id'];
$user_id = $_SESSION['user_id']; // ID User yang sedang login

// 3. SECURITY CHECK & UPDATE
// Kita update status jadi 'cancelled' HANYA JIKA id booking cocok DAN user_id nya cocok.
// Jadi hacker ga bisa cancel tiket orang lain.
mysqli_begin_transaction($conn);

try {
    // Cancel booking
    mysqli_query($conn, "
        UPDATE bookings 
        SET status = 'cancelled'
        WHERE id = '$booking_id' AND user_id = '$user_id'
    ");

    if (mysqli_affected_rows($conn) == 0) {
        throw new Exception("Booking not found or access denied");
    }

    // Sinkronisasi payment
    $cekPayment = mysqli_query($conn, "
        SELECT id FROM payments WHERE booking_id = '$booking_id'
    ");

    if (mysqli_num_rows($cekPayment) > 0) {
        mysqli_query($conn, "
            UPDATE payments SET status='failed'
            WHERE booking_id='$booking_id'
        ");
    } else {
        mysqli_query($conn, "
            INSERT INTO payments (booking_id, status)
            VALUES ('$booking_id', 'failed')
        ");
    }

    mysqli_commit($conn);

    echo "<script>alert('Ticket & payment cancelled successfully.'); 
          window.location='my_tickets.php';</script>";

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "<script>alert('Failed to cancel ticket!');
          window.location='my_tickets.php';</script>";
}
