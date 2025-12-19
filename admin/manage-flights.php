<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOLO Admin Panel - Manage Flights</title>
    <link rel="stylesheet" href="/volo/admin/assets/css/admin.css">
</head>
<body>

<div class="admin-layout">

    <?php include __DIR__ . '/partials/sidebar.html'; ?>

    <div class="main-area">

        <header class="admin-header">

        <!-- LEFT -->
        <div class="header-left">
            <h1 class="page-title">Manage Flights</h1>
            <p class="page-subtitle">Manage and monitor all flight schedules</p>
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

        <!-- ===== MANAGE FLIGHTS CONTENT ===== -->
        <main class="page-content">

            <!-- Flights Section -->
            <section class="content-section">
                <div class="section-header">
                    <div class="section-title-group">
                        <h2 class="section-title">All Flights</h2>
                        <p class="section-subtitle">Manage and monitor all flight schedules</p>
                    </div>
                    <button class="btn-primary">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 4V16M4 10H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Add Flight
                    </button>
                </div>

                <!-- Flights Table -->
                <div class="data-table-card">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>FLIGHT CODE</th>
                                <th>AIRLINE</th>
                                <th>FROM</th>
                                <th>TO</th>
                                <th>DEPARTURE</th>
                                <th>ARRIVAL</th>
                                <th>AIRCRAFT</th>
                                <th>STATUS</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="font-semibold">VL-101</td>
                                <td>Garuda Indonesia</td>
                                <td>CGK</td>
                                <td>DPS</td>
                                <td>08:00</td>
                                <td>10:30</td>
                                <td>Boeing 737-800</td>
                                <td><span class="status-badge active">Active</span></td>
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
                                <td class="font-semibold">VL-205</td>
                                <td>Lion Air</td>
                                <td>SUB</td>
                                <td>CGK</td>
                                <td>09:15</td>
                                <td>11:00</td>
                                <td>Airbus A320</td>
                                <td><span class="status-badge active">Active</span></td>
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
                                <td class="font-semibold">VL-342</td>
                                <td>Citilink</td>
                                <td>DPS</td>
                                <td>JOG</td>
                                <td>14:30</td>
                                <td>15:45</td>
                                <td>ATR 72-600</td>
                                <td><span class="status-badge cancelled">Cancelled</span></td>
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
                                <td class="font-semibold">VL-418</td>
                                <td>Batik Air</td>
                                <td>CGK</td>
                                <td>MES</td>
                                <td>16:00</td>
                                <td>18:30</td>
                                <td>Boeing 737 MAX</td>
                                <td><span class="status-badge active">Active</span></td>
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
                                <td class="font-semibold">VL-512</td>
                                <td>Sriwijaya Air</td>
                                <td>JOG</td>
                                <td>CGK</td>
                                <td>07:00</td>
                                <td>08:15</td>
                                <td>Boeing 737-500</td>
                                <td><span class="status-badge active">Active</span></td>
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
</div>

</body>
</html>