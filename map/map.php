<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map with Inputs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="css/map.css">
</head>
<body class="container py-4">
<?php include ('../menu/menu.php')?>
    <div class="row">
        <!-- Map Container -->
        <div class="col-12 col-md-8 mb-4">
            <div id="map-container" class="border"></div>
        </div>

        <!-- Form Container -->
        <div class="col-12 col-md-4">
            <div class="icon-container mb-3">
                <span class="icon-option" onclick="addIconToMap(event, 'available')">
                    <span class="badge bg-success rounded-circle" style="width: 20px; height: 20px;">&nbsp;</span>
                </span>
                <span class="icon-option" onclick="addIconToMap(event, 'unavailable')">
                    <span class="badge bg-danger rounded-circle" style="width: 20px; height: 20px;">&nbsp;</span>
                </span>
            </div>
            <form id="markerForm" class="form-group" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="icon" id="icon"> <!-- Hidden input for icon -->
                <input type="text" name="location" id="location"> <!-- Hidden input for POINT (x, y) -->

                <div class="mb-2">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Details</label>
                    <textarea name="details" id="details" class="form-control" required></textarea>
                </div>

                <div class="mb-2">
                    <label class="form-label">Price</label>
                    <input type="number" name="price" id="price" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Facility Image</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                </div>

                <div class="mb-3">
                    <button type="submit" id="saveMarker" class="btn btn-success save-btn w-100">Save Marker</button>
                    <button type="button" id="removeMarker" class="btn btn-danger remove-btn w-100 mt-2" onclick="removeSelectedMarker()">Remove Marker</button>
                    <button type="button" id="updateMarker" class="btn btn-warning w-100 mt-2" onclick="updateMarker()">Update Marker</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table for displaying markers -->
    <div class="col-12 mt-4">
        <h3>Marker List</h3>
        <table id="markersTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Details</th>
                    <th>Status</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Table data will be populated by JavaScript -->
            </tbody>
        </table>
    </div>

    <!-- Include SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.all.min.js"></script>

    <!-- jQuery (needed for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="js/map.js"></script>
</body>
</html>
