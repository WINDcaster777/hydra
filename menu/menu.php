<div class="d-flex" id="wrapper">
        <!-- Sidebar Toggle Button -->
        <button class="btn btn-primary btn-sm m-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar-wrapper">
            ☰ Menu
        </button>
        
        <!-- Sidebar -->
        <div class="offcanvas offcanvas-start bg-dark text-white p-3" tabindex="-1" id="sidebar-wrapper">
            <div class="offcanvas-header">
                <h2 class="offcanvas-title">Admin Panel</h2>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="../admin/adminDash.php" class="nav-link text-white">Dashboard</a></li>
                    <li class="nav-item"><a href="/admin/reservations.php" class="nav-link text-white">Reservations</a></li>
                    <li class="nav-item"><a href="../map/map.php" class="nav-link text-white">Facility</a></li>
                    <li class="nav-item"><a href="/admin/guests.php" class="nav-link text-white">Guests</a></li>
                    <li class="nav-item"><a href="/admin/settings.php" class="nav-link text-white">Settings</a></li>
                </ul>
            </div>
        </div>
    </div>