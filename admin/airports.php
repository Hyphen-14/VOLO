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

            <a href="/volo/admin/airports.php" class="nav-item active">
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

            <a href="/volo/admin/payment.php" class="nav-item">
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
            <h1 class="page-title">Airports Management</h1>
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
                        <h2 class="section-title">All Airports</h2>
                        <p class="section-subtitle">Manage airport destinations</p>
                    </div>
                    <button class="btn-primary">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 4V16M4 10H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Add Airport
                    </button>
                </div>

                <!-- Flights Table -->
                <div class="data-table-card">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>AIRPORT NAME</th>
                                <th>CODE</th>
                                <th>CITY</th>
                                <th>COUNTRY</th>
                                <th>ACTIONS</th>
                            </tr>   
                        </thead>
                        <tbody>
                            <tr>
                                <td class="font-semibold">Soekarno-Hatta International</td>
                                <td class="airline-code-box blue">CGK</td>
                                <td class="font-semibold">Jakarta</td>
                                <td class="font-semibold">Indonesia</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                        </button>
                                        <button class="btn-icon btn-icon-danger" title="Delete">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-semibold">Ngurah Rai International</td>
                                <td class="airline-code-box blue">DPS</td>
                                <td class="font-semibold">Bali</td>
                                <td class="font-semibold">Indonesia</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                        </button>
                                        <button class="btn-icon btn-icon-danger" title="Delete">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-semibold">Juanda International</td>
                                <td class="airline-code-box blue">SUB</td>
                                <td class="font-semibold">Surabaya</td>
                                <td class="font-semibold">Indonesia</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                        </button>
                                        <button class="btn-icon btn-icon-danger" title="Delete">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-semibold">Adisucipto International</td>
                                <td class="airline-code-box blue">JOG</td>
                                <td class="font-semibold">Yogyakarta</td>
                                <td class="font-semibold">Indonesia</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                        </button>
                                        <button class="btn-icon btn-icon-danger" title="Delete">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-semibold">Kualanamu International</td>
                                <td class="airline-code-box blue">MES</td>
                                <td class="font-semibold">Medan</td>
                                <td class="font-semibold">Indonesia</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                        </button>
                                        <button class="btn-icon btn-icon-danger" title="Delete">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-semibold">Sultan Hasanuddin International</td>
                                <td class="airline-code-box blue">UPG</td>
                                <td class="font-semibold">Makassar</td>
                                <td class="font-semibold">Indonesia</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                        </button>
                                        <button class="btn-icon btn-icon-danger" title="Delete">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
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