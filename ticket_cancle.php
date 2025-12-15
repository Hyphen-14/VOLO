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
$query = "UPDATE bookings SET status = 'cancelled' WHERE id = '$booking_id' AND user_id = '$user_id'";
$result = mysqli_query($conn, $query);

// 4. CEK HASIL
if (mysqli_affected_rows($conn) > 0) {
    // Berhasil dicancel
    echo "<script>
            alert('Ticket has been cancelled successfully.');
            window.location = 'my_tickets.php';
          </script>";
} else {
    // Gagal (Mungkin tiket orang lain, atau ID salah)
    echo "<script>
            alert('Failed to cancel ticket. Access denied!');
            window.location = 'my_tickets.php';
          </script>";
}
?>