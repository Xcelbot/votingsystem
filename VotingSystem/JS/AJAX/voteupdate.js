$(document).ready(function() {
    
    function refreshDashboard() {
        // 1. Fetch Vote Counts (HTML table)
        $.ajax({
            url: '../PHP/getvote.php',
            type: 'GET',
            success: function(data) {
                $('#voteCountArea').html(data);
            }
        });

        // 2. ALTERNATIVE: Fetch Stats as HTML (No JSON)
        $.ajax({
            url: '../PHP/getstat.php', 
            type: 'GET',
            success: function(data) {
                // This ID should match the <div> that wraps your top stat-bar
                $('#statBarContainer').html(data);
            }
        });

        // 3. Fetch History (HTML rows)
        $.ajax({
            url: '../PHP/gethistory.php',
            type: 'GET',
            success: function(data) {
                $('#historyData').html(data);
            }
        });
    }

    // Run once on load and refresh every 3 seconds
    refreshDashboard();
  
});