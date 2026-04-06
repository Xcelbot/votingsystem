$(document).on('click', '.delete-voter-btn', function() {
    let voterId = $(this).data('id');

    if (confirm("Are you sure you want to delete this voter? All their votes will be removed.")) {
        $.ajax({
            url: '../CONTROLLER(BACKEND)/vdelete.php',
            type: 'POST',
            data: { user_id: voterId },
            success: function(response) {
                if (response === 'success') {
                    alert("Voter deleted successfully.");
                    // The dashboard will auto-refresh the numbers in 3 seconds!
                } else {
                    alert("Error: " + response);
                }
            }
        });
    }
});