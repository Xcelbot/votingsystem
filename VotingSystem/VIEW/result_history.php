<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting History - MULAT</title>
    <!-- Standard Dashboard Styles -->
    <link rel="stylesheet" href="../CSS/dasboardAUDITOR.css">
    <style>
        .history-container { width: 92%; max-width: 1100px; margin: auto; padding: 20px 0 80px; }
        .log-panel { 
            background: rgba(255,255,255,0.05); border: 1px solid #3a3a3a; 
            border-radius: 8px; backdrop-filter: blur(10px); overflow: hidden;
        }
    </style>
</head>
<body>

    <div class="header-top">
        <a href="../CONTROLLER(BACKEND)/logout.php" class="logout">LOG OUT</a>
    </div>

    <nav class="header-nav">
        <a href="HTML/dasboardOFFICER.html">CANDIDATE MANAGEMENT</a>
        <a href="HTML/dasboardAUDITOR.html">VOTE UPDATE</a>
        <a href="result_history.php" class="active">VOTING HISTORY</a>
        <a href="HTML/dasboardADMIN.html">DASHBOARD</a>
        <a href="HTML/voterlist.html">INFORMATION MANAGEMENT</a>
        <a href="HTML/registration.html">REGISTRATION</a>
    </nav>

    <div class="page-header">
        <h1>VOTING HISTORY LOGS</h1>
        <p>A real-time record of all ballots cast in the system</p>
    </div>

    <div class="history-container">
        
        <!-- Turnout Progress (Top Bar) -->
        <div id="statBarContainer" class="stat-bar">    
            <!-- Stats like Total Voters, Current Votes will be injected here -->
        </div>

        <!-- Voter logs Table -->
        <div class="log-panel">
            <table>
                <thead>
                    <tr>
                        <th>STUDENT NO.</th>
                        <th>FULL NAME</th>
                        <th>EMAIL ADDRESS</th>
                        <th>TIME</th>
                        <th>DATE</th>
                    </tr>
                </thead>
                <tbody id="historyData">
                    <tr class="empty-row"><td colspan="5">Loading voting logs...</td></tr>
                </tbody>
            </table>
        </div>

    </div>

    <script src="../JS/jquery-4.0.0.min.js"></script>
    <script>
        $(document).ready(function() {
            
            function refreshHistory() {
                // 1. Fetch Turnout Stats
                $.ajax({
                    url: '../CONTROLLER(BACKEND)/getstat.php',
                    type: 'GET',
                    success: function(data) {
                        $('#statBarContainer').html(data);
                    }
                });

                // 2. Fetch Voter Logs
                $.ajax({
                    url: '../CONTROLLER(BACKEND)/gethistory.php',
                    type: 'GET',
                    success: function(data) {
                        $('#historyData').html(data);
                    }
                });
            }

            // Run once on load and refresh every 3 seconds
            refreshHistory();
            setInterval(refreshHistory, 3000);
        });
    </script>
</body>
</html>