$(document).ready(function() {
  
    function checkStatus() {
        $.get('../CONTROLLER(BACKEND)/electionstatus.php', function(status) {
            console.log("Status check:", status);
            if (status.trim() === "Active") {
                $('#startPollBtn').text("STOP VOTING POLL").removeClass('btn-closed').addClass('btn-active');
            } else {
                $('#startPollBtn').text("START VOTING POLL").removeClass('btn-active').addClass('btn-closed');
            }
        });
    }

    checkStatus();

    $('#startPollBtn').on('click', function() {
        console.log("Button was clicked!"); // Check this in F12 Console
        let currentText = $(this).text();
        let newStatus = (currentText.includes("START")) ? "Active" : "Closed";

        $.post('../CONTROLLER(BACKEND)/etoggle.php', { status: newStatus }, function(response) {
            if (response.trim() === "success") {
                checkStatus(); 
            } else {
                alert("Error: " + response);
            }
        });
    });
});