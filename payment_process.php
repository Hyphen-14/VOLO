<?php
include 'config/koneksi.php';

$booking_id = $_POST['booking_id'];
$method     = $_POST['payment_method'];
$amount     = $_POST['amount'];

// upload bukti (opsional)
$proof_name = null;
if (!empty($_FILES['proof']['name'])) {
    $proof_name = time() . '_' . $_FILES['proof']['name'];
    move_uploaded_file($_FILES['proof']['tmp_name'], 'uploads/' . $proof_name);
}

// insert payment
mysqli_query($conn, "
    INSERT INTO payments (booking_id, payment_method, amount, status)
    VALUES ('$booking_id', '$method', '$amount', 'verified')
");

// update booking status
mysqli_query($conn, "
    UPDATE bookings SET status = 'paid'
    WHERE id = '$booking_id'
");

echo "<script>
    alert('Payment successful!');
    window.location='my_tickets.php';
</script>";
