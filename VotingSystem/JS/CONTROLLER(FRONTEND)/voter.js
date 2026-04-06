$(document).ready(function() {
    
    // 1. Load the ballot
    function loadBallot() {
        var courseCode = $('#course_filter').val();
        $.ajax({
            url: '../CONTROLLER(BACKEND)/vretrieve.php',
            type: 'POST',
            data: { course: courseCode },
            success: function(data) {
                if (data.trim() === "unavailable") {
                    $('#ballotArea').html("<div style='text-align:center; padding:50px; color:#fff;'><h2>Voting is currently unavailable</h2></div>");
                    $('#submitVoteBtn').hide();
                } else {
                    $('#ballotArea').html(data);
                    $('#submitVoteBtn').show();
                }
            }
        });
    }

    loadBallot();

    // 2. Handle the Vote Submission
    // We use $(document).on because the form is loaded dynamically
    $(document).on('submit', '#votingForm', function(e) {
        e.preventDefault();
        
        let totalPositions = $('.position-group').length;
        let selectedVotes = $('input[type="radio"]:checked').length;

        if (selectedVotes < totalPositions) {
            alert("Please select a candidate or 'Abstain' for every position before submitting.");
            return;
        }

        if(confirm("Are you sure you want to submit your votes? This cannot be undone.")) {
            $.ajax({
                url: '../CONTROLLER(BACKEND)/svotes.php', // Updated to match your file name
                type: 'POST',
                data: $(this).serialize(), 
                success: function(response) {
                    // Since PHP is redirecting to "log out.html", 
                    // the 'response' here will contain the HTML of the logout page.
                    // We simply tell the browser to go there now.
                    window.location.href = "../VIEW/logout.html";
                },
                error: function() {
                    alert("Connection error. Please try again.");
                }
            });
        }
    });
});