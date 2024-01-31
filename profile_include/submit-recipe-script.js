document.addEventListener('DOMContentLoaded', function() {
    var buttons = document.querySelectorAll('.ingredient-button');
    var selectedIngredients = [];
    var searchInput = document.getElementById('ingredient-search');
    var image = document.getElementById('image');
    var ingredientItems = document.querySelectorAll('.ingredient-item');

    // Select ingredients
    document.querySelectorAll('.ingredient-button').forEach(button => {
        button.addEventListener('click', function() {
            let ingredientDiv = this.nextElementSibling;
            let ingredientName = this.getAttribute('data-name');
            let amountInput = ingredientDiv.querySelector('.amount');
            let unitSelect = ingredientDiv.querySelector('.unit');
            let amount = amountInput.value;
            let unit = unitSelect.value;
            let ingredientIndex = selectedIngredients.findIndex(ingredient => ingredient.name === ingredientName);

            // Toggle selection
            if (ingredientIndex > -1) {
                selectedIngredients.splice(ingredientIndex, 1);
                this.classList.remove('selected');
                amountInput.disabled = false;
                unitSelect.disabled = false;
            } else {
                if (amount && unit && unit !== 'units') {
                    // Select and disable fields to prevent editing
                    selectedIngredients.push({ name: ingredientName, amount: amount, unit: unit });
                    this.classList.add('selected');
                    amountInput.disabled = true;
                    unitSelect.disabled = true;
                } else {
                    alert('Please fill in the amount and select a unit.');
                }
            }
        });
    });

    // Search bar
    searchInput.addEventListener('input', function() {
        var searchText = this.value.toLowerCase();

        ingredientItems.forEach(function(item) {
            var ingredientButton = item.querySelector('.ingredient-button');
            var ingredientName = ingredientButton.getAttribute('data-name').toLowerCase();

            if (ingredientName.includes(searchText)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Add image with imgurAPI
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
            alert('Please fill in all fields including image and select at least one ingredient.');
            return;
        }

        // Set the value of the hidden input field for selected ingredients
        document.getElementById('selected-ingredients').value = JSON.stringify(selectedIngredients);

        // AJAX submission
        submitForm();
    });

    function validateForm() {
        // Check if all text inputs are filled
        const inputs = document.querySelectorAll('input[type=text]:not(#ingredient-search)');
        for (let input of inputs) {
            if (input.value.trim() === '') {
                return false;
            }
        }

        // Check if any ingredient is selected
        if (selectedIngredients.length === 0) {
            return false;
        }

        // Check if an image is selected
        const imageInput = document.getElementById('image');
        if (!imageInput.files.length) {
            return false;
        }

        return true;
    }

    function submitForm() {
        const formData = new FormData(document.querySelector('form'));

        fetch('profile_include/submission.php', {
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

