<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Election Results History</title>
    <script src="../JS/jquery-4.0.0.min.js"></script>
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 40px; }
        .container { max-width: 900px; margin: auto; }
        .header { text-align: center; margin-bottom: 30px; }
        #live-data-container { min-height: 400px; }
        
        /* Animation for when data updates */
        .updated { animation: highlight 1s ease; }
        @keyframes highlight {
            0% { background-color: #e8f5e9; }
            100% { background-color: transparent; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Real-Time Election Standings</h1>
        <p>This page updates automatically as votes are cast.</p>
    </div>

    <div id="live-data-container">
        <p style="text-align:center;">Initializing live stream...</p>
    </div>
</div>

<script>
    function loadLiveResults() {
        $.ajax({
            url: '../CONTROLLER(BACKEND)/getstat.php',
            type: 'GET',
            success: function(response) {
                // Inject the HTML from your stat_template.php
                $('#live-data-container').html(response).addClass('updated');
                
                // Remove animation class after 1 second
                setTimeout(function() {
                    $('#live-data-container').removeClass('updated');
                }, 1000);
            },
            error: function() {
                console.log("Error fetching live results.");
            }
        });
    }

    // Load immediately on page open
    $(document).ready(function() {
        loadLiveResults();

        // Refresh every 3 seconds to show new votes cast
        setInterval(loadLiveResults, 3000); 
    });
</script>

</body>
</html>