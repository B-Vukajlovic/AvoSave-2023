document.addEventListener('DOMContentLoaded', function() {
    var dropdown = document.getElementById('category-dropdown');
    var container = document.getElementById('ingredients-container');

    dropdown.addEventListener('change', function() {
        var category = this.value;
        updateButtons(category);
    });

    function updateButtons(category) {
        container.innerHTML = '';

        fetch('IngredientPage.php?category=' + category, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            data.forEach(ingredient => {
                var button = document.createElement('button');
                button.textContent = ingredient;
                container.appendChild(button);
            });
        })
        .catch(error => console.error('Error:', error));
    }

    updateButtons(dropdown.value);
});
