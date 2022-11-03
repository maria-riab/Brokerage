<?php ob_start(); ?>
<?php
    echo "<script> var pieChartPortfolio=" .  json_encode($php_data_array) . ";</script>";
?>
<body>
    <div id="chart_div"></div>
</body>

<?php $pieChart = ob_get_clean(); ?>

<?php ob_start(); ?>
<script type="text/javascript">
    google.charts.load('current', {
            'packages': ['corechart']
    });

    // Dessine le graphique à secteurs (pie chart) lorsque les graphiques sont chargés.
    google.charts.setOnLoadCallback(draw_my_chart);

    // Rappel qui dessine le graphique à secteurs (pie chart)
    function draw_my_chart() {
        // Création du tableau de données
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'companyName');
        data.addColumn('number', 'stockqty');
        for (i = 0; i < pieChartPortfolio.length; i++)
                data.addRow([pieChartPortfolio[i][0], parseInt(pieChartPortfolio[i][1])]);

        // Les deux lignes ci-haut ajoutent les données du tableau à deux dimensions JavaScript dans le format charte requis
        var options = {
                title: 'Mon portefeuille',
                is3D: true,
                width: 800,
                height: 700,
                colors: ['#0AB974', '#0BA263', '#0C8C53', '0D7542', '0E5E31'], //Vert 
                chartArea: {
                        backgroundColor: {
                                fill: '#F8F9FA'
                        },
                },
                backgroundColor: {
                        fill: '#F8F9FA'
                }
            };

            // Instancie et dessine le graphique
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
        }
</script>

<?php $script2 = ob_get_clean(); ?>
<?php require('portfolio.php'); ?>