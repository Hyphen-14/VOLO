<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['status'])) { header("Location: login.php"); exit; }

// --- LOGIKA MENANGKAP DATA (Bisa 1 Tiket atau 2 Tiket) ---
$depart_id = $_GET['depart_id'] ?? $_GET['flight_id'] ?? null; // Handle nama variabel yg beda
$return_id = $_GET['return_id'] ?? null; // ID Tiket Pulang (Bisa kosong kalau one way)

if (!$depart_id) { echo "Flight ID missing."; exit; }

// 1. Ambil Data Tiket BERANGKAT
$query_dep = mysqli_query($conn, "SELECT * FROM flights WHERE id = '$depart_id'");
$flight_dep = mysqli_fetch_assoc($query_dep);

// 2. Ambil Data Tiket PULANG (Jika ada)
$flight_ret = null;
if ($return_id) {
    $query_ret = mysqli_query($conn, "SELECT * FROM flights WHERE id = '$return_id'");
    $flight_ret = mysqli_fetch_assoc($query_ret);
}

// 3. Hitung Total Harga
$total_price = $flight_dep['price'];
if ($flight_ret) {
    $total_price += $flight_ret['price'];
}
// ... (Kode perhitungan total_price sebelumnya) ...
$total_price = $flight_dep['price'];
if ($flight_ret) { $total_price += $flight_ret['price']; }

// --- LOGIKA PROMO CODE (NEW!) ---
$discount = 0;
$promo_code_input = "";
$promo_message = "";

// Jika tombol "Apply Code" ditekan
if (isset($_POST['apply_promo'])) {
    $promo_code_input = $_POST['promo_code'];
    
    // Cek ke database
    $cek_promo = mysqli_query($conn, "SELECT * FROM promos WHERE code = '$promo_code_input'");
    if (mysqli_num_rows($cek_promo) > 0) {
        $p_data = mysqli_fetch_assoc($cek_promo);
        $discount = $p_data['discount_amount'];
        $promo_message = "<span style='color: #00ff88;'>Code Applied! You save IDR " . number_format($discount) . "</span>";
    } else {
        $promo_message = "<span style='color: #ff6b6b;'>Invalid Code!</span>";
    }
}

// Hitung Grand Total (Harga Asli - Diskon)
$grand_total = $total_price - $discount;
if($grand_total < 0) $grand_total = 0; // Jangan sampai minus

// --- LOGIKA SIMPAN KE DATABASE ---
if (isset($_POST['confirm_booking'])) {
    $user_id = $_SESSION['user_id'];

    // INSERT BOOKING BERANGKAT
    mysqli_query($conn, "
        INSERT INTO bookings (user_id, flight_id, status)
        VALUES ('$user_id', '$depart_id', 'waiting payment')
    ");

    // ambil booking_id utama
    $booking_id = mysqli_insert_id($conn);

    // INSERT BOOKING PULANG (JIKA ADA)
    if ($return_id) {
        mysqli_query($conn, "
            INSERT INTO bookings (user_id, flight_id, status)
            VALUES ('$user_id', '$return_id', 'waiting payment')
        ");
    }

    // redirect ke payment
    header("Location: payment.php?booking_id=$booking_id");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Confirm Booking - VOLO</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="center-mode">

    <div class="glass-container" style="width: 600px; text-align: left;">
        <h2 style="text-align: center; margin-bottom: 20px;">Confirm Booking 🎫</h2>

        <div style="background: rgba(0,0,0,0.3); padding: 15px; border-radius: 10px; margin-bottom: 15px; border-left: 4px solid #4facfe;">
            <p style="color: #4facfe; font-size: 0.8em; font-weight: bold;">DEPARTURE</p>
            <h3 style="margin-bottom: 5px;"><?= $flight_dep['airline']; ?></h3>
            <div style="display: flex; justify-content: space-between;">
                <span><?= $flight_dep['origin']; ?> (<?= date('H:i', strtotime($flight_dep['departure_time'])); ?>)</span>
                <span>➝</span>
                <span><?= $flight_dep['destination']; ?> (<?= date('H:i', strtotime($flight_dep['arrival_time'])); ?>)</span>
            </div>
            <p style="text-align: right; color: #ccc; font-size: 0.9em;">IDR <?= number_format($flight_dep['price']); ?></p>
        </div>

        <?php if($flight_ret): ?>
        <div style="background: rgba(0,0,0,0.3); padding: 15px; border-radius: 10px; margin-bottom: 15px; border-left: 4px solid #ffd700;">
            <p style="color: #ffd700; font-size: 0.8em; font-weight: bold;">RETURN</p>
            <h3 style="margin-bottom: 5px;"><?= $flight_ret['airline']; ?></h3>
            <div style="display: flex; justify-content: space-between;">
                <span><?= $flight_ret['origin']; ?> (<?= date('H:i', strtotime($flight_ret['departure_time'])); ?>)</span>
                <span>➝</span>
                <span><?= $flight_ret['destination']; ?> (<?= date('H:i', strtotime($flight_ret['arrival_time'])); ?>)</span>
            </div>
            <p style="text-align: right; color: #ccc; font-size: 0.9em;">IDR <?= number_format($flight_ret['price']); ?></p>
        </div>
        <?php endif; ?>

        <div style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: 10px; margin-top: 20px;">
            <p style="font-size: 0.9em; margin-bottom: 10px;">Have a Promo Code?</p>
            
            <form method="POST" style="display: flex; gap: 10px;">
                <input type="text" name="promo_code" value="<?= $promo_code_input; ?>" class="form-input" placeholder="Enter Code (e.g. VOLOHEMAT)" style="padding: 10px;">
                <button type="submit" name="apply_promo" class="btn-search" style="width: auto; margin-top: 0; font-size: 0.9em; padding: 10px 20px;">Apply</button>
            </form>
            <p style="font-size: 0.8em; margin-top: 5px;"><?= $promo_message; ?></p>
        </div>

        <div style="margin-top: 20px; border-top: 1px dashed #555; padding-top: 15px;">
            <div style="display: flex; justify-content: space-between; color: #ccc;">
                <span>Subtotal</span>
                <span>IDR <?= number_format($total_price); ?></span>
            </div>
            
            <?php if($discount > 0): ?>
            <div style="display: flex; justify-content: space-between; color: #00ff88;">
                <span>Discount</span>
                <span>- IDR <?= number_format($discount); ?></span>
            </div>
            <?php endif; ?>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                <span style="font-size: 1.1em; font-weight: bold;">Grand Total</span>
                <span style="font-size: 1.8em; color: #00f2fe; font-weight: bold;">IDR <?= number_format($grand_total); ?></span>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; border-top: 1px dashed #555; padding-top: 15px;">
            <span style="font-size: 1.1em;">Total Payment</span>
            <span style="font-size: 1.8em; color: #00f2fe; font-weight: bold;">IDR <?= number_format($grand_total); ?></span>
        </div>

        <form method="POST">
            <button type="submit" name="confirm_booking" class="btn-search" style="width: 100%; margin-top: 20px;">
                Pay All & Confirm (IDR <?= number_format($grand_total); ?>) ✈
            </button>
            <a href="dashboard.php" style="display: block; text-align: center; margin-top: 15px; color: #ccc; text-decoration: none;">Cancel</a>
        </form>
    </div>

</body>
</html>