<?php
session_start();
include 'config/koneksi.php';
// Cek Login
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php");
    exit;
}
$nama_user = $_SESSION['username'];
$promo_query = mysqli_query($conn, "SELECT * FROM promos");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOLO - Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <nav class="navbar">
        <div class="nav-brand">
            <svg style="width:24px; fill:#00f2fe;" viewBox="0 0 24 24"><path d="M21,16v-2l-8-5V3.5c0-0.83-0.67-1.5-1.5-1.5S10,2.67,10,3.5V9l-8,5v2l8-2.5V19l-2,1.5V22l3.5-1l3.5,1v-1.5L13,19v-5.5L21,16z"/></svg>
            VOLO
        </div>
        <div class="nav-links">
            <a href="my_tickets.php">My Booking</a>
            <a href="#">Promo</a>
            <a href="#">Help Center</a>
            <span style="color:rgba(255,255,255,0.3); margin:0 15px;">|</span>
            <span style="font-weight:bold; color:#fff;"><?= ucfirst($nama_user); ?></span>
            <a href="logout.php" style="color:#ff6b6b;">Logout</a>
        </div>
    </nav>

    <section class="hero-section">
        <h1 style="font-size: 3em; margin-bottom: 10px;">Where to next?</h1>
        <p style="color: #ccc; margin-bottom: 30px;">Discover the world with neon speed.</p>

        <div class="glass-panel">
            <div class="flight-type">
                <div class="type-btn active">Sekali Jalan</div>
                <div class="type-btn">Pulang Pergi</div>
            </div>

            <form action="search.php" method="GET" class="booking-form" id="searchForm">
                <input type="hidden" name="trip_type" id="trip_type" value="one_way">
                <div class="form-group">
                    <label>From</label>
                    <input type="text" name="origin" class="form-input" placeholder="Ex: Jakarta" required>
                </div>
                <div class="form-group">
                    <label>To</label>
                    <input type="text" name="destination" class="form-input" placeholder="Ex: Bali" required>
                </div>
                <div class="form-group">
                    <label>Passengers</label>
                    <input type="number" name="passengers" class="form-input" value="1" min="1">
                </div>
                <div class="form-group">
                    <label>Departure</label>
                    <input type="date" name="date" class="form-input">
                </div>
                <div class="form-group">
                    <label>Return</label>
                    <input type="date" name="return_date" id="return_date" class="form-input" disabled style="opacity:0.5; cursor: not-allowed;">
                </div>
                <div class="form-group">
                    <label>Class</label>
                    <select name="class" class="form-input">
                        <option value="economy">Economy</option>
                        <option value="business">Business</option>
                    </select>
                </div>

                <button type="submit" class="btn-search">Search Flight ✈</button>
            </form>
        </div>
    </section>

    <section class="section-container">
        <h2 class="section-title">Special Deals 🔥</h2>
        <p class="section-subtitle">Don't miss out on these limited time offers.</p>

        <div class="grid-3">
            <?php while($promo = mysqli_fetch_assoc($promo_query)): ?>
                
                <?php 
                    $badgeColor = "#4facfe"; // Default Blue
                    $badgeText = "DISKON";
                    if($promo['image_color'] == 'yellow') { $badgeColor = "#ffd700"; $badgeText = "HOT DEAL"; }
                    if($promo['image_color'] == 'red') { $badgeColor = "#ff6b6b"; $badgeText = "LIMITED"; }
                ?>

                <div class="promo-card">
                    <span class="badge" style="background: <?= $badgeColor; ?>; color: black;"><?= $badgeText; ?></span>
                    <h3 style="margin: 10px 0;"><?= $promo['code']; ?></h3>
                    <p style="font-size:0.8em; color:#ccc; margin-bottom:15px;"><?= $promo['description']; ?></p>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #00f2fe; font-weight: bold;">- IDR <?= number_format($promo['discount_amount']/1000); ?>K</span>
                        <button onclick="navigator.clipboard.writeText('<?= $promo['code']; ?>'); alert('Code Copied: <?= $promo['code']; ?>')" 
                                style="background:transparent; border:1px solid #4facfe; color:#4facfe; padding:5px 15px; border-radius:15px; cursor:pointer;">
                            Copy
                        </button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <section class="section-container" style="background: rgba(255,255,255,0.02); border-radius: 20px;">
        <div class="grid-3">
            <div class="feature-item">
                <div class="feature-icon">🛡️</div>
                <h3>Secure Payment</h3>
                <p style="font-size:0.8em; color:#aaa; margin-top:5px;">Encrypted transactions for your peace of mind.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">⚡</div>
                <h3>Instant Booking</h3>
                <p style="font-size:0.8em; color:#aaa; margin-top:5px;">Get your E-Ticket in less than 5 minutes.</p>
            </div>
            <div class="feature-item">
                <div class="feature-icon">🎧</div>
                <h3>24/7 Support</h3>
                <p style="font-size:0.8em; color:#aaa; margin-top:5px;">We are here to help you anytime, anywhere.</p>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 VOLO Flight Systems. All rights reserved.</p>
        <p style="font-size: 0.8em; margin-top: 10px;">Malang, Indonesia • support@volo.com</p>
    </footer>
    <script>
        // Ambil elemen
        const btnOneWay = document.querySelector('.type-btn:nth-child(1)');
        const btnRoundTrip = document.querySelector('.type-btn:nth-child(2)');
        const returnInput = document.getElementById('return_date');
        const tripTypeInput = document.getElementById('trip_type');

        // Klik Sekali Jalan
        btnOneWay.addEventListener('click', () => {
            btnOneWay.classList.add('active');
            btnRoundTrip.classList.remove('active');
            
            // Matikan input tanggal pulang
            returnInput.disabled = true;
            returnInput.style.opacity = "0.5";
            returnInput.style.cursor = "not-allowed";
            returnInput.value = ""; // Kosongkan
            
            tripTypeInput.value = "one_way";
        });

        // Klik Pulang Pergi
        btnRoundTrip.addEventListener('click', () => {
            btnRoundTrip.classList.add('active');
            btnOneWay.classList.remove('active');
            
            // Hidupkan input tanggal pulang
            returnInput.disabled = false;
            returnInput.style.opacity = "1";
            returnInput.style.cursor = "text";
            
            tripTypeInput.value = "round_trip";
        });
    </script>
</body>

</html>