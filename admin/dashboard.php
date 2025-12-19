<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOLO Admin Panel - Dashboard</title>
    <link rel="stylesheet" href="/volo/admin/assets/css/admin.css">
</head>
<body>

<div class="admin-layout">

    <?php include __DIR__ . '/partials/sidebar.html'; ?>

    <div class="main-area">

        <header class="admin-header">

        <!-- LEFT -->
        <div class="header-left">
            <h1 class="page-title">Admin Dashboard</h1>
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

        <!-- ===== DASHBOARD CONTENT ===== -->
        <main class="dashboard-content">

            <!-- TOP 4 STAT CARDS -->
            <section class="stats-grid">
                
                <div class="stat-card">
                    <h4>Total Flights</h4>
                    <h2>1,284</h2>
                    <span class="positive">+12% from last month</span>
                    <div class="stat-icon">
                        <img src="/volo/admin/assets/images/airplane.png" alt="Flights">
                    </div>
                </div>

                <div class="stat-card">
                    <h4>Total Bookings</h4>
                    <h2>8,432</h2>
                    <span class="positive">+8% from last month</span>
                    <div class="stat-icon">
                        <img src="/volo/admin/assets/images/booking.png" alt="Bookings">
                    </div>
                </div>

                <div class="stat-card">
                    <h4>Total Payments</h4>
                    <h2>$2.4M</h2>
                    <span class="positive">+15% from last month</span>
                    <div class="stat-icon">
                        <img src="/volo/admin/assets/images/payment.png" alt="Payments">
                    </div>
                </div>

                <div class="stat-card">
                    <h4>Active Promotions</h4>
                    <h2>24</h2>
                    <span class="negative">-3% from last month</span>
                    <div class="stat-icon">
                        <img src="/volo/admin/assets/images/promotions.png" alt="Promotions">
                    </div>
                </div>

            </section>

            <!-- MIDDLE 3 STAT CARDS -->
            <section class="stats-grid-secondary">
                
                <div class="stat-card-secondary">
                    <div class="stat-icon-box green">
                        <img src="/volo/admin/assets/images/revenue-up.png" alt="Revenue">
                    </div>
                    <div class="stat-info">
                        <h3>Today's Revenue</h3>
                        <h2>$48,250</h2>
                    </div>
                </div>

                <div class="stat-card-secondary">
                    <div class="stat-icon-box blue">
                        <img src="/volo/admin/assets/images/clock.png" alt="Flights">
                    </div>
                    <div class="stat-info">
                        <h3>Flights Today</h3>
                        <h2>42</h2>
                    </div>
                </div>

                <div class="stat-card-secondary">
                    <div class="stat-icon-box blue">
                        <img src="/volo/admin/assets/images/airports.png" alt="Routes">
                    </div>
                    <div class="stat-info">
                        <h3>Active Routes</h3>
                        <h2>156</h2>
                    </div>
                </div>

            </section>

            <!-- TABLES SECTION -->
            <section class="tables-grid">
                
                <!-- Recent Flights Table -->
                <div class="table-card">
                    <h3>Recent Flights</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>FLIGHT</th>
                                <th>AIRLINE</th>
                                <th>ROUTE</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>VL-101</td>
                                <td>Garuda Indonesia</td>
                                <td>CGK → DPS</td>
                                <td><span class="status-badge on-time">On Time</span></td>
                            </tr>
                            <tr>
                                <td>VL-205</td>
                                <td>Lion Air</td>
                                <td>SUB → CGK</td>
                                <td><span class="status-badge delayed">Delayed</span></td>
                            </tr>
                            <tr>
                                <td>VL-342</td>
                                <td>Citilink</td>
                                <td>DPS → JOG</td>
                                <td><span class="status-badge on-time">On Time</span></td>
                            </tr>
                            <tr>
                                <td>VL-418</td>
                                <td>Batik Air</td>
                                <td>CGK → MES</td>
                                <td><span class="status-badge boarding">Boarding</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Recent Bookings Table -->
                <div class="table-card">
                    <h3>Recent Bookings</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>BOOKING</th>
                                <th>CUSTOMER</th>
                                <th>FLIGHT</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>BK-2024001</td>
                                <td>John Doe</td>
                                <td>VL-101</td>
                                <td><span class="status-badge confirmed">Confirmed</span></td>
                            </tr>
                            <tr>
                                <td>BK-2024002</td>
                                <td>Jane Smith</td>
                                <td>VL-205</td>
                                <td><span class="status-badge pending">Pending</span></td>
                            </tr>
                            <tr>
                                <td>BK-2024003</td>
                                <td>Mike Johnson</td>
                                <td>VL-342</td>
                                <td><span class="status-badge confirmed">Confirmed</span></td>
                            </tr>
                            <tr>
                                <td>BK-2024004</td>
                                <td>Sarah Wilson</td>
                                <td>VL-418</td>
                                <td><span class="status-badge confirmed">Confirmed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </section>

        </main>
    </div>
</div>

</body>
</html>