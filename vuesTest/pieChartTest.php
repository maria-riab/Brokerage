<!doctype html>
<html>
    <head>
        <title>Mon portefeuille</title>
    </head>

<?Php
    // Connection
    $host_name = "localhost";
    $database = "brokerage";
    $username = "root";
    $password = "";

    $connection = mysqli_connect($host_name, $username, $password, $database);

    if (!$connection) {
        echo "Error: Unable to connect to MySQL.<br>";
        echo "<br>Debugging errno: " . mysqli_connect_errno();
        echo "<br>Debugging error: " . mysqli_connect_error();
        exit;
    }

    // Requête

    if ($stmt = $connection->query("select
                                    stocks.companyName,
                                    (sum(case WHEN orders.isbuy=1 then orders.quantity else 0  END)-
                                    sum(case WHEN orders.isbuy=0 then orders.quantity else 0  END)) AS stockqty
                                    from orders
                                    left join stocks on orders.stockid=stocks.stockID
                                    group by companyname")) {

        // Crée la table PHP
        $php_data_array = array();

        while ($row = $stmt->fetch_row()) {
            $php_data_array[] = $row; // Adding to array
        }
    } 
    else {
        echo $connection->error;
    }

    // Envoi des données en JSON
    echo "<script> var pieChartPortfolio = " . json_encode($php_data_array) . "</script>";
    ?>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script>
        google.charts.load('current', {
                'packages': ['corechart']
        });
        // Draw the pie chart when Charts is loaded.
        google.charts.setOnLoadCallback(draw_my_chart);
        // Callback that draws the pie chart
        function draw_my_chart() {
            // Create the data table .
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'companyName');
            data.addColumn('number', 'stockqty');
            for (i = 0; i < pieChartPortfolio.length; i++)
                    data.addRow([pieChartPortfolio[i][0], parseInt(pieChartPortfolio[i][1])]);
            // above row adds the JavaScript two dimensional array data into required chart format
            var options = {
                title: 'Mon portefeuille',
                is3D: true,
                width: 800,
                height: 700,
                // colors: ['#BDBDBD', '#9E9E9E', '#757575','#616161','#424242','#212121'], //palette gris bootstrap
                colors: ['#e0440e', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6'], //orange
                // colors: ['#0AB974', '#0BA263', '#0C8C53', '0D7542', '0E5E31'], //Vert 
                chartArea: {
                    backgroundColor: {
                        fill: '#F8F9FA',
                        //fillOpacity: 0.1
                    },
                },
                backgroundColor: {
                        fill: '#F8F9FA',
                        // fillOpacity: 0.8
                }

            };
            // Instantiate and draw the chart
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>

    <body>
        <div id="chart_div"></div>
    </body>
</html>