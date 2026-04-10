$(document).ready(function() {
    
    // Global object to store chart instances
    const chartInstances = {};

    function refreshDashboard() {
        // 1. Fetch Stats (Total Voters, Current Votes, etc.)
        $.ajax({
            url: '../../CONTROLLER(BACKEND)/getstat.php', 
            type: 'GET',
            success: function(data) {
                $('#statBarContainer').html(data);
            }
        });

        // 2. Fetch Chart Data (JSON)
        $.ajax({
            url: '../../CONTROLLER(BACKEND)/getvote_json.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                updateCharts(data);
            }
        });
    }

    function updateCharts(data) {
        Object.keys(data).forEach(position => {
            const chartData = data[position];
            const canvasId = 'chart-' + position.replace(/\s+/g, '-').toLowerCase();

            // Create canvas if it doesn't exist
            if (!chartInstances[position]) {
                const wrapper = $('<div class="chart-panel"></div>');
                wrapper.append('<div class="chart-header">' + position + '</div>');
                wrapper.append('<div class="chart-body"><canvas id="' + canvasId + '"></canvas></div>');
                $('#chartsContainer').append(wrapper);

                const ctx = document.getElementById(canvasId).getContext('2d');
                chartInstances[position] = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'Votes',
                            data: chartData.votes,
                            backgroundColor: 'rgba(255, 255, 255, 0.2)',
                            borderColor: 'rgba(255, 255, 255, 0.8)',
                            borderWidth: 1,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        indexAxis: 'y', // Horizontal bars
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: { color: 'rgba(255, 255, 255, 0.05)' },
                                ticks: { color: '#aaa', stepSize: 1 }
                            },
                            y: {
                                grid: { display: false },
                                ticks: { color: '#fff', font: { size: 11, weight: 'bold' } }
                            }
                        }
                    }
                });
            } else {
                // Update existing chart
                const chart = chartInstances[position];
                chart.data.labels = chartData.labels;
                chart.data.datasets[0].data = chartData.votes;
                chart.update('none'); // Update without animation for a smoother real-time feel
            }
        });
    }

    // Run once on load and refresh every 3 seconds
    refreshDashboard();
    setInterval(refreshDashboard, 3000);
  
});