$(document).ready(function () {

    const pollBtn = $('#startPollBtn');

    function checkStatus() {
        $.get('../../CONTROLLER(BACKEND)/electionstatus.php', function (status) {
            console.log("Current Poll Status:", status);
            const cleanStatus = status.trim();
            
            if (cleanStatus === "Active") {
                pollBtn.text("STOP VOTING POLL").removeClass('btn-closed').addClass('btn-active');
            } else {
                pollBtn.text("START VOTING POLL").removeClass('btn-active').addClass('btn-closed');
            }
            // Restore button after status check
            pollBtn.prop('disabled', false).css('opacity', '1');
        });
    }

    // Initial check on page load
    checkStatus();

    // Toggle click handler
    pollBtn.on('click', function () {
        // 1. Loading state
        $(this).prop('disabled', true).text("PROCESSING...").css('opacity', '0.7');

        // 2. Perform toggle
        $.post('../../CONTROLLER(BACKEND)/etoggle.php', {}, function (response) {
            const cleanRes = response.trim();
            
            if (cleanRes === "Active") {
                alert("The election is now LIVE! Voters can now cast their ballots.");
            } else if (cleanRes === "Closed") {
                alert("The election is now CLOSED. No more votes can be cast.");
            } else if (cleanRes !== "error") {
                // Unexpected success response
            } else {
                alert("Error toggling election: " + response);
            }

            // 3. Final Sync
            checkStatus();
        });
    });

});