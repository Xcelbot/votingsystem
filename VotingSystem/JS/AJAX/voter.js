$(document).ready(function() {
    
    function loadBallot() {
        // 2. Grab the course code from the hidden input in HTML
        var courseCode = $('#course_filter').val();

        $.ajax({
            url: '../PHP/vretrieve.php',
            type: 'POST', // Changed to POST to send the course code
            data: { course: courseCode }, 
            success: function(data) {
                $('#ballotArea').html(data);
            }   
        });
    }

    loadBallot();

    $('#votingForm').on('submit', function(e) {
        e.preventDefault();
        
        if(confirm("Are you sure you want to submit your votes? This cannot be undone.")) {
            $.ajax({
                url: '../PHP/svotes.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if(response.trim() == "success") {
                        alert("Votes submitted successfully!");
                        window.location.href = "logout.html";
                    } else {
                        alert(response);
                    }
                }
            });
        }
    });
});