<?php $titre = "Marché" ?>
<?php ob_start(); ?>

<table class="table table-dark">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Symbol</th>
        <th scope="col">Company Name</th>
        <th scope="col">Latest Price</th>
        <th scope="col">Currency</th>
        <th scope="col">Previous Close</th>
        <th scope="col">Primary Exchange</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <th scope="row">1</th>
        <td><?=$data['symbol']?></td>
        <td><?=$data['companyName']?></td>
        <td><?=$data['latestPrice']?></td>
        <td><?=$data['currency']?></td>
        <td><?=$data['previousClose']?></td>
        <td><?=$data['primaryExchange']?></td>
        </tr>
    </tbody>
</table>

<?php $content = ob_get_clean(); ?>
<?php require('vues/template.php');?>