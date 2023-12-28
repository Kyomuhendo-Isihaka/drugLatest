<?php
// Assume you have a database connection established
$connection = mysqli_connect("localhost", "root", "", "drug");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Replace 'your_salesman_id' with the actual salesman_id
$salesmanId = '16';

// Fetch sales information from the database for the specific salesman
$getSales = "SELECT s.id, s.quantity_sold, s.drug_id, d.drug_name FROM sale s
             JOIN drugs d ON s.drug_id = d.id
             WHERE s.salesman_id = '{$salesmanId}'";
$result = mysqli_query($connection, $getSales);

$salesData = array();

while ($sale = mysqli_fetch_assoc($result)) {
    $salesData[] = $sale;
}

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Per Sale by Salesman</title>
    <!-- Include Chart.js from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container mt-5">
        <div>
            <h2>Sales Per Sale by Salesman</h2>
            <canvas id="salesChart" width="100%" height="50px"></canvas>
        </div>
    </div>

    <!-- Script to pass PHP data to JavaScript and create the chart -->
    <script>
        // PHP data
        var salesData = <?php echo json_encode($salesData); ?>;

        // Process data for the chart
        var chartData = {
            labels: [],
            barData: [],
            colors: []
        };

        // Extract labels and data
        salesData.forEach(function (sale) {
            // Check if drug_name is defined
            var label = 'Sale ' + sale.sale_id;
            if (sale.drug_name !== null) {
                label += ' - ' + sale.drug_name;
            }
            chartData.labels.push(label);
            chartData.barData.push(sale.quantity_sold);
            // Generate a random color
            chartData.colors.push(getRandomColor());
        });

        // Get the canvas element
        var salesCtx = document.getElementById('salesChart').getContext('2d');

        // Chart configuration
        var chartOptions = {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
        };

        // Create the chart
        var salesChart = new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Quantity Sold',
                    data: chartData.barData,
                    backgroundColor: chartData.colors, // Use the generated colors
                    borderWidth: 1,
                }],
            },
            options: chartOptions
        });

        // Function to generate a random color
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    </script>
</body>

</html>
