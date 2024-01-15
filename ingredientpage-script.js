document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.label-available');
    const dropdown = document.getElementById('category-dropdown');

    const fruits = ["Apple", "Avocado", "Banana", "Grape", "Kiwi", "Peach", "Orange", "Pineapple", "Pear", "Watermelon", "Cherry", "Mango", "Blueberry", "Pomegranate", "Raspberry", "Lemon", "Grapefruit", "Passion fruit", "Lime", "Fig"];
    const vegetables = ["Carrot", "Broccoli", "Asparagus", "Cauliflower", "Corn", "Cucumber", "Eggplant", "Green Pepper", "Lettuce", "Mushrooms", "Onion", "Potato", "Pumpkin", "Red Pepper", "Spinach", "Sweet Potato", "Tomato", "Beetroot", "Brussel Sprouts", "Peas"];
    const meatAndFish = ["Chicken", "Beef", "Pork", "Salmon", "Tuna"];
    const seasoning = ["Salt", "Pepper", "Cinnamon", "Garlic Powder"];
    const dairy = ["Milk", "Cheese", "Butter", "Yogurt"];

    let activeButtons = { 'fruits': [], 'vegetables': [], 'meatAndFish': [], 'seasoning': [], 'dairy': []};

    function updateButtons(category) {
    let items;
    switch (category) {
        case 'vegetables':
            items = vegetables;
            break;
        case 'meatAndFish':
            items = meatAndFish;
            break;
        case 'seasoning':
            items = seasoning;
            break;
        case 'dairy':
            items = dairy;
            break;
        default: // 'fruits' or any other case
            items = fruits;
    }
    buttons.forEach((button, index) => {
        button.textContent = items[index] || '';
        button.classList.toggle('active', activeButtons[category].includes(index));
    });
}

    dropdown.addEventListener('change', (event) => {
        event.preventDefault(); // Prevents any default action that the event might trigger
        updateButtons(event.target.value);
    });

    buttons.forEach((button, index) => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevents the button click from refreshing the page
            this.classList.toggle('active');
            const category = dropdown.value;
            const activeIndex = activeButtons[category].indexOf(index);
            if (activeIndex > -1) {
                activeButtons[category].splice(activeIndex, 1);
            } else {
                activeButtons[category].push(index);
            }
        });
    });

    // Initialize buttons with the first category
    updateButtons('fruits');
});
