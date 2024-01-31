$(document).ready(function() {
  $(".buttonPromote").click(function() {
      var userID = $(this).data('userid');
      var changeRequest = 1;
      if (sessionUserID != userID) {
        changePermissionsUser(userID, changeRequest);
      }
  });

  $(".buttonDemote").click(function() {
      var userID = $(this).data('userid');
      var changeRequest = 0;
      console.log(sessionUserID);
      console.log(userID);
      if (sessionUserID != userID) {
        changePermissionsUser(userID, changeRequest);
      }
  });
});


function changePermissionsUser(userID, changeRequest ) {
  if (changeRequest == 1) {
    const user = "#user"+userID;
    $(user).text("Adminstrator");
  } else {
    const user = "#user"+userID;
    $(user).text("User");
  }
  $.ajax({
        url: 'admin_include/process_permissions.php',
        type: 'POST',
        data: { UserID: userID, AdminStatusRequest : changeRequest},
        error: function(error) {
          console.error('Error:', error);
        }
      });
}