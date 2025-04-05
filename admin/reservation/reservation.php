<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Form</title>
  <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    <h2>Reservation Form</h2>
    <form action="#" method="POST">
        <!--Reserver's Name -->
        <label for="reservee">Reserver's Name:</label>
        <input type="text" id="reservee" name="reservee" required>

        <!--Booking Date-->
        <label for="booking_date">Booking Date:</label>
        <input type="date" id="booking_date" name="booking_date" required>

        <!--Start Date-->
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>

        <!--End Date-->
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required>

        
        <button class="btn btn-primary btn-sm m-2" type="submit">Submit Reservation</button>
    </form>
    <!--Bootstrap JS-->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>