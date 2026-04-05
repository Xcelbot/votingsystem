$(document).ready(function() {
    
    // Function to load the voter list
    function loadVoters() {
        $.ajax({
            url: '../PHP/voterlist.php', // You'll need this simple fetch script
            type: 'GET',
            success: function(data) {
                $('#voterListData').html(data);
            }
        });
    }

    // Initial load
    loadVoters();

    // DELETE ACTION
   $('#voterListData').on('click', '.delete-btn', function() {
    let voterId = $(this).data('id');
    let voterName = $(this).data('name');

    if (confirm("Are you sure you want to delete " + voterName + "?")) {
        $.ajax({
            url: '../PHP/vdelete.php', // Ensure this path is correct
            type: 'POST',
            data: { user_id: voterId },
            success: function(response) {
                if (response.trim() === 'success') {
                    alert("Voter deleted successfully.");
                    loadVoters(); // Reload the table
                    loadLiveCharts(); 
                } else {
                    alert("Error: " + response);
                }
            },
            error: function() {
                alert("Could not connect to delete_voter.php");
                 
            }
        });
    }
});

});