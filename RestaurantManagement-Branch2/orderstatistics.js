// Sample data for demonstration
const menuItems = ["Pizza", "Burger", "Pasta", "Salad"];
const orders = [45, 30, 25, 20];
const topSellingThisWeek = ["Pizza", "Burger", "Pasta", "Salad"];

const customerData = [
    { customer_name: 'Customer 1', total_orders: 20 },
    { customer_name: 'Customer 2', total_orders: 15 },
    { customer_name: 'Customer 3', total_orders: 12 },
];

function displayMenuItemsChart() {
    const ctx = document.getElementById("menu-chart").getContext("2d");

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: menuItems,
            datasets: [{
                label: 'Total Orders',
                data: orders,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function displayTopSellingForDate(selectedDate) {
    const topSellingList = document.getElementById("top-selling-list");
    const currentDate = new Date();

    topSellingList.innerHTML = "";

    if (new Date(selectedDate) > currentDate) {
        alert("Selected date cannot be in the future.");
    } else {
        const filteredTopSelling = topSellingThisWeek
            .filter(item => menuItems.includes(item))
            .filter(item => item.includes(selectedDate));

        filteredTopSelling.forEach(item => {
            const listItem = document.createElement("li");
            listItem.textContent = item;
            topSellingList.appendChild(listItem);
        });
    }
}

function displayCustomerChart() {
    const ctx = document.getElementById('customer-chart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: customerData.map(customer => customer.customer_name),
            datasets: [{
                label: 'Total Orders',
                data: customerData.map(customer => customer.total_orders),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function displayCustomerRanks() {
    const sortedCustomers = [...customerData].sort((a, b) => b.total_orders - a.total_orders);
    sortedCustomers.forEach((customer, index) => {
        customer.rank = index + 1;
    });
    
    const topCustomerElement = document.getElementById("top-customer");
    if (sortedCustomers.length > 0) {
        topCustomerElement.textContent = `Top Customer: ${sortedCustomers[0].customer_name} (Rank #${sortedCustomers[0].rank}, Orders: ${sortedCustomers[0].total_orders})`;
    } else {
        topCustomerElement.textContent = "No customer data available.";
    }
}

function initCharts() {
    displayMenuItemsChart();
    displayCustomerChart();
    displayCustomerRanks();

    const viewDailySalesButton = document.getElementById("view-daily-sales");
    viewDailySalesButton.addEventListener('click', () => {
        const selectedDate = document.getElementById("date-select").value;
        displayTopSellingForDate(selectedDate);
    });
}

window.addEventListener('load', initCharts);
