<?php $titre = "Empty portfolio" ?>

<?php ob_start(); ?>

<div class="container col-12 p-3 mb-2 bg-transparent text-dark">
    <!-- Accueil de l'utilisateur -->
    <div class="container col-10 p-3 mb-2 bg-transparent text-dark">
        <h5>Bienvenue <?= $user['firstName'] ?>, </h5>
    </div>

    <!-- Section des statistiques -->
    <div class="container col-6 p-3 mb-2 bg-light text-dark">
        <h4>Il semble que votre portefeuille soit vide...</h4>
        <div class="row align-items-center p-3  justify-content-between">
            <!-- Section du solde -->
            <div class="col-5 bg-white text-dark">
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
                            <h3>CAD</h3>
                        </td>
                        <!-- Trouver un moyen d'arriver directement sur l'onglet "solde" -->
                        <td>
                            <button class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Cliquez pour accéder à votre compte">
                            <a href="index.php?action=account-home">
                                <i class="fas fa-plus-circle fa-lg"></i>
                            </a></button>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-5 p-3 bg-white text-dark">
                <h6>Découvrez de nouvelles actions sur notre marché </h6>
                <a href="index.php?action=market"><button type="button" class="btn btn-dark btn-block p-1 mb-4">Suivre le marché</button></a>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>