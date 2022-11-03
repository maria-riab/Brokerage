<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAW7gPAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEBAAAAAAAAEREQAAAAAAEREREAAAAAEREBERAAAAARAQEBEAAAAAABAQEQAAAAAAEBERAAAAAAERERAAAAAAERERAAAAAAEREBAAAAAAARAQEAAAAAABEBAQEQAAAAEREBERAAAAABERERAAAAAAARERAAAAAAAAEBAAAAD9fwAA+D8AAPAfAADhDwAA5U8AAP1PAAD9DwAA+B8AAPA/AADhfwAA5X8AAOVPAADhDwAA8B8AAPg/AAD9fwAA" rel="icon" type="image/x-icon" />
        <title><?= $titre ?></title>

        <!-- Style pour la charte de la page Portfolio -->
        <style>
            .chart-container {
                width: 50%;
                height: 50%;
                margin: auto;
            }
        </style>

        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
        <!-- MDB -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.css" rel="stylesheet" />
        <!-- MDB -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.js"></script>

        <!-- CSS DataTables links -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

        <!-- Javascript for User page tabs -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>

    <body>
        <!-- header-->
        <?php
        if (isset($_SESSION["userID"])) {
            include("userHeader.php");
        } 
        else {
            include("noUserHeader.php");
        }
        ?>
        <!-- alerts -->
        <?php
        if (isset($_SESSION['alert']) && $_SESSION['alert'] == "error") {
            include("alert-error.php");
        } 
        else if (isset($_SESSION['alert']) && $_SESSION['alert'] == "success") {
            include("alert-success.php");
        }
        ?>
        <!-- main body-->
        <main id="main-body" class="page-body">
            <?= $content ?>
        </main>

        <!-- Footer -->
        <footer class="bg-light text-center text-lg-start">
            <div class="text-center p-3" style="background-color: white;">
            @2022 Teamwork makes the dream works Inc.
            </div>
        </footer>

        <!-- Javascript DataTables Links -->
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <?php
        if (isset($script)) {
            ?>
            <?= $script ?>
            <?php
        }
        ?>
        <?php
        if (isset($script2)) {
            ?>
            <?= $script2 ?>
            <?php
        }
        ?>
    </body>
</html>