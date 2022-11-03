<?php $titre = "Account" ?>

<?php ob_start(); ?>

<div class="row justify-content-around">
    <form action="index.php?action=removeUser" method="post">
        <!-- Modal pour confirmer la suppression de compte -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Suppression de compte</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Êtes-vous certain de vouloir supprimer votre compte? 
                            <br />
                            Cette action est permanente.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" name="deleteAccount" class="btn btn-danger">Supprimer</button>
                    </div>
                </div>  
            </div>
        </div>
    </form>
    <div class="col-6 col-l-3 p-3 mb-2 bg-light text-dark rounded">

        <h2>Votre Compte:</h2>

        <!-- Onglets -->
        <div class="container p-3 mb-2 bg-light text-dark">
            <ul class="nav nav-tabs" id="userTabGroup" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="homeTab" data-toggle="tab" href="#userInformationDisplay" role="tab" aria-controls="home" aria-selected="true">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="updateTab" data-toggle="tab" href="#updateUserInfo" role="tab" aria-controls="modif" aria-selected="false">Modifications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="balanceManagementTab" data-toggle="tab" href="#balanceManagement" role="tab" aria-controls="balance" aria-selected="false">Solde</a>
                </li>
            </ul>

            <!-- Affichage des informations utilisateur -->
            <div class="tab-content" id="homeTabContent">
                <div class="tab-pane fade show active" id="userInformationDisplay" role="tabpanel" aria-labelledby="homeTab">

                    <h5 style="margin: 10px 0px 10px 0px">
                        Bienvenue <?=$user['firstName']?>
                    </h5>

                    <table class="table">
                        <tbody>
                            <p>
                                Vous pouvez consulter les informations de votre compte ici
                            </p>

                            <!-- Il manque la méthode dans le controleur qui nous permet d'aller chercher les informations dans la base de données -->
                            <tr class="fs-6">
                                <td>Nom: </td>
                                <td><?=$user['lastName']?></td>
                            </tr>
                            <tr class="fs-6">
                                <td>Prénom: </td>
                                <td><?=$user['firstName']?></td>
                            </tr>
                            <tr class="fs-6">
                                <td>Courriel: </td>
                                <td><?=$user['email']?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Modification des informations utilisateur -->
                <div class="tab-pane fade" id="updateUserInfo" role="tabpanel" aria-labelledby="updateTab">
                    <h4 style="margin: 10px 0px 10px 0px">
                        <?=$user['firstName']?>,
                    </h4>

                    <form action="index.php?action=updateUserGeneral" method="post">
                        <table class="table">
                            <tbody>
                                <p class="fs-6">
                                    Entrez vos informations à modifier et sauvegarder lorsque terminé.
                                </p>
                                <tr class="fs-6">
                                    <!-- Mise à jour prénom (First Name) -->
                                    <td ><label class="form-label" for="updateFirstName">Nouveau prénom :</label></td>

                                    <td> <input type="text" id="updateFirstName" class="form-control" name="firstName" value="<?=$user['firstName']?>" required></td>
                                </tr>
                                <tr class="fs-6">
                                    <!-- Mise à jour nom de famille (Last Name) -->
                                    <td><label class="form-label" for="updateLastName">Nouveau nom :</label></td>

                                    <td><input type="text" id="updateLastName" class="form-control" name="lastName" value="<?=$user['lastName']?>" required /></td>
                                </tr>
                                <tr class="fs-6">
                                    <!-- Mise à jour courriel (Email) -->
                                    <td><label class="form-label" for="updateEmail">Nouveau courriel :</label></td>
                                    <td><input type="text" id="updateEmail" class="form-control" name="email" value="<?=$user['email']?>"required /></td>
                                </tr>
                                </tbody>

                        </table>
                        <!-- Bouton Submit -->
                        <button type="submit" class="btn btn-dark btn-block mb-4">Sauvegarder vos informations personnelles</button>
                    </form>
                    <form action="index.php?action=updatePassword" method="post">
                        <table class="table">
                            <tbody>
                                <p class="fs-6">
                                    Modifiez votre mot de passe ici.
                                </p>
                                <tr class="fs-6">
                                    <!-- Mise à jour mot de passe (Password) -->
                                    <td><label class="form-label" for="updatePwd">Nouveau mot de passe :</label></td>
                                    <td><input type="password" id="updatePwd" class="form-control" name="mdp1" placeholder="le mot de passe" required/></td>
                                </tr>
                                <tr class="fs-6">
                                    <!-- Confirmation de la mise à jour du mot de passe (Password) -->
                                    <td><label class="form-label" for="confirmUpdatePwd">Confirmer nouveau mot de passe :</label></td>
                                    <td><input type="password" id="confirmUpdatePwd" class="form-control" name="mdpConfirmation" placeholder="la confirmation du mot de passe " required/></td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Bouton Submit -->
                        <button type="submit" class="btn btn-outline-dark btn-block mb-4">Changer le nouveau mot de passe</button>
                    </form>
                    <!-- Bouton Supprimer -->
                    <button type="button" class="btn btn-danger btn-block mb-4" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Supprimer le compte</button>
                </div>

                <div class="tab-pane fade" id="balanceManagement" role="tabpanel" aria-labelledby="balanceManagementTab">
                    <h5 style="margin: 10px 0px 10px 0px">
                        Informations sur votre solde
                    </h5>
                    <form action="index.php?action=updateBalance" method="POST">
                        <table class="table">
                            <tbody>
                                <p>
                                    Vous pouvez ajouter ou retirer de l'argent ici
                                </p>
                                <tr>
                                    <td>
                                        <h4>Solde: $<?=$user['balance']?></h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Entrer un montant (CAD): </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group mb-3 w-25">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" class="form-control" min=0 step="0.01" name ="balance"aria-label="Montant (au dollar près)" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <button value="add" name="buttonVal" type="submit" class="btn btn-dark btn-block mb-4" style="margin:10px 10px 10px 0px">Ajouter</button>
                                </div>
                                <div class="col">
                                    <button value="remove" name="buttonVal"  type="submit"class="btn btn-dark btn-block mb-4" style="margin: 10px 10px 10px 0px">Retirer</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php $content = ob_get_clean(); ?>
        <?php require('template.php'); ?>