<?php
include 'config/koneksi.php';

$booking_id = $_POST['booking_id'];
$method     = $_POST['payment_method'];
$amount     = $_POST['amount'];

// Upload bukti transfer (opsional)
$proof_name = null;
if (!empty($_FILES['proof']['name'])) {
    $proof_name = time() . '_' . $_FILES['proof']['name'];
    // Pastikan folder 'uploads' sudah ada di folder project kamu
    move_uploaded_file($_FILES['proof']['tmp_name'], 'assets/images/uploads/' . $proof_name);
}

// 1. INSERT KE TABEL PAYMENTS
// Pastikan nama kolom sesuai database: booking_id, payment_method, amount, status
$insert_payment = mysqli_query($conn, "
    INSERT INTO payments (booking_id, payment_method, amount, status)
    VALUES ('$booking_id', '$method', '$amount', 'verified')
");

if ($insert_payment) {
    // 2. UPDATE STATUS BOOKING 
    // Dulu: WHERE id = ...
    // Sekarang: WHERE booking_id = ...
    $update_booking = mysqli_query($conn, "
        UPDATE bookings SET status = 'paid'
        WHERE booking_id = '$booking_id'
    ");

    if ($update_booking) {
        echo "<script>
            alert('Payment successful! Your ticket is now active.');
            window.location='my_tickets.php';
        </script>";
    } else {
        echo "Error Updating Booking: " . mysqli_error($conn);
    }
} else {
    echo "Error Inserting Payment: " . mysqli_error($conn);
}
?>