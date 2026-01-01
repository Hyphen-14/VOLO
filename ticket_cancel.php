<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php");
    exit;
}

$booking_id = $_GET['id'];
$user_id = $_SESSION['user_id']; 

// LOGIKA BARU: Hanya bisa cancel jika statusnya 'waiting_payment'
// Kalau sudah 'paid', tidak bisa cancel sembarangan (harus refund process)
mysqli_begin_transaction($conn);

try {
    // 1. Cek status dulu
    $cekStatus = mysqli_query($conn, "SELECT status FROM bookings WHERE booking_id = '$booking_id' AND user_id = '$user_id'");
    $data = mysqli_fetch_assoc($cekStatus);

    if (!$data) {
        throw new Exception("Booking not found.");
    }

    if ($data['status'] == 'cancelled') {
        throw new Exception("Booking is already cancelled.");
    }

    if ($data['status'] == 'paid') {
        throw new Exception("Ticket is already PAID. Cannot cancel directly. Please contact support for refund.");
    }

    // 2. Proses Cancel (Hanya untuk Waiting Payment)
    mysqli_query($conn, "
        UPDATE bookings 
        SET status = 'cancelled'
        WHERE booking_id = '$booking_id' AND user_id = '$user_id'
    ");

    mysqli_commit($conn);

    echo "<script>
            alert('Booking has been cancelled.'); 
            window.location='my_tickets.php';
          </script>";

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "<script>
            alert('" . $e->getMessage() . "');
            window.location='my_tickets.php';
          </script>";
}
?>