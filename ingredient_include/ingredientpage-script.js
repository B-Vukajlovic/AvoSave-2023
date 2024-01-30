document.addEventListener('DOMContentLoaded', function() {
    var dropdown = document.getElementById('dropdown-content');
    dropdown.value = "All";
    var buttons = document.querySelectorAll('.ingredient-button');
    var selectedIngredients = JSON.parse(sessionStorage.getItem('selectedIngredients') || '[]');
    var searchInput = document.getElementById('ingredient-search');

    // Initialize button states based on session storage
    buttons.forEach(function(button) {
        if (selectedIngredients.includes(button.textContent)) {
            button.classList.add('selected');
        }
    });

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
            sessionStorage.setItem('selectedIngredients', JSON.stringify(selectedIngredients));
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
        dropdown.value = 'All';

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
        document.getElementById('selected-ingredients').value = sessionStorage.getItem('selectedIngredients');
    });
});