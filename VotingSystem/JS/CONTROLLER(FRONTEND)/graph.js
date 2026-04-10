function renderFinalChart(canvasId, labels, data, title) {
    let canvasElement = document.getElementById(canvasId);
    if (!canvasElement) return;

    let ctx = canvasElement.getContext('2d');
    if (chartInstances[canvasId]) { chartInstances[canvasId].destroy(); }

    // --- CHECK FOR ZERO DATA ---
    let total = data.reduce((a, b) => a + b, 0);
    let chartLabels = labels;
    let chartData = data;
    let colors = ['#2ecc71', '#e74c3c', '#3498db', '#f1c40f', '#9b59b6', '#e67e22'];

    if (total === 0) {
        chartLabels = ["No Votes Cast"];
        chartData = [1]; // This creates a full circle
        colors = ['#dddddd']; // Gray placeholder
    }

    chartInstances[canvasId] = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: chartLabels,
            datasets: [{
                data: chartData,
                backgroundColor: colors
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: { display: true, text: title, font: { size: 16 } },
                // Hide legend if there are no votes to keep it clean
                legend: { display: (total > 0), position: 'bottom' },
                tooltip: { enabled: (total > 0) } 
            }
        }
    });
}