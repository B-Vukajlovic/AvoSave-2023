document.addEventListener('DOMContentLoaded', function() {
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

    // Form submission event
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();

        // Validation
        if (!validateForm()) {
            alert('Please fill in all fields and select at least one ingredient.');
            return;
        }

        // Set the value of the hidden input field for selected ingredients
        document.getElementById('selected-ingredients').value = JSON.stringify(selectedIngredients);

        // AJAX submission
        submitForm();
    });
});

function validateForm() {
    // Check if all inputs are filled
    const inputs = document.querySelectorAll('input[type=text]:not(#ingredient-search)');
    for (let input of inputs) {
        if (input.value.trim() === '') {
            return false;
        }
    }

    // Check if any ingredient is selected
    return selectedIngredients > 0;
}

function submitForm() {
    const formData = new FormData(document.querySelector('form'));

    fetch('submission.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Display success/failure message
        alert(data);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting the form.');
    });
}
