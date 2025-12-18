<?php
include 'config/koneksi.php';

if(isset($_POST['register'])) {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = $_POST['password']; 
    $role     = 'passenger'; 

    // Hash Password (Enkripsi biar aman)
    // Kalau di dummy data kamu isinya "123" (polos), nanti loginnya harus kita sesuaikan.
    // Untuk user baru, kita enkripsi saja.
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // 1. Cek Username
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if(mysqli_num_rows($check) > 0){
        $error = "Username already taken!";
    } else {
        // 2. Insert Data (PERHATIKAN NAMA KOLOM BARU)
        // password -> diganti jadi password_hash
        // value-nya kita pakai yang sudah di-hash
        $query = "INSERT INTO users (username, email, password_hash, role) 
                  VALUES ('$username', '$email', '$password_hashed', '$role')";
        
        $insert = mysqli_query($conn, $query);
        
        if($insert){
            echo "<script>
                    alert('Registration Success! Please Login.');
                    window.location = 'login.php';
                  </script>";
        } else {
            $error = "Registration failed: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - VOLO Enterprise</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="center-mode">

    <div class="glass-container" style="width: 400px;">
        <h2 style="margin-bottom: 5px;">Join VOLO ✈</h2>
        <p style="margin-bottom: 20px; font-size: 0.9em; color: #ddd;">Start your journey with us.</p>

        <?php if(isset($error)) : ?>
            <p style="color: #ff6b6b; font-size: 0.8em; margin-bottom: 15px; background: rgba(255,0,0,0.1); padding: 10px; border-radius: 5px;">
                <?= $error; ?>
            </p>
        <?php endif; ?>

        <form action="" method="POST" style="text-align: left;">
            <div style="margin-bottom: 15px;">
                <label style="font-size: 0.9em; margin-bottom: 5px; display: block; color: #eee;">Username</label>
                <input type="text" name="username" class="form-input" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-size: 0.9em; margin-bottom: 5px; display: block; color: #eee;">Email</label>
                <input type="email" name="email" class="form-input" required>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="font-size: 0.9em; margin-bottom: 5px; display: block; color: #eee;">Password</label>
                <input type="password" name="password" class="form-input" required>
            </div>

            <button type="submit" name="register" class="btn-search" style="margin-top: 0; width: 100%;">Create Account</button>
        </form>

        <p style="margin-top: 20px; font-size: 0.8em; color: #ccc;">
            Already have an account? <a href="login.php" style="color: #00f2fe; text-decoration: none; font-weight: bold;">Login here</a>
        </p>
    </div>

</body>
</html>