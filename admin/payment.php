<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOLO Admin Panel - Airports</title>
    <link rel="stylesheet" href="/volo/admin/assets/css/admin.css">
</head>
<body>
    <div class="admin-layout">

    
    <aside class="sidebar">

        <!-- BRAND -->
        <div class="sidebar-brand">
            <div class="brand-icon">
            <img src="/volo/admin/assets/images/airplane.png" alt="VOLO">
            </div>
            <div class="brand-text">
            <span class="brand-name">VOLO</span>
            <span class="brand-sub">Admin Panel</span>
            </div>
        </div>

        <!-- NAV -->
        <nav class="sidebar-nav">

            <a href="/volo/admin/dashboard.php" class="nav-item">
            <span class="nav-icon">
                <img src="/volo/admin/assets/images/dashboard.png" alt="Dashboard">
            </span>
            <span class="nav-text">Dashboard</span>
            </a>

            <a href="/volo/admin/manage-flights.php" class="nav-item">
            <span class="nav-icon">
                <img src="/volo/admin/assets/images/airplane.png" alt="Manage Flights">
            </span>
            <span class="nav-text">Manage Flights</span>
            </a>

            <a href="/volo/admin/airlines.php" class="nav-item">
            <span class="nav-icon">
                <img src="/volo/admin/assets/images/airlines.png" alt="Airlines">
            </span>
            <span class="nav-text">Airlines</span>
            </a>

            <a href="/volo/admin/airports.php" class="nav-item">
            <span class="nav-icon">
                <img src="/volo/admin/assets/images/airports.png" alt="Airports">
            </span>
            <span class="nav-text">Airports</span>
            </a>

            <a href="/volo/admin/aircraft-and-seat.php" class="nav-item">
            <span class="nav-icon">
                <img src="/volo/admin/assets/images/aircraft-and-seat.png" alt="Aircraft & Seats">
            </span>
            <span class="nav-text">Aircraft & Seats</span>
            </a>

            <a href="/volo/admin/ticket-prices.php" class="nav-item">
            <span class="nav-icon">
                <img src="/volo/admin/assets/images/ticket-prices.png" alt="Ticket Prices">
            </span>
            <span class="nav-text">Ticket Prices</span>
            </a>

            <a href="/volo/admin/promotions.php" class="nav-item">
            <span class="nav-icon">
                <img src="/volo/admin/assets/images/promotions.png" alt="Promotions">
            </span>
            <span class="nav-text">Promotions</span>
            </a>

            <a href="/volo/admin/booking.php" class="nav-item">
            <span class="nav-icon">
                <img src="/volo/admin/assets/images/booking.png" alt="Bookings">
            </span>
            <span class="nav-text">Bookings</span>
            </a>

            <a href="/volo/admin/payment.php" class="nav-item active">
            <span class="nav-icon">
                <img src="/volo/admin/assets/images/payment.png" alt="Payments">
            </span>
            <span class="nav-text">Payments</span>
            </a>

        </nav>

        <!-- LOGOUT -->
        <a href="/volo/logout.php" class="logout-btn">
            <span class="nav-icon">
                <img src="/volo/admin/assets/images/logout.png" alt="Logout">
            </span>
            <span>Logout</span>
        </a>

    </aside>

    <div class="main-area">

        <header class="admin-header">

        <!-- LEFT -->
        <div class="header-left">
            <h1 class="page-title">Payments</h1>
            <p class="page-subtitle">Welcome back, Administrator</p>
        </div>

        <!-- RIGHT -->
        <div class="header-right">

            <!-- SEARCH -->
            <div class="search-bar">
                <img
                    src="/volo/admin/assets/images/magnifying-glass-search.png"
                    alt="Search"
                    class="search-icon"
                />
                <input 
                    type="text" 
                    class="search-input" 
                    placeholder="Search..."
                    name="search"
                />
            </div>

            <!-- NOTIFICATION -->
            <div class="notification">
                <img
                    src="/volo/admin/assets/images/notification.png"
                    alt="Notifications"
                />
                <span class="notification-dot"></span>
            </div>

            <!-- USER -->
            <div class="user-profile">
                <div class="user-avatar">
                    <img
                        src="/volo/admin/assets/images/user-profile.png"
                        alt="User"
                    />
                </div>
                <div class="user-info">
                    <span class="user-name">Admin User</span>
                    <span class="user-role">Administrator</span>
                </div>
            </div>

        </div>
        </header>
        <main class="page-content">
            <section class="content-section">
                <div class="section-header">
                    <div class="section-title-group">
                        <h2 class="section-title">Payment History</h2>
                        <p class="section-subtitle">Monitor payment transactions (read-only)</p>
                    </div>
                </div>

                <!-- Table -->
                <div class="data-table-card">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>BOOKING CODE</th>
                                <th>AMOUTN</th>
                                <th>METHOD</th>
                                <th>DATE & TIME</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="font-weight: 600; color: #06b6d4;">BK-2024001</td>
                                <td class="font-semibold">Rp. 2.500.000</td>
                                <td style="font-weight: 600; color: #ffffff71;">Credit Card</td>
                                <td class="font-semibold">2024-06-15 10:30</td>
                                <td><span class="status-badge confirmed">Completed</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg width="16px" height="16px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-eye">
                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600; color: #06b6d4;">BK-2024002</td>
                                <td class="font-semibold">Rp. 650.000</td>
                                <td style="font-weight: 600; color: #ffffff71;">Bank Transfer</td>
                                <td class="font-semibold">2024-06-16 14:22</td>
                                <td><span class="status-badge pending">Pending</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg width="16px" height="16px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-eye">
                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600; color: #06b6d4;">BK-2024003</td>
                                <td class="font-semibold">Rp. 450.000</td>
                                <td style="font-weight: 600; color: #ffffff71;">E-Wallet</td>
                                <td class="font-semibold">2024-06-16 09:15</td>
                                <td><span class="status-badge confirmed">Completed</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg width="16px" height="16px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-eye">
                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600; color: #06b6d4;">BK-2024004</td>
                                <td class="font-semibold">Rp. 3.500.000</td>
                                <td style="font-weight: 600; color: #ffffff71;">Credit Card</td>
                                <td class="font-semibold">2024-06-17 16:45</td>
                                <td><span class="status-badge upcoming">Refunded</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg width="16px" height="16px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-eye">
                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600; color: #06b6d4;">BK-2024005</td>
                                <td class="font-semibold">Rp. 550.000</td>
                                <td style="font-weight: 600; color: #ffffff71;">Bank Transfer</td>
                                <td class="font-semibold">2024-06-18 11:00</td>
                                <td><span class="status-badge confirmed">Completed</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg width="16px" height="16px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-eye">
                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600; color: #06b6d4;">BK-2024005</td>
                                <td class="font-semibold">Rp. 850.000</td>
                                <td style="font-weight: 600; color: #ffffff71;">E-Wallet</td>
                                <td class="font-semibold">2024-06-19 08:30</td>
                                <td><span class="status-badge pending">Pending</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg width="16px" height="16px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-eye">
                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>