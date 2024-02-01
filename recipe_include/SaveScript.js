$(document).ready(function() {
    sendSaveRequest();

    $('button[id="favButton"]').on( "click", function() {
      click();
    });
  });

function click(){
    if (sessionUserID != null && sessionUserID != undefined) {
        let btn = document.getElementById("favButton");
        let res = btn.value;
        let val = JSON.parse(res);
        let savedStatus = val[0];
        let recipeID = val[1];

        $.ajax({
            url: 'recipe_include/change-saved-status.php',
            type: 'POST',
            data: { savedStatus: savedStatus, RecipeID: recipeID },
            success: function(response) {
                document.getElementById("favButton").setAttribute("value", response);
                sendSaveRequest()
            },
            error: function(error) {
            console.error('Error:', error);
            }
        });

    } else {
        var popup = 'Log in to save your favourite recipes on your account!';
        $('#loginRequirement').text(popup);
    }
}

function sendSaveRequest(){
    var savedStatus;
    try {
        let btn = document.getElementById("favButton");
        let res = btn.value;
        let val = JSON.parse(res);
        savedStatus = val[0];
    } catch (error) {
        console.error("Error parsing JSON:", error);
    }

    $.ajax({
        url: 'recipe_include/save-recipe.php',
        type: 'POST',
        data: { savedStatus: savedStatus },
        success: function(response) {
          $('.saveButton').html(response);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            console.log('XHR status:', status);
            console.log('XHR response:', xhr.responseText);
        }
    });
 }
