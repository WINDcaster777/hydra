<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resort Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
<?php include ('../menu/menu.php')?>
    
    <div class="container-fluid p-4">
        <h1 class="mb-4">Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-bg-primary text-center p-3">
                    <h4>Total Reservations</h4>
                    <p class="fs-3">120</p>
                </div>
            </div>

            <!-- Available Rooms (Clickable Card) -->
            <div class="col-md-3">
                <a href="../map/map.php" style="text-decoration: none;">
                    <div class="card text-bg-success text-center p-3 h-100">
                        <h4>Available Rooms</h4>
                        <p class="fs-3 mb-0">
                            <?php include("fetchTotalFacility.php"); ?>
                        </p>
                    </div>
                </a>
            </div>
            
            <div class="col-md-3">
                <div class="card text-bg-warning text-center p-3">
                    <h4>Pending Check-ins</h4>
                    <p class="fs-3">10</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-bg-danger text-center p-3">
                    <h4>Pending Check-outs</h4>
                    <p class="fs-3">8</p>
                </div>
            </div>
        </div>
        <h2 class="mt-4">Recent Reservations</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Guest Name</th>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>101</td>
                    <td>2025-04-01</td>
                    <td>2025-04-05</td>
                    <td><span class="badge bg-success">Checked In</span></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Jane Smith</td>
                    <td>202</td>
                    <td>2025-04-02</td>
                    <td>2025-04-06</td>
                    <td><span class="badge bg-warning">Pending</span></td>
                </tr>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>