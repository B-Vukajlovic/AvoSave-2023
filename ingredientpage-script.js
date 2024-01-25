document.addEventListener('DOMContentLoaded', function() {
    var dropdown = document.getElementById('dropdown-content');
    dropdown.value = "All";
    var buttons = document.querySelectorAll('.ingredient-button');
    var selectedIngredients = [];
    var searchInput = document.getElementById('ingredient-search');

    // Select ingredients
    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            var ingredientName = this.textContent;

            if (selectedIngredients.includes(ingredientName)) {
                var index = selectedIngredients.indexOf(ingredientName);
                selectedIngredients.splice(index, 1);
                this.classList.remove('selected');
            } else {
                selectedIngredients.push(ingredientName);
                this.classList.add('selected');
            }
        });
    });

    // Dropdown menu
    dropdown.addEventListener('change', function() {
        var selectedType = this.value;
        buttons.forEach(function(button) {
            if (selectedType === 'All' || button.getAttribute('data-type') === selectedType) {
                button.style.display = '';
            } else {
                button.style.display = 'none';
            }
        });
    });

    // Search bar
    searchInput.addEventListener('input', function() {
        var searchText = this.value.toLowerCase();

        buttons.forEach(function(button) {
            var ingredientName = button.textContent.toLowerCase();
            if (ingredientName.includes(searchText)) {
                button.style.display = '';
            } else {
                button.style.display = 'none';
            }
        });
    });

    // Send ingredients
    document.getElementById('ingredient-form').addEventListener('submit', function(event) {
        document.getElementById('selected-ingredients').value = JSON.stringify(selectedIngredients);
    });
});