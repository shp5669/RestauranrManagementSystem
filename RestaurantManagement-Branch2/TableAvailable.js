document.addEventListener("DOMContentLoaded", function() {
    // Reference to the table body
    const tableBody = document.getElementById("tableBody");

    // Function to generate a table row
    function generateTableRow(tableNumber, capacity, availability) {
        const tr = document.createElement("tr");
        const tdTableNumber = document.createElement("td");
        const tdCapacity = document.createElement("td");
        const tdAvailability = document.createElement("td");
        const tdAction = document.createElement("td");
        
        const requestBtn = document.createElement("button");
        const makeAvailableBtn = document.createElement("button");

        tdTableNumber.textContent = `Table ${tableNumber}`;
        tdCapacity.textContent = capacity;
        tdAvailability.textContent = availability;

        requestBtn.textContent = "Request Reservation";
        makeAvailableBtn.textContent = "Make Available";
        makeAvailableBtn.style.display = "none";  // initially hidden

        requestBtn.addEventListener("click", function() {
            toggleAvailability(tdAvailability, requestBtn, makeAvailableBtn, "Unavailable");
        });

        makeAvailableBtn.addEventListener("click", function() {
            toggleAvailability(tdAvailability, requestBtn, makeAvailableBtn, "Available");
        });

        tdAction.appendChild(requestBtn);
        tdAction.appendChild(makeAvailableBtn);

        tr.appendChild(tdTableNumber);
        tr.appendChild(tdCapacity);
        tr.appendChild(tdAvailability);
        tr.appendChild(tdAction);
        
        return tr;
    }

    // Function to toggle the availability of the table
    function toggleAvailability(tdAvailability, requestBtn, makeAvailableBtn, status) {
        tdAvailability.textContent = status;

        if (status === "Available") {
            requestBtn.style.display = "";
            makeAvailableBtn.style.display = "none";
        } else {
            requestBtn.style.display = "none";
            makeAvailableBtn.style.display = "";
        }
    }

    // Generate 10 table rows and append them to the table body
    for (let i = 1; i <= 10; i++) {
        const row = generateTableRow(i, 4, "Available");
        tableBody.appendChild(row);
    }

    // Redirect to homepage
    const homeButton = document.getElementById("backToHome");
    homeButton.addEventListener("click", function() {
        window.location.href = "homepage.html";
    });
});
