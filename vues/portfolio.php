<?php $titre = "Portfolio" ?>
<?php ob_start(); ?>

<div class="container col-12 mb-2 bg-transparent text-dark">
    <!-- Accueil l'utilisateur -->
    <div class="col text-center p-3 mb-2 bg-transparent text-dark">
        <h3>Bienvenue <?= $user['firstName'] ?>, </h3>
    </div>

    <!-- Section des statistiques -->
    <div class="container col px-3 m-2 bg-light text-dark">
        <h4>Voici quelques faits concernant votre portefeuille...</h4>
        <div class="row align-items-center p-3  ">
            <!-- Section du solde -->
            <div class="col-4 px-4 bg-white text-dark">
                <table class="table table-borderless">
                    <tr>
                        <th colspan="3">
                            <h4>Solde</h4>
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <h2>$<?= $user['balance'] ?> </h2>
                        </td>
                        <td>
                            <h3>USD</h3>
                        </td>
                        <td>
                            <button class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Cliquez pour accéder à votre compte">
                                <a href="index.php?action=account-home">
                                    <i class="fas fa-plus-circle fa-lg"></i>
                                </a>
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- Section des performances des actions de l'utilisateur -->
            <div class="col m-2 bg-white text-dark">
                <h4 class="text-center p-2">Performances</h4>
                <div>
                    <div id="bestIsWorse">
                        <h5 class="p-2 text-center">Vous n'aviez pas assez d'actions pour evaluer la performance de votre portfolio</h2>
                    </div>
                    <table id="performanceTable" class="table table-borderless">
                        <tr>
                            <th>
                                <h5>Meilleur</h5>
                            </th>
                        </tr>
                        <tr >
                            <td>
                                <h5 id="positiveArrow" class="text-success">
                                    <i class="fas fa-caret-up"></i>
                                </h5>
                            </td>
                            <td>
                                <h4 class="text-success" id="bestPerformingStockVariation"></h4>
                            </td>
                            <td>
                                <h6 id="bestPerformingStockPriceVar" class="text-success"></h6>
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td></td>
                            <td>
                                <h4 id="bestPerformingStockSymbol"></h4>
                            </td>
                            <td>
                                <h6 id="bestPerformingStockCompanyName"></h6>
                            </td>
                        </tr >
                        <tr>
                            <th>
                                <h5>Pire</h5>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <h5 id="negativeArrow" class="text-danger">
                                    <i class="fas fa-caret-down"></i>
                                </h5>
                            </td>
                            <td>
                                <h4 class="text-danger" id="worstPerformingStockVariation"></h4>
                            </td>
                            <td>
                                <h6 id="worstPerformingStockPriceVar" class="text-danger"></h6>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <h4 id="worstPerformingStockSymbol"></h4>
                            </td>
                            <td>
                                <h6 id="worstPerformingStockCompanyName"></h6>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="container col-11 p-3 mb-2 bg-transparent text-dark">
        <div class="row justify-content-between">
            <!-- Section du graphique à secteurs (pie chart) -->
            <div class="col-5 bg-light text-dark">
                <?= $pieChart ?>
            </div>

            <!-- Section du tableau des actions de l'utilisateur -->
            <div class="col-6 bg-light text-dark">
                <div class="container">
                    <h3 class='p-4 m-2 text-center font-weight-bold'> Votre portfolio!</h3>
                    <table id="portfolio" class="table">
                        <thead>
                            <tr>
                                <th class="col-xs-3">Symbole</th>
                                <th class="col-xs-3">Compagnie</th>
                                <th class="col-xs-3">Quantité</th>
                                <th class="col-xs-3">Prix d'achat</th>
                                <th class="col-xs-6">Prix actuel</th>
                                <th class="col-xs-6">Variation (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($array as $symbol => $value) {
                            ?>
                                <tr class="clickableRow">

                                    <td class="col-xs-3" data-symbol="<?= $symbol ?>"><?= $symbol ?></td>
                                    <td class="col-xs-3" data-company=""></td>
                                    <td class="col-xs-3"><?= $value['quantity'] ?></td>
                                    <td class="col-xs-3" data-averagePrice=''><?= $value['avgPrice'] ?></td>
                                    <td class="col-xs-6" data-price=""></td>
                                    <td class="col-xs-6" data-diff=""></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php ob_start(); ?>

<script language="JavaScript" type="text/javascript">
    $(document).ready(function() {
        var allSymb = document.querySelectorAll('[data-symbol]');
        var allCompanies = document.querySelectorAll('[data-company]');
        var allPrice = document.querySelectorAll('[data-price]');
        var allDiff = document.querySelectorAll('[data-diff]');
        var allAvgPrice = document.querySelectorAll('[data-averagePrice]');
        var performanceAllStocks = [];
        var differenceBetweenAvgAndRecPriceArr = [];
        var inxWorstPerformer = 0;
        var inxBestPerformer = 0;
        for (let i = 0; i < allSymb.length; i++) {
            fetch('https://cloud.iexapis.com/stable/stock/' + allSymb[i].innerHTML + '/quote?token=pk_b192dc66d82a4331bd8f0c93ccb4519a')
                .then((response) => {
                    if (!response.ok) {
                        return;
                    }
                    return response.json();
                }).then((data) => {
                    var avgPrice = allAvgPrice[i].innerHTML;
                    var diffpct = getPercentChange(parseFloat(avgPrice), data['latestPrice']).toFixed(2);
                    differenceBetweenAvgAndRecPriceArr.push((parseFloat(avgPrice) - data['latestPrice']).toFixed(2));

                    allCompanies[i].innerHTML = data['companyName'];
                    allPrice[i].innerHTML = "$ " + data['latestPrice'] + " " + data['currency'];
                    allAvgPrice[i].innerHTML = "$ " + avgPrice + " " + data['currency'];
                    allDiff[i].innerHTML = diffpct + " %";
                    performanceAllStocks[i] = parseFloat(diffpct);

                    findBestAndWorstPerformers();
                    if (inxBestPerformer != inxWorstPerformer){
                        $("#performanceTable").show();
                        $("#bestIsWorse").hide();
                        fillBestAndWorstPerformingSections()
                    } 
                    else {
                        $("#performanceTable").hide();
                        $("#bestIsWorse").show();
                    }
                })
                .catch((err) => {
                    console.error(err);
                })
        }

        function findBestAndWorstPerformers() {
            for (let i = 0; i < performanceAllStocks.length; i++) {
                if (performanceAllStocks[i] < performanceAllStocks[inxWorstPerformer]) {
                    inxWorstPerformer = i;
                } 
                else if (performanceAllStocks[i] > performanceAllStocks[inxBestPerformer]) {
                    inxBestPerformer = i;
                }
            }
        }

        function getPercentChange(avgPrice, latestPrice) {
            var absAvg = Math.abs(avgPrice);
            var diffBetweenLatestAverage = latestPrice - avgPrice;
            var result = (diffBetweenLatestAverage / absAvg) * 100;

            return result;
        }

        function fillBestAndWorstPerformingSections() {
            document.getElementById('worstPerformingStockSymbol').innerHTML = allSymb[inxWorstPerformer].innerHTML;
            document.getElementById('worstPerformingStockCompanyName').innerHTML = allCompanies[inxWorstPerformer].innerHTML;
            document.getElementById('worstPerformingStockVariation').innerHTML = allDiff[inxWorstPerformer].innerHTML;
            document.getElementById('worstPerformingStockPriceVar').innerHTML = "$" + differenceBetweenAvgAndRecPriceArr[inxWorstPerformer];

            document.getElementById('bestPerformingStockSymbol').innerHTML = allSymb[inxBestPerformer].innerHTML;
            document.getElementById('bestPerformingStockCompanyName').innerHTML = allCompanies[inxBestPerformer].innerHTML;
            document.getElementById('bestPerformingStockVariation').innerHTML = allDiff[inxBestPerformer].innerHTML;
            document.getElementById('bestPerformingStockPriceVar').innerHTML = "$" + differenceBetweenAvgAndRecPriceArr[inxBestPerformer];
        }
    });
</script>

<?php $script = ob_get_clean(); ?>
<?php require('template.php'); ?>