<?php $titre = "Login"; ?>
<?php ob_start(); ?>

<div class=".container-fluid m-5">
    <!--Message d'accueil-->
    <section class=" text-center container border-bottom">
        <div class="row ">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">Bienvenue au système de gestion de courtage</h1>
                <p class="lead text-muted">
                    La finance est l'art de faire passer l'argent de mains en mains jusqu'à ce qu'il ait disparu.
                </p>
            </div>
        </div>
    </section>

    <!-- Grille à trois colonnes -->
    <div class="row m-5">
        <div class="col-md-5">
            <h2>Connexion</h2>
            <form action="index.php?action=login" method="post">
                <!-- Saisie de courriel (Email) -->
                <div class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control" />
                    <label class="form-label" for="email">Adresse Courriel</label>
                </div>

                <!-- Saisie de mot de passe (Password) -->
                <div class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" />
                    <label class="form-label" for="password">Mot de passe</label>
                </div>

                <!-- Bouton Submit -->
                <button type="submit" class="btn btn-dark btn-block">Connexion</button>
            </form>
        </div>

        <div class="col-md-2"></div>

        <div class="col-md-5">
            <h2>Inscription</h2>
            <form action="index.php?action=newUser" method="post">
                <!-- Layout de grille à deux colonnes avec des inputs textuels pour le prénom (First Name) 
                et nom de famille (Last Name)-->
                <div class="row mb-4">

                    <div class="col">
                        <div class="form-outline">
                            <input type="text" id="firstName" name="firstName" class="form-control" />
                            <label class="form-label" for="firstName">Prénom</label>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-outline">
                            <input type="text" id="lastName" name="lastName" class="form-control" />
                            <label class="form-label" for="lastName">Nom</label>
                        </div>
                    </div>
                </div>

                <!-- Saisie de courriel (Email) -->
                <div class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control" />
                    <label class="form-label" for="email">Adresse Courriel</label>
                </div>

                <!-- Saisie de mot de passe (Password) -->
                <div class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" />
                    <label class="form-label" for="password">Mot de passe</label>
                </div>

                <!-- Confirmation de mot de passe (Password) -->
                <div class="form-outline mb-4">
                    <input type="password" id="passwordConfirm" name="passwordConfirm" class="form-control" />
                    <label class="form-label" for="passwordConfirm">Confirmation du mot de passe</label>
                </div>

                <!-- Bouton Submit -->
                <button type="submit" class="btn btn-dark btn-block mb-4">Inscription</button>
            </form>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('template.php');?>