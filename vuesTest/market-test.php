<?php $titre = "Marché" ?>
<?php ob_start(); ?>

<div class="container col-8 p-3 mb-2 bg-light text-dark">
    <div class="row justify-content-around">
        <div class=" col-l-3 p-3 mb-2 bg-light text-dark rounded">       
            <h3>Liste des actions:</h3>
            <div class="container">
                <table id="example" class="table table-hover display">
                    <thead>
                        <tr>
                            <th class="col-xs-3">ID</th>
                            <th class="col-xs-3">Symbole</th>
                            <th class="col-xs-3">Nom</th>
                            <th class="col-xs-6">Prix</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($data = $stocklist->fetch()) {
                        ?>

                            <tr class="clickableRow">
                                <td class="col-xs-3"><?= $data['stockID'] ?></td>
                                <td class="col-xs-3"><?= $data['ticker'] ?></td>
                                <td class="col-xs-3"><?= $data['companyName'] ?></td>
                                <td class="col-xs-6">$<?= $data['price'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="col-6 col-l-3 p-3 mb-2 bg-light text-dark rounded">
                <h3>Votre Choix:</h3>
                <form action="index.php?action=sendOrder" method="post">
                    <table class="table">
                        <tr style="height:30px">
                        <th>ID</th>
                            <th style="width:150px">Symbole</th>
                            <th>Nom</th>
                            <th>Prix</th>
                        </tr>
                        <tr style="height:30px">
                            <td id="stockID"></td> 
                            <td id="ticker"></td>
                            <td id="companyName"></td>
                            <td id="price"></td>
                        </tr>
                        <tr style="height:40px">
                            <td>
                                <label for="stockQTY">Quantité:</label>
                                <input type="number" id="quantity" name="quantity" min="1" required>
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
                                <button type="submit" class="btn btn-dark btn-block mb-4">Envoyer</button>
                            </td>
                        </tr>
                    </table>
                </form>
                <div class="container justify-content-end">
                <h5>Votre balance: $<?=$balance?> </h3>
            </div>  
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php ob_start(); ?>

<script>
    $(document).ready(function() {
        $('#example').DataTable( {
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
                var data = table.row(this).data();
                $("#stockID").html("</label><input type=\"hidden\" id=\"stockNames\" name=\"stockNames\" value=" + data[0] + " required>" + data[0]);
                $("#ticker").html("<p>" + data[1] + "</p>");
                $("#companyName").html("<p>" + data[2] + "</p>");
                $("#price").html("<p>" + data[3] + "</p>");
            }
        });
    });
</script>

<?php $script = ob_get_clean(); ?>
<?php require('template.php'); ?>