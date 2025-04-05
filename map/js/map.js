let selectedMarker = null;
let markers = [];



function addIconToMap(event, icon) {
    const mapContainer = document.getElementById('map-container');
    const iconInput = document.getElementById('icon');
    const locationInput = document.getElementById('location');

    if (!mapContainer || !iconInput || !locationInput) {
        console.error("Map container, icon input field, or location input field not found!");
        return;
    }

    const marker = document.createElement('div');
    marker.classList.add('marker');
    marker.innerText = icon;
    marker.draggable = true;
    marker.style.position = 'absolute';
    marker.style.left = '50%';
    marker.style.top = '50%';
    marker.style.cursor = 'grab';

    // Store the selected icon in the hidden input field
    iconInput.value = icon;

    marker.addEventListener('click', function () {
        selectedMarker = marker;
        document.getElementById('removeMarker').style.display = 'block';
        document.getElementById('updateMarker').style.display = 'block';
        document.getElementById('saveMarker').style.display = 'none'; // Hide save button after clicking a marker
        updateFormValues(marker);
    });

    marker.addEventListener('dragstart', function (e) {
        e.dataTransfer.setData('text/plain', ''); // Required for Firefox
        marker.style.opacity = "0.6";
        marker.style.cursor = 'grabbing';
    });

    marker.addEventListener('dragend', function (e) {
        marker.style.opacity = "1";
        marker.style.cursor = 'grab';

        const mapRect = mapContainer.getBoundingClientRect();

        // Calculate new position but restrict it within map bounds
        const newLeft = Math.min(Math.max(0, e.clientX - mapRect.left), mapRect.width - marker.offsetWidth);
        const newTop = Math.min(Math.max(0, e.clientY - mapRect.top), mapRect.height - marker.offsetHeight);

        marker.style.left = `${newLeft}px`;
        marker.style.top = `${newTop}px`;

        // Update the input values for the location (POINT format)
        updateFormValues(marker);
    });

    mapContainer.appendChild(marker);
    markers.push(marker);

    // Show save button immediately after adding the marker
    document.getElementById('saveMarker').style.display = 'block';
    document.getElementById('removeMarker').style.display = 'none';
    document.getElementById('updateMarker').style.display = 'none';
}

function updateFormValues(marker) {
    const rect = marker.getBoundingClientRect();
    const mapContainer = document.getElementById('map-container');

    // Ensure consistent scaling based on map aspect ratio
    const originalWidth = 1920;
    const originalHeight = 1080;
    const scaleX = originalWidth / mapContainer.clientWidth;
    const scaleY = originalHeight / mapContainer.clientHeight;

    // Calculate the marker's position relative to the map's original dimensions
    const markerLeft = rect.left - mapContainer.getBoundingClientRect().left;
    const markerTop = rect.top - mapContainer.getBoundingClientRect().top;

    const pointX = Math.round(markerLeft * scaleX);
    const pointY = Math.round(markerTop * scaleY);

    // Store the position in POINT(x, y) format
    document.getElementById('location').value = `POINT(${pointX}, ${pointY})`;

    // Update the x and y values for visual representation
    document.getElementById('x').value = pointX;
    document.getElementById('y').value = pointY;
}

function removeSelectedMarker() {
    if (selectedMarker) {
        markers = markers.filter(m => m !== selectedMarker);
        selectedMarker.remove();
        resetForm();
        selectedMarker = null;
    }
}

function saveMarker() {
    if (selectedMarker) {
        console.log("Saved Marker:", getFormData());

        Swal.fire({
            title: 'Success!',
            text: 'Marker Saved!',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(resetForm);
    }
}

function updateMarker() {
    if (selectedMarker) {
        console.log("Updated Marker:", getFormData());

        Swal.fire({
            title: 'Success!',
            text: 'Marker Updated!',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(resetForm);
    }
}

function resetForm() {
    document.getElementById('markerForm').reset();
    document.getElementById('removeMarker').style.display = 'none';
    document.getElementById('updateMarker').style.display = 'none';
    document.getElementById('saveMarker').style.display = 'none';
    selectedMarker = null;
}

function getFormData() {
    return {
        name: document.getElementById('name').value,
        location: document.getElementById('location').value, // Send the POINT(x, y) format
        details: document.getElementById('details').value,
        icon: document.getElementById('icon').value
    };
}

document.getElementById("markerForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the default form submission

    // Gather form data
    const formData = new FormData(this);

    fetch('map_add.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            Swal.fire({
                title: data.status === 'success' ? 'Success!' : 'Error!',
                text: data.message,
                icon: data.status === 'success' ? 'success' : 'error',
                confirmButtonText: 'OK'
            }).then(() => {
                if (data.status === 'success') resetForm();
            });
        })
        .catch(() => {
            Swal.fire({
                title: 'Error!',
                text: 'There was an issue with the request.',
                icon: 'error',
                confirmButtonText: 'Try Again'
            });
        });
});

// Fetch existing markers on page load and place them on the map
fetch('map_retrieve.php')
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            data.markers.forEach(markerData => {
                console.log("Marker:", markerData);
                // Create markers based on the data from the database
                addExistingMarker(markerData);
            });
        } else {
            console.error("Error retrieving markers:", data.message);
        }
    })
    .catch(error => console.error("Fetch error:", error));

// Add existing marker to the map
    function addExistingMarker(markerData) {
        const mapContainer = document.getElementById('map-container');
        const marker = document.createElement('div');
        marker.classList.add('marker');
        marker.innerText = markerData.icon;
        marker.style.position = 'absolute';
    
        const containerRect = mapContainer.getBoundingClientRect();
    
        // Scaling based on original resolution
        const originalWidth = 1920;
        const originalHeight = 1080;
        const scaleX = containerRect.width / originalWidth;
        const scaleY = containerRect.height / originalHeight;
    
        // Shift the marker slightly to the left to correct the alignment
        const left = markerData.x * scaleX - -13; // Adjusted from -12 to -10 for a minor left shift
        const top = markerData.y * scaleY - -13; // Vertical adjustment remains unchanged
    
        marker.style.left = `${left}px`;
        marker.style.top = `${top}px`;

        marker.addEventListener('click', function () {
            // Populate the form with the marker data
            selectedMarker = marker;
            document.getElementById('removeMarker').style.display = 'block';
            document.getElementById('updateMarker').style.display = 'block';
            document.getElementById('saveMarker').style.display = 'none';
            document.getElementById('name').value = markerData.name;
            document.getElementById('location').value = `POINT(${markerData.x}, ${markerData.y})`;
            document.getElementById('details').value = markerData.details;
            document.getElementById('icon').value = markerData.icon;
        });
    
        mapContainer.appendChild(marker);
}



$(document).ready(function() {
    // Initialize the DataTable
    const table = $('#markersTable').DataTable();

    // Fetch data from map_list.php to populate the table
    $.ajax({
        url: 'map_list.php', // URL to map_list.php
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // Populate the DataTable with the markers
                response.markers.forEach(marker => {
                    table.row.add([
                        marker.name,  // Name
                        marker.details,  // Details
                        marker.status,  // Status (Now showing actual status from the database)
                        `<button class="btn btn-primary btn-sm" onclick="editMarker(${marker.id})">Edit</button>
                         <button class="btn btn-danger btn-sm" onclick="deleteMarker(${marker.id})">Delete</button>`  // Actions
                    ]).draw(false);  // Draw without resetting
                });
            } else {
                alert('Failed to load markers: ' + response.message);
            }
        },
        error: function() {
            alert('Error loading markers from the server.');
        }
    });

    // Example: Handle the save marker function (if relevant)
    $('#saveMarker').on('click', function(event) {
        event.preventDefault();  // Prevent form submission

        // Retrieve form data
        const name = $('#name').val();
        const details = $('#details').val();
        const status = 'Active';  // Example status, adjust based on form data

        // Add row to DataTable (this is a placeholder, adjust according to your needs)
        table.row.add([
            name,  // Name
            details,  // Details
            status  // Example status
        ]).draw(false);  // Draw without resetting

        // Clear form fields
        $('#name').val('');
        $('#details').val('');
    });
});

// Function to edit a marker (implementation needed)
function editMarker(id) {
    console.log('Edit marker with ID:', id);
    // Implement the functionality to fetch and edit the marker
}

// Function to delete a marker (implementation needed)
function deleteMarker(id) {
    console.log('Delete marker with ID:', id);
    // Implement the functionality to delete the marker
}

function deleteMarker(id) {
    if (confirm('Are you sure you want to delete this marker?')) {
        // Send AJAX request to delete the marker
        $.ajax({
            url: 'map_delete.php',
            method: 'GET',
            data: { id: id },  // Send the marker ID
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Success - Update the UI (remove the row from DataTable)
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Remove the marker from the DataTable
                        $('#markersTable').DataTable().row(`#marker_${id}`).remove().draw();
                    });
                } else {
                    // Error - Show the message
                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an issue with the deletion request.',
                    icon: 'error',
                    confirmButtonText: 'Try Again'
                });
            }
        });
    }
}
