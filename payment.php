<?php
include 'config/koneksi.php';

$booking_id = $_GET['booking_id'];

// QUERY ENTERPRISE: Ambil Booking Header + Detail Salah Satu Flight (untuk ditampilkan)
$query = mysqli_query($conn, "
    SELECT 
        b.booking_id,
        b.status,
        b.total_amount,
        f.flight_number,
        f.departure_time,
        f.arrival_time,
        a.airline_name AS airline,
        dep.city AS origin,
        arr.city AS destination
    FROM bookings b
    JOIN booking_details bd ON b.booking_id = bd.booking_id
    JOIN flights f ON bd.flight_id = f.flight_id
    JOIN aircraft ac ON f.aircraft_id = ac.aircraft_id
    JOIN airlines a ON ac.airline_id = a.airline_id
    JOIN airports dep ON f.departure_airport_id = dep.airport_id
    JOIN airports arr ON f.arrival_airport_id = arr.airport_id
    WHERE b.booking_id = '$booking_id'
    LIMIT 1 
");
// Note: LIMIT 1 dipakai karena jika Round Trip ada 2 penerbangan, 
// kita ambil satu saja untuk display ringkas di halaman payment.

if (!$query || mysqli_num_rows($query) == 0) {
    die("Booking data not found.");
}

$data = mysqli_fetch_assoc($query);
$total_price = $data['total_amount']; // Ambil dari tabel bookings (sudah termasuk diskon)
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payment - VOLO</title>
<style>
body { margin: 0; font-family: 'Segoe UI', sans-serif; background: linear-gradient(120deg, #0f2027, #203a43, #2c5364); color: #fff; }
.header { display: flex; justify-content: space-between; align-items: center; padding: 20px 60px; background: rgba(0,0,0,0.35); backdrop-filter: blur(10px); }
.logo { font-size: 22px; font-weight: bold; letter-spacing: 2px; }
.back { color: #ccc; text-decoration: none; }
.container { max-width: 1000px; margin: 60px auto; }
.title h1 { font-size: 32px; margin-bottom: 5px; }
.title p { color: #ccc; }
.card { margin-top: 30px; background: rgba(0,0,0,0.45); border-radius: 16px; padding: 25px; display: flex; justify-content: space-between; align-items: center; position: relative; }
.card::before { content: ''; position: absolute; left: 0; top: 0; width: 5px; height: 100%; background: linear-gradient(#00f2fe, #4facfe); border-radius: 16px 0 0 16px; }
.flight-info { display: flex; gap: 20px; }
.plane { font-size: 32px; }
.flight-info h3 { margin: 0; }
.flight-info span { color: #aaa; font-size: 14px; }
.route { text-align: center; }
.route .time { font-size: 22px; font-weight: bold; }
.route .city { color: #aaa; }
.right { text-align: right; }
.badge { padding: 6px 14px; border-radius: 8px; font-size: 13px; font-weight: bold; }
.waiting { background: orange; color: #000; }
.payment-box { margin-top: 30px; background: rgba(0,0,0,0.45); border-radius: 16px; padding: 25px; }
.payment-box h3 { margin-top: 0; }
.radio-group label { display: block; margin-bottom: 10px; cursor: pointer; }
input[type="file"] { margin-top: 10px; color: #ccc; }
.pay-btn { margin-top: 20px; width: 100%; padding: 14px; font-size: 16px; background: linear-gradient(90deg, #00f2fe, #4facfe); border: none; border-radius: 10px; cursor: pointer; font-weight: bold; }
.price { font-size: 26px; color: #00f2fe; font-weight: bold; }
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

    <div class="card">
        <div class="flight-info">
            <div class="plane">🛫</div>
            <div>
                <h3><?= $data['airline'] ?></h3>
                <span><?= $data['flight_number'] ?></span>
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
            <span class="badge waiting"><?= strtoupper($data['status']); ?></span>
        </div>
    </div>

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