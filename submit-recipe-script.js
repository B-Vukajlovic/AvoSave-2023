document.addEventListener('DOMContentLoaded', function() {
    var buttons = document.querySelectorAll('.ingredient-button');
    var selectedIngredients = [];
    var searchInput = document.getElementById('ingredient-search');
    var image = document.getElementById('image');

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

    image.addEventListener('change', function(event) {
        const file = event.target.files[0];
        const formData = new FormData();
        formData.append('image', file);

        fetch('https://api.imgur.com/3/image/', {
            method: 'POST',
            headers: {
                Authorization: 'Bearer ee082f003b505f523b4db0702257612baad6effe'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(`Error ${response.status}: ${JSON.stringify(errorData)}`);
                });
            }
            return response.json();
        })
        .then(data => {
            if(data.success) {
                const link = data.data.link;
                document.querySelector('.img').src = link;
                document.getElementById('imgur-url').value = link;
            }
        })
        .catch(error => console.error('Error:', error));
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

    function validateForm() {
        // Check if all inputs are filled
        const inputs = document.querySelectorAll('input[type=text]:not(#ingredient-search)');
        for (let input of inputs) {
            if (input.value.trim() === '') {
                return false;
            }
        }

        // Check if any ingredient is selected
        return selectedIngredients.length > 0;
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
});

