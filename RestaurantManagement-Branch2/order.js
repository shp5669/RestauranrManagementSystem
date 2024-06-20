const orders = [];

function addOrder() {
    
    const product = document.getElementById('product').value;
    const quantity = parseInt(document.getElementById('quantity').value);
    const orderId = parseInt(document.getElementById('orderId').value);

    if (product && !isNaN(orderId) && !isNaN(quantity) && orderId > 0 && quantity > 0) {
        const order = {
            orderId,
            product,
            quantity,
            
        };

        orders.push(order);

        document.getElementById('orderId').value = '';
        document.getElementById('quantity').value = '';
        document.getElementById('product').value = '';

        displayOrders();
    } else {
        alert('Invalid input.Please retype');
    }
}

function displayOrders() {
    const orderList = document.getElementById('orderList');
    orderList.innerHTML = '';

    orders.forEach((order, index) => {
        const listItem = document.createElement('li');
        listItem.innerHTML = `OrderID: ${order.orderId} <br/> Product: ${order.product} <br/> Quantity: ${order.quantity}`;
        
        //const editButton = document.createElement('button');
        //editButton.innerText = 'Edit';
        //editButton.onclick = () => editOrder(index);

        const deleteButton = document.createElement('button');
        deleteButton.innerText = 'Delete';
        deleteButton.onclick = () => deleteOrder(index);

        const checkoutButton = document.createElement('button');
        checkoutButton.innerText = 'Checkout';

        //listItem.appendChild(editButton);
        listItem.appendChild(deleteButton);
        listItem.appendChild(checkoutButton);

        orderList.appendChild(listItem);
    });
}

// function editOrder(index) {
//     const newProduct = prompt('Enter new product:');
//     const newQuantity = parseInt(prompt('Enter new quantity:'));

//     if (newProduct && !isNaN(newQuantity)) {
//         orders[index].product = newProduct;
//         orders[index].quantity = newQuantity;

//         displayOrders();
//     } else {
//         alert('Please enter new product and quantity needed.');
//     }
// }

function deleteOrder(index) {
    const confirmDelete = confirm('Are you sure you want to delete this order?');

    if (confirmDelete) {
        orders.splice(index, 1);
        displayOrders();
    }
}

document.getElementById('addOrderButton').addEventListener('click', addOrder);

displayOrders();
