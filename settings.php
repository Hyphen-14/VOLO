<?php
session_start();
include 'config/koneksi.php';

// Cek Login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// 1. PROSES UPDATE DATA
if (isset($_POST['update_profile'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone     = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $email     = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Query Update (Sesuai kolom di database users)
    $update = mysqli_query($conn, "UPDATE users SET 
                                   full_name = '$full_name', 
                                   phone_number = '$phone',
                                   email = '$email'
                                   WHERE user_id = '$user_id'");
    
    if($update) {
        echo "<script>alert('Profile updated successfully!');</script>";
    } else {
        echo "<script>alert('Failed to update profile.');</script>";
    }
}

// 2. AMBIL DATA USER SAAT INI
$query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$user_id'");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>User Settings - VOLO</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="center-mode">

    <div class="glass-container" style="width: 500px; text-align: left;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0;">Account Settings ⚙️</h2>
            <a href="dashboard.php" style="color: #ccc; text-decoration: none; font-size: 0.9em;">Back to Home</a>
        </div>

        <div style="text-align: center; margin-bottom: 20px;">
            <div style="width: 80px; height: 80px; background: #00f2fe; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 2em; color: #000; font-weight: bold;">
                <?= substr($data['username'], 0, 1); ?>
            </div>
            <p style="margin-top: 10px; color: #00f2fe;">@<?= $data['username']; ?></p>
            <span class="badge" style="background: rgba(255,255,255,0.1);"><?= strtoupper($data['role']); ?></span>
        </div>

        <form method="POST">
            <div style="margin-bottom: 15px;">
                <label style="font-size: 0.9em; color: #aaa;">Full Name</label>
                <input type="text" name="full_name" class="form-input" value="<?= $data['full_name']; ?>" placeholder="Enter your full name">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-size: 0.9em; color: #aaa;">Phone Number</label>
                <input type="number" name="phone_number" class="form-input" value="<?= $data['phone_number']; ?>" placeholder="Ex: 08123456789">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-size: 0.9em; color: #aaa;">Email Address</label>
                <input type="email" name="email" class="form-input" value="<?= $data['email']; ?>" required>
            </div>

            <button type="submit" name="update_profile" class="btn-search" style="width: 100%; margin-top: 10px;">
                Save Changes 💾
            </button>
        </form>

        <div style="margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px;">
            <p style="font-size: 0.8em; color: #aaa;">Member since: <?= date('d M Y', strtotime($data['created_at'])); ?></p>
        </div>

    </div>

</body>
</html>