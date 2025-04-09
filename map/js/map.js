let selectedMarker = null;
let markers = [];

function addIconToMap(event, status) {
    const mapContainer = document.getElementById('map-container');
    const locationInput = document.getElementById('location');

    if (!mapContainer || !locationInput) {
        console.error("Map container or location input field not found!");
        return;
    }

    // Create the marker element
    const marker = document.createElement('div');
    marker.classList.add('marker');
    marker.style.position = 'absolute';
    marker.style.left = '50%';
    marker.style.top = '50%';
    marker.style.cursor = 'grab';
    marker.style.width = '20px';
    marker.style.height = '20px';
    marker.style.borderRadius = '50%';

    // Set marker color based on status
    marker.style.backgroundColor = status === 'available' ? 'green' : 'red';
    marker.setAttribute('data-status', status);

    // Make the marker draggable
    marker.draggable = true;
    marker.addEventListener('click', function () {
        selectedMarker = marker;
        document.getElementById('removeMarker').style.display = 'block';
        document.getElementById('updateMarker').style.display = 'block';
        document.getElementById('saveMarker').style.display = 'none';
        updateFormValues(marker);
    });

    marker.addEventListener('dragstart', function (e) {
        e.dataTransfer.setData('text/plain', '');
        marker.style.opacity = "0.6";
        marker.style.cursor = 'grabbing';
    });

    marker.addEventListener('dragend', function (e) {
        marker.style.opacity = "1";
        marker.style.cursor = 'grab';

        const mapRect = mapContainer.getBoundingClientRect();
        const newLeft = Math.min(Math.max(0, e.clientX - mapRect.left), mapRect.width - marker.offsetWidth);
        const newTop = Math.min(Math.max(0, e.clientY - mapRect.top), mapRect.height - marker.offsetHeight);

        marker.style.left = `${newLeft}px`;
        marker.style.top = `${newTop}px`;

        updateFormValues(marker);
    });

    mapContainer.appendChild(marker);
    markers.push(marker);

    document.getElementById('saveMarker').style.display = 'block';
    document.getElementById('removeMarker').style.display = 'none';
    document.getElementById('updateMarker').style.display = 'none';
}

function updateFormValues(marker) {
    const rect = marker.getBoundingClientRect();
    const mapContainer = document.getElementById('map-container');

    const originalWidth = 1920;
    const originalHeight = 1080;
    const scaleX = originalWidth / mapContainer.clientWidth;
    const scaleY = originalHeight / mapContainer.clientHeight;

    const markerLeft = rect.left - mapContainer.getBoundingClientRect().left;
    const markerTop = rect.top - mapContainer.getBoundingClientRect().top;

    const pointX = Math.round(markerLeft * scaleX);
    const pointY = Math.round(markerTop * scaleY);

    document.getElementById('location').value = `POINT(${pointX} ${pointY})`;
    document.getElementById('x').value = pointX;
    document.getElementById('y').value = pointY;
    const status = marker.getAttribute('data-status');
    document.querySelector(`input[name="status"][value="${status}"]`).checked = true;
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
        const form = document.getElementById('markerForm');
        const formData = new FormData(form);

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
                if (data.status === 'success') {
                    location.reload();  // Reload page after saving
                }
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
    }
}


function updateMarker() {
    if (selectedMarker) {
        console.log("Updated Marker:", getFormData());

        fetch('map_update.php', {
            method: 'POST',
            body: new URLSearchParams(getFormData())
        })
        .then(response => response.json())
        .then(data => {
            Swal.fire({
                title: 'Success!',
                text: 'Marker Updated!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload();  // Reload page after updating
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
        location: document.getElementById('location').value,
        details: document.getElementById('details').value,
        status: document.querySelector('input[name="status"]:checked')?.value || 'unavailable',
        price: document.getElementById('price').value
    };
}

document.getElementById("markerForm").addEventListener("submit", function (event) {
    event.preventDefault();

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
                if (data.status === 'success') location.reload();  // Reload page after saving
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

fetch('map_retrieve.php')
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            data.markers.forEach(markerData => {
                addExistingMarker(markerData);
            });
        } else {
            console.error("Error retrieving markers:", data.message);
        }
    })
    .catch(error => console.error("Fetch error:", error));

    function addExistingMarker(markerData) {
        const mapContainer = document.getElementById('map-container');
        const marker = document.createElement('div');
        marker.classList.add('marker');
        marker.style.position = 'absolute';
        marker.style.width = '30px'; // Increase size for mobile
        marker.style.height = '30px'; // Increase size for mobile
        marker.style.borderRadius = '50%';
        marker.style.cursor = 'pointer'; // Use pointer for touch devices
    
        // Set marker color based on status
        const status = markerData.status.toLowerCase();
        marker.style.backgroundColor = status === 'available' ? 'green' : 'red'; // Green for available, Red for unavailable
    
        // Function to update marker position
        function updateMarkerPosition() {
            const containerRect = mapContainer.getBoundingClientRect();
            const originalWidth = 1920;
            const originalHeight = 1080;
            const scaleX = containerRect.width / originalWidth;
            const scaleY = containerRect.height / originalHeight;
    
            // Calculate marker position
            const markerWidth = parseFloat(marker.style.width);
            const markerHeight = parseFloat(marker.style.height);
            const left = (markerData.x * scaleX) - (markerWidth - 38);
            const top = (markerData.y * scaleY) - (markerHeight - 42);
    
            marker.style.left = `${left}px`;
            marker.style.top = `${top}px`;
        }
    
        // Initial position update
        updateMarkerPosition();
    
        // Update position on window resize
        window.addEventListener('resize', updateMarkerPosition);
    
        marker.addEventListener('click', function () {
            selectedMarker = marker;
            document.getElementById('removeMarker').style.display = 'block';
            document.getElementById('updateMarker').style.display = 'block';
            document.getElementById('saveMarker').style.display = 'none';
            document.getElementById('name').value = markerData.name;
            document.getElementById('location').value = `POINT(${markerData.x} ${markerData.y})`;
            document.getElementById('details').value = markerData.details;
            document.getElementById('price').value = markerData.price;
            const statusRadio = document.querySelector(`input[name="status"][value="${markerData.status.toLowerCase()}"]`);
            if (statusRadio) statusRadio.checked = true;
        });
    
        mapContainer.appendChild(marker);
    }
    
     

$('#markersTable').DataTable({
    ajax: 'map_list.php',
    columns: [
        { data: 'id' },
        { data: 'name' },
        { data: 'details' },
        { data: 'status' },
        { data: 'price'},
        {
            data: null,
            render: function (data, type, row) {
                return `
                    <button class="btn btn-danger btn-sm" onclick="deleteMarker(${row.id})">Delete</button>
                `;
            }
        }
    ]
});

function deleteMarker(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This marker will be permanently deleted.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('map_delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + encodeURIComponent(id)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire('Deleted!', data.message, 'success');
                    // Reload the table after deletion
                    $('#markersTable').DataTable().ajax.reload(null, false);
                    // Or you can reload the page entirely
                     location.reload();
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(() => {
                Swal.fire('Error!', 'Failed to delete the marker.', 'error');
            });
        }
    });
}
