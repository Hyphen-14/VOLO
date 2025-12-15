<?php 
session_start();
include 'config/koneksi.php'; 

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' AND password = '$password'");
    if(mysqli_num_rows($query) > 0){
        $data = mysqli_fetch_assoc($query);
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];
        $_SESSION['status'] = "login";
        header("Location: dashboard.php");
    } else {
        $error = "Username atau Password salah, Kapten!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - VOLO</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="center-mode">

    <div class="glass-container">
        <svg class="logo-icon" viewBox="0 0 24 24">
            <path d="M21,16v-2l-8-5V3.5c0-0.83-0.67-1.5-1.5-1.5S10,2.67,10,3.5V9l-8,5v2l8-2.5V19l-2,1.5V22l3.5-1l3.5,1v-1.5L13,19v-5.5L21,16z" fill="currentColor"/>
        </svg>

        <h2 style="margin-bottom: 5px;">Welcome Back</h2>
        <p style="margin-bottom: 20px; font-size: 0.9em; color: #ddd;">Please login to your flight deck.</p>

        <?php if(isset($error)) : ?>
            <p style="color: #ff6b6b; font-size: 0.8em; margin-bottom: 15px; background: rgba(255,0,0,0.1); padding: 5px; border-radius: 5px;">
                <?= $error; ?>
            </p>
        <?php endif; ?>

        <form action="" method="POST" style="text-align: left;">
            <div style="margin-bottom: 15px;">
                <label style="font-size: 0.9em; margin-bottom: 5px; display: block; color: #eee;">Username</label>
                <input type="text" name="username" class="form-input" placeholder="Ex: admin_volo" required>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="font-size: 0.9em; margin-bottom: 5px; display: block; color: #eee;">Password</label>
                <input type="password" name="password" class="form-input" placeholder="••••••" required>
            </div>

            <button type="submit" name="login" class="btn-search" style="margin-top: 0;">Login</button>
        </form>

        <div style="margin-top: 20px; font-size: 0.8em; color: #ccc;">
            Don't have an account? <a href="register.php" style="color: #00f2fe; text-decoration: none; font-weight: bold;">Register</a>
            <br><br>
            <a href="index.php" style="display: block; margin-top: 20px; font-size: 0.8em; color: #ccc; text-decoration: none;">← Back to Home</a>
        </div>
    </div>

</body>
</html>