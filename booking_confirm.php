<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['status'])) { header("Location: login.php"); exit; }

// TANGKAP DATA
$depart_id = $_GET['flight_id'] ?? null;
$return_id = $_GET['return_id'] ?? null; // Tangkap ID tiket pulang jika ada
$class_type = $_GET['class'] ?? 'Economy'; 

if (!$depart_id) { echo "Flight ID missing."; exit; }

// --- 1. AMBIL DATA TIKET BERANGKAT ---
$query_dep = mysqli_query($conn, "
    SELECT f.*, a.airline_name, fp.price, sc.class_id, dep.city as origin_city, arr.city as dest_city
    FROM flights f
    JOIN aircraft ac ON f.aircraft_id = ac.aircraft_id
    JOIN airlines a ON ac.airline_id = a.airline_id
    JOIN flight_prices fp ON f.flight_id = fp.flight_id
    JOIN seat_classes sc ON fp.class_id = sc.class_id
    JOIN airports dep ON f.departure_airport_id = dep.airport_id
    JOIN airports arr ON f.arrival_airport_id = arr.airport_id
    WHERE f.flight_id = '$depart_id' AND sc.class_name = '$class_type'
");
$flight_dep = mysqli_fetch_assoc($query_dep);

// --- 2. AMBIL DATA TIKET PULANG (JIKA ADA) ---
$flight_ret = null;
if ($return_id) {
    $query_ret = mysqli_query($conn, "
        SELECT f.*, a.airline_name, fp.price, sc.class_id, dep.city as origin_city, arr.city as dest_city
        FROM flights f
        JOIN aircraft ac ON f.aircraft_id = ac.aircraft_id
        JOIN airlines a ON ac.airline_id = a.airline_id
        JOIN flight_prices fp ON f.flight_id = fp.flight_id
        JOIN seat_classes sc ON fp.class_id = sc.class_id
        JOIN airports dep ON f.departure_airport_id = dep.airport_id
        JOIN airports arr ON f.arrival_airport_id = arr.airport_id
        WHERE f.flight_id = '$return_id' AND sc.class_name = '$class_type'
    ");
    $flight_ret = mysqli_fetch_assoc($query_ret);
}

// --- 3. HITUNG TOTAL HARGA (SEBELUM DISKON) ---
$total_price = $flight_dep['price'];
if ($flight_ret) {
    $total_price += $flight_ret['price'];
}

// --- 4. LOGIKA PROMO CODE ---
$discount = 0;
$grand_total = $total_price;
$promo_code_input = "";
$promo_message = "";

if (isset($_POST['apply_promo'])) {
    $promo_code_input = $_POST['promo_code'];
    
    // Cek tabel 'promotions' (nama tabel baru)
    $cek_promo = mysqli_query($conn, "SELECT * FROM promotions WHERE code = '$promo_code_input'");
    if (mysqli_num_rows($cek_promo) > 0) {
        $p_data = mysqli_fetch_assoc($cek_promo);
        $discount = $p_data['discount_amount'];
        $grand_total = $total_price - $discount;
        if($grand_total < 0) $grand_total = 0;
        
        $promo_message = "<span style='color: #00ff88;'>Code Applied! You save IDR " . number_format($discount) . "</span>";
    } else {
        $promo_message = "<span style='color: #ff6b6b;'>Invalid Code!</span>";
    }
} else {
    // Kalau tidak klik apply, grand total tetap total price
    $grand_total = $total_price;
}


// --- 5. LOGIKA SIMPAN KE DATABASE (ENTERPRISE) ---
if (isset($_POST['confirm_booking'])) {
    $user_id = $_SESSION['user_id'];
    
    // A. INSERT KE TABEL 'bookings' (Header Transaksi)
    $insert_header = mysqli_query($conn, "INSERT INTO bookings (user_id, total_amount, status) 
                                          VALUES ('$user_id', '$grand_total', 'waiting_payment')");
    
    if ($insert_header) {
        $new_booking_id = mysqli_insert_id($conn); 
        
        // B. INSERT TIKET BERANGKAT KE 'booking_details'
        $class_id = $flight_dep['class_id'];
        $price = $flight_dep['price'];
        mysqli_query($conn, "INSERT INTO booking_details (booking_id, flight_id, class_id, price_at_booking) 
                             VALUES ('$new_booking_id', '$depart_id', '$class_id', '$price')");

        // C. INSERT TIKET PULANG KE 'booking_details' (Kalau ada)
        if ($flight_ret) {
            $class_id_ret = $flight_ret['class_id'];
            $price_ret = $flight_ret['price'];
            mysqli_query($conn, "INSERT INTO booking_details (booking_id, flight_id, class_id, price_at_booking) 
                                 VALUES ('$new_booking_id', '$return_id', '$class_id_ret', '$price_ret')");
        }

        echo "<script>
                alert('Booking Confirmed! Please complete payment.'); 
                window.location = 'payment.php?booking_id=$new_booking_id';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
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
            <h3 style="margin-bottom: 5px;"><?= $flight_dep['airline_name']; ?></h3>
            <div style="display: flex; justify-content: space-between;">
                <span><?= $flight_dep['origin_city']; ?> (<?= date('H:i', strtotime($flight_dep['departure_time'])); ?>)</span>
                <span>➝</span>
                <span><?= $flight_dep['dest_city']; ?> (<?= date('H:i', strtotime($flight_dep['arrival_time'])); ?>)</span>
            </div>
            <p style="text-align: right; color: #ccc; font-size: 0.9em;">IDR <?= number_format($flight_dep['price']); ?></p>
        </div>

        <?php if($flight_ret): ?>
        <div style="background: rgba(0,0,0,0.3); padding: 15px; border-radius: 10px; margin-bottom: 15px; border-left: 4px solid #ffd700;">
            <p style="color: #ffd700; font-size: 0.8em; font-weight: bold;">RETURN</p>
            <h3 style="margin-bottom: 5px;"><?= $flight_ret['airline_name']; ?></h3>
            <div style="display: flex; justify-content: space-between;">
                <span><?= $flight_ret['origin_city']; ?> (<?= date('H:i', strtotime($flight_ret['departure_time'])); ?>)</span>
                <span>➝</span>
                <span><?= $flight_ret['dest_city']; ?> (<?= date('H:i', strtotime($flight_ret['arrival_time'])); ?>)</span>
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

        <form method="POST">
            <button type="submit" name="confirm_booking" class="btn-search" style="width: 100%; margin-top: 20px;">
                Pay All & Confirm (IDR <?= number_format($grand_total); ?>) ✈
            </button>
            <a href="dashboard.php" style="display: block; text-align: center; margin-top: 15px; color: #ccc; text-decoration: none;">Cancel</a>
        </form>
    </div>

</body>
</html>