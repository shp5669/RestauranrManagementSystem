let menuItems = [
  { name: 'Risotto', price: 20.00 },
  { name: 'Margherita Pizza', price: 18.00 },
  { name: 'Spaghetti Carbonara', price: 24.00 },
];

const menuList = document.getElementById('menu-list');
const itemNameInput = document.getElementById('item-name');
const itemPriceInput = document.getElementById('item-price');
const editItemNameInput = document.getElementById('edit-item-name');
const editItemPriceInput = document.getElementById('edit-item-price');
const editMenuItemForm = document.getElementById('edit-menu-item');

function displayMenu() {
  menuList.innerHTML = '';
  menuItems.forEach((item, index) => {
    const li = document.createElement('li');
    li.innerHTML = `${item.name} - $${item.price}`;
    li.innerHTML += ` <button onclick="editItem(${index})">Edit</button>`;
    li.innerHTML += ` <button onclick="deleteItem(${index})">Delete</button>`;
    menuList.appendChild(li);
  });
}

function addItem() {
  const name = itemNameInput.value;
  const price = parseFloat(itemPriceInput.value);
  if (name && price) {
    menuItems.push({ name, price });
    displayMenu();
    itemNameInput.value = '';
    itemPriceInput.value = '';
  }
}

function editItem(index) {
  const item = menuItems[index];
  editItemNameInput.value = item.name;
  editItemPriceInput.value = item.price;
  editMenuItemForm.style.display = 'block';
  editMenuItemForm.dataset.editIndex = index;
}

function updateItem() {
  const index = parseInt(editMenuItemForm.dataset.editIndex);
  const name = editItemNameInput.value;
  const price = parseFloat(editItemPriceInput.value);

  if (!isNaN(index) && name && price) {
    menuItems[index] = { name, price };
    displayMenu();
    editMenuItemForm.style.display = 'none';
  }
}

function cancelEdit() {
  editMenuItemForm.style.display = 'none';
}

function deleteItem(index) {
  menuItems.splice(index, 1);
  displayMenu();
}

displayMenu();
