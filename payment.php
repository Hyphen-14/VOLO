<?php
include 'config/koneksi.php';

$booking_id = $_GET['booking_id'];

// ambil data booking
$query = mysqli_query($conn, "
    SELECT 
        b.id AS booking_id,
        b.status,
        f.airline,
        f.code,
        f.origin,
        f.destination,
        f.departure_time,
        f.arrival_time,
        f.price
    FROM bookings b
    JOIN flights f ON b.flight_id = f.id
    WHERE b.id = '$booking_id'
");

if (!$query || mysqli_num_rows($query) == 0) {
    die("Booking data not found or flight missing");
}

$data = mysqli_fetch_assoc($query);
$total_price = $data['price'];


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payment - VOLO</title>
<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(120deg, #0f2027, #203a43, #2c5364);
    color: #fff;
}

/* HEADER */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 60px;
    background: rgba(0,0,0,0.35);
    backdrop-filter: blur(10px);
}

.logo {
    font-size: 22px;
    font-weight: bold;
    letter-spacing: 2px;
}

.back {
    color: #ccc;
    text-decoration: none;
}

/* CONTAINER */
.container {
    max-width: 1000px;
    margin: 60px auto;
}

/* TITLE */
.title h1 {
    font-size: 32px;
    margin-bottom: 5px;
}
.title p {
    color: #ccc;
}

/* CARD */
.card {
    margin-top: 30px;
    background: rgba(0,0,0,0.45);
    border-radius: 16px;
    padding: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
}

.card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 5px;
    height: 100%;
    background: linear-gradient(#00f2fe, #4facfe);
    border-radius: 16px 0 0 16px;
}

/* LEFT */
.flight-info {
    display: flex;
    gap: 20px;
}

.plane {
    font-size: 32px;
}

.flight-info h3 {
    margin: 0;
}
.flight-info span {
    color: #aaa;
    font-size: 14px;
}

/* CENTER */
.route {
    text-align: center;
}
.route .time {
    font-size: 22px;
    font-weight: bold;
}
.route .city {
    color: #aaa;
}

/* RIGHT */
.right {
    text-align: right;
}

.badge {
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: bold;
}

.waiting {
    background: orange;
    color: #000;
}

/* FORM */
.payment-box {
    margin-top: 30px;
    background: rgba(0,0,0,0.45);
    border-radius: 16px;
    padding: 25px;
}

.payment-box h3 {
    margin-top: 0;
}

.radio-group label {
    display: block;
    margin-bottom: 10px;
    cursor: pointer;
}

input[type="file"] {
    margin-top: 10px;
    color: #ccc;
}

.pay-btn {
    margin-top: 20px;
    width: 100%;
    padding: 14px;
    font-size: 16px;
    background: linear-gradient(90deg, #00f2fe, #4facfe);
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-weight: bold;
}

.price {
    font-size: 26px;
    color: #00f2fe;
    font-weight: bold;
}
</style>
</head>
<body>

<div class="header">
    <div class="logo">✈ VOLO</div>
    <a href="dashboard.php" class="back">← Back to Dashboard</a>
</div>

<div class="container">

    <div class="title">
        <h1>Payment 💳</h1>
        <p>Complete your payment to confirm booking</p>
    </div>

    <!-- TICKET CARD -->
    <div class="card">
        <div class="flight-info">
            <div class="plane">🛫</div>
            <div>
                <h3><?= $data['airline'] ?></h3>
                <span><?= $data['code'] ?></span>
            </div>
        </div>

        <div class="route">
            <div class="time"><?= date('H:i', strtotime($data['departure_time'])) ?>
                → <?= date('H:i', strtotime($data['arrival_time'])) ?></div>
            <div class="city"><?= $data['origin'] ?> → <?= $data['destination'] ?></div>
            <span><?= date('d M Y', strtotime($data['departure_time'])) ?></span>
        </div>

        <div class="right">
            <span>Booking ID: #<?= $booking_id ?></span><br>
            <span class="badge waiting">WAITING PAYMENT</span>
        </div>
    </div>

    <!-- PAYMENT -->
    <div class="payment-box">
        <h3>Total Payment</h3>
        <p class="price">Rp <?= number_format($total_price, 0, ',', '.') ?></p>

        <form action="payment_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="booking_id" value="<?= $booking_id ?>">
            <input type="hidden" name="amount" value="<?= $total_price ?>">

            <h4>Choose Payment Method</h4>
            <div class="radio-group">
                <label><input type="radio" name="payment_method" value="BCA" required> BCA</label>
                <label><input type="radio" name="payment_method" value="Mandiri"> Mandiri</label>
                <label><input type="radio" name="payment_method" value="QRIS"> QRIS</label>
            </div>

            <h4>Upload Transfer Proof (optional)</h4>
            <input type="file" name="proof">

            <button class="pay-btn" type="submit">I Have Paid</button>
        </form>
    </div>

</div>

</body>
</html>