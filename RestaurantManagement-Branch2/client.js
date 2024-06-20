document.addEventListener('DOMContentLoaded', () => {
    const searchForm = document.getElementById('search-form');
    const queryInput = document.getElementById('query');
    const searchResults = document.getElementById('search-results');

    searchForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const query = queryInput.value;

        try {
            const response = await fetch(`/search?query=${query}`);
            if (!response.ok) {
                throw new Error('Failed to fetch data');
            }

            const data = await response.json();

            // Clear previous search results
            searchResults.innerHTML = '';

            // Display search results
            data.forEach(menuItem => {
                const menuItemElement = document.createElement('div');
                menuItemElement.textContent = `Name: ${menuItem.name}, Price: ${menuItem.price}`;
                searchResults.appendChild(menuItemElement);
            });
        } catch (error) {
            console.error('Error:', error);
        }
    });
});