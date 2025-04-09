document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("reservationModal");
  const facilityInput = document.getElementById("facilityName");
  const facilityDisplay = document.getElementById("facilityDisplay");
  const startDate = document.getElementById("startDate");
  const endDate = document.getElementById("endDate");
  const priceField = document.getElementById("price");

  let dailyRate = 0;

  modal.addEventListener("show.bs.modal", function (event) {
    const button = event.relatedTarget;
    const facility = button.getAttribute("data-facility");
    dailyRate = parseFloat(button.getAttribute("data-price")) || 0;

    facilityInput.value = facility;
    facilityDisplay.value = facility;
    priceField.value = "₱0.00";

    startDate.value = "";
    endDate.value = "";
  });

  function calculatePrice() {
    const start = new Date(startDate.value);
    const end = new Date(endDate.value);

    if (!isNaN(start) && !isNaN(end) && end > start) {
      const diffTime = Math.abs(end - start);
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      const total = diffDays * dailyRate;
      priceField.value = `₱${total.toLocaleString(undefined, { minimumFractionDigits: 2 })}`;
    } else {
      priceField.value = "";
    }
  }

  startDate.addEventListener("change", calculatePrice);
  endDate.addEventListener("change", calculatePrice);
});
