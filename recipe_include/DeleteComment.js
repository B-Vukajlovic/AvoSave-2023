$(document).ready(function() {
    $(document).on('click', '.delete', function() {
        $(this).parent().addClass('hidden');
        var commentID = $(this).data('commentid');
        sendDeleteRequest(commentID)
    });
});

function sendDeleteRequest(commentID){
    $.ajax({
        url: 'recipe_include/delete-comment.php',
        type: 'POST',
        data: { commentID: commentID },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            console.log('XHR status:', status);
            console.log('XHR response:', xhr.responseText);
        }
    });
 }
