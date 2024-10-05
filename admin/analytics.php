<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgriMart Analytics</title>
    <!-- <link href="asset\css\glass.css" rel="stylesheet"> -->
    <?php include 'css.php';?>

    <style>
        body {
            background: url('images/back.avif') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(10px);
            padding: 20px;
            margin: 20px;
        }
        .glass-effect h2 {
            color: #fff;
        }
    </style>
</head>
<body>
<div class="page-wrapper">
    <div class="content">
<?php include 'sidebar.php'; ?>

    <div class="container justify-content-left">
        <div class="glass-effect">
            <h2>Analytics Dashboard</h2>
            <!-- <p>Here you can see the sales and user statistics of AgriMart.</p> -->
            <div class="row">
                <div class="col-md-6">
                    <h4>Sales Data</h4>
                    <canvas id="salesChart"></canvas>
                </div>
                
            </div>
        </div>
    </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                datasets: [{
                    label: '# of Sales',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <?php include 'js.php';?>
</body>
</html>