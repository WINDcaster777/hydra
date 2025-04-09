<?php
require_once ("../properties/connection.php");

$sql = "SELECT * FROM facility WHERE status = 'available'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Facility Booking</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <h1 class="text-center mb-4">Available Facilities</h1>
  <div class="row g-4">

    <?php if ($result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <img src="../<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['name']) ?>" style="height: 200px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
              <p class="card-text"><?= htmlspecialchars($row['details']) ?></p>
              <p class="fw-bold">Price: ₱<?= number_format($row['price'], 2) ?></p>
              <button 
                class="btn btn-primary mt-auto"
                data-bs-toggle="modal"
                data-bs-target="#reservationModal"
                data-facility="<?= htmlspecialchars($row['name']) ?>"
                data-price="<?= $row['price'] ?>">
                Book Now
              </button>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-center">No facilities available at the moment.</p>
    <?php endif; ?>
  </div>
</div>

<!-- Reservation Modal -->
<div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="reservationModalLabel">Reservation Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="reservationForm">
          <input type="hidden" id="facilityName" name="facilityName">

          <div class="mb-3">
            <label class="form-label">Facility</label>
            <input type="text" class="form-control" id="facilityDisplay" readonly>
          </div>

          <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" placeholder="John Doe" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" placeholder="name@example.com" required>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="startDate" class="form-label">Check in</label>
              <input type="date" class="form-control" id="startDate" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="endDate" class="form-label">Check out</label>
              <input type="date" class="form-control" id="endDate" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="price" class="form-label">Total Price</label>
            <input type="text" class="form-control" id="price" readonly>
          </div>

          <div class="mb-3">
            <label for="notes" class="form-label">Additional Notes</label>
            <textarea class="form-control" id="notes" rows="3" placeholder="Any special requests?"></textarea>
          </div>

          <button type="submit" class="btn btn-primary w-100">Submit Reservation</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/reservation.js"></script>
</body>
</html>
<?php $conn->close(); ?>
