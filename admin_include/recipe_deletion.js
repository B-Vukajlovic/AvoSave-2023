$(document).ready(function() {
    $(".buttonDelete").click(function() {
        var recipeID = $(this).data('recipeID');
        deleteRecipe(recipeID);
    });
});

function deleteRecipe(recipeID) {
    $.ajax({
          url: 'admin_include/process_recipe_deletion.php',
          type: 'POST',
          data: { recipeID: recipeID},
          success: function(){
            hideColumn(recipeID);
          },
          error: function(error) {
            console.error('Error:', error);
          }
        });
  }

function hideColumn(recipeID) {
  $('button[data-recipeid="' + recipeID + '"]').closest('tr').hide();
}