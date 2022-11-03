<?php $titre = "Marché" ?>
<?php ob_start(); ?>

<div class="alert alert-warning alert-dismissible fade show" style="display:none" role="alert" id="errorsBro">
    <strong>Désolé!</strong> L'action que vous avez choisi n'existe pas ou vous l'avez mal écrit! Veuillez réessayer.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="container col-8 p-3 mb-2 bg-light text-dark">
    <div class="row justify-content-around">
        <div class=" col-l-3 p-3 mb-2 bg-light text-dark rounded">
            <form id="quoteForm" action="index.php?action=quote" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Rechercher une action par symbol" name="symbolInput" id="symbolInput" aria-describedby="button-addon2">

                    <!-- Ceci est l'information cachée que nous voulons utiliser pour la table -->
                    <input type="hidden" name="symbol" id="symbol">
                    <input type="hidden" name="companyName" id="companyName">
                    <input type="hidden" name="latestPrice" id="latestPrice">
                    <input type="hidden" name="currency" id="currency">
                    <input type="hidden" name="previousClose" id="previousClose">
                    <input type="hidden" name="primaryExchange" id="primaryExchange">

                    <button class="btn btn-outline-secondary" type="button" id="btnQuote" id="button-addon2">
                        <i class="bi bi-search"></i> 
                        Recherche
                    </button>
                </div>
            </form>

            <?php
            if (isset($data)) {
            ?>
                <div id="tableResult">
                    <h3>Liste des actions:</h3>
                    <div class="container">
                        <table id="example" class="table table-hover display">
                            <thead>
                                <tr>
                                    <th class="col-xs-3">Symbole</th>
                                    <th class="col-xs-3">Nom</th>
                                    <th class="col-xs-6">Prix</th>
                                    <th class="col-xs-6">Devise</th>
                                    <th class="col-xs-6">Cours de Clôture</th>
                                    <th class="col-xs-6">Échange principal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="clickableRow">
                                    <td><?= $data['symbol'] ?></td>
                                    <td><?= $data['companyName'] ?></td>
                                    <td><?= $data['latestPrice'] ?></td>
                                    <td><?= $data['currency'] ?></td>
                                    <td><?= $data['previousClose'] ?></td>
                                    <td><?= $data['primaryExchange'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-6 col-l-3 p-3 mb-2 bg-light text-dark rounded">
                <h3>Votre Choix:</h3>
                <form action="index.php?action=sendOrder" method="post">
                    <table class="table">
                        <tr style="height:30px">
                            <th>Symbole</th>
                            <th style="width:150px">Nom</th>
                            <th>Prix</th>
                            <th>Devise</th>
                        </tr>
                        <tr style="height:30px">
                            <td id="symbolTransaction" name="symbolTransaction"><input type="text" hidden id="symbolTr" name="symbolTr" required></td>
                            <td id="companyNameTransaction" name="companyNameTransaction"></td>
                            <td id="latestPriceTransaction" name="latestPriceTransaction"></td>
                            <td id="currencyTransaction" name="currencyTransaction"></td>
                        </tr>
                        <tr style="height:40px">
                            <td>
                                <label for="stockQTY">Quantité:</label>
                                <input type="number" id="stockQTY" name="quantity" min="1" required>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="buy" name="transactionType" value="1" checked>Acheter
                                    <label class="form-check-label" for="buy"></label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="sell" name="transactionType" value="0">Vendre
                                    <label class="form-check-label" for="sell"></label>
                                </div>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-dark btn-block mb-4">
                                    Envoyer
                                </button>
                            </td>
                        </tr>
                    </table>
                </form>
                <div class="container justify-content-end">
                <h5>Votre balance: $<?=$balance?> </h3>
            <?php
            } else {
            ?>
                <img class="rounded mx-auto d-block border border-secondary"  src="images\pexels-photo-1036623.webp" alt="woman" width="900rem" heigh="auto">
            <?php    
            }
            ?>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php ob_start(); ?>

<script language="JavaScript" type="text/javascript">
    $("#btnQuote").click(function(event) {
        event.preventDefault();
        fetch('https://cloud.iexapis.com/stable/stock/' + $('#symbolInput').val() + '/quote?token=pk_b192dc66d82a4331bd8f0c93ccb4519a')
            .then((response) => {
                if (!response.ok) {
                    $('#errorsBro').css('display', 'block');
                    return;
                }
                $('#errorsBro').css('display', 'none');
                return response.json();
            }).then((data) => {
                $('#symbol').val(data['symbol']);
                $('#companyName').val(data['companyName']);
                $('#latestPrice').val(data['latestPrice']);
                $('#currency').val(data['currency']);
                $('#previousClose').val(data['previousClose']);
                $('#primaryExchange').val(data['primaryExchange']);
                $("#quoteForm").submit();
            }).catch((err) => {
                console.error(err);
            })
    });

    $('#example').DataTable({
        language: {
            processing: "Traitement en cours...",
            search: "Rechercher&nbsp;:",
            lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
            info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            infoPostFix: "",
            loadingRecords: "Chargement en cours...",
            zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
            emptyTable: "Aucune donnée disponible dans le tableau",
            paginate: {
                first: "Premier",
                previous: "Pr&eacute;c&eacute;dent",
                next: "Suivant",
                last: "Dernier"
            },
            aria: {
                sortAscending: ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre décroissant"
            }
        }
    });

    var table = $('#example').DataTable();

    $('#example tbody').on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } 
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            var stockData = table.row(this).data();
            $("#symbolTransaction").html("<p><input type=\"hidden\" id=\"symbolTr\" name=\"symbolTr\" value=" + stockData[0] + " required>" + stockData[0] + "</p>");
            $("#companyNameTransaction").html("<p>" + stockData[1] + "</p>");
            $("#latestPriceTransaction").html("<p><input type=\"hidden\" id=\"latestPriceTr\" name=\"latestPriceTr\" value=" + stockData[2] + " required>" + stockData[2] + "</p>");
            $("#currencyTransaction").html("<p>" + stockData[3] + "</p>");
        }
    });

</script>

<?php $script = ob_get_clean(); ?>
<?php require('vues/template.php'); ?>