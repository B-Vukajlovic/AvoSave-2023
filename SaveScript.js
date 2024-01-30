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
        let SvSt = val[0];
        let RID = val[1];

        $.ajax({
            url: 'change-saved-status.php',
            type: 'POST',
            data: { savedStatus: SvSt, RecipeID: RID },
            success: function(response) {
                document.getElementById("favButton").setAttribute("value", response);
            },
            error: function(error) {
            console.error('Error:', error);
            }
        });

        sendSaveRequest()
    } else {
        var popup = 'Log in to save your favourite recipes on your account!';
        $('#loginRequirement').text(popup);
    }
}

function sendSaveRequest(){
    var SvSt;
    try {
    let btn = document.getElementById("favButton");
    let res = btn.value;
    let val = JSON.parse(res);
    SvSt = val[0];
    } catch (error) {
        console.error("Error parsing JSON:", error);
    }

    $.ajax({
        url: 'save-recipe.php',
        type: 'POST',
        data: { savedStatus: SvSt },
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
