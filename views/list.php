<?php require __DIR__.'/top.php';?>

<div class="container inner-login-wrapper">
    <form action="<?= URL ?>list" method="post">


        <table class="table col col-lg-12 ">
            <div>
                <h1><b>Sąskaitos apžvalga / operacijos / trynimas</b></h1>
            </div>

            
            <?php foreach ($users as $key => $user) : ?>
            <tr>
                <th>Vartotojo id</th>
                <th>Vardas</th>
                <th>Pavardė</th>
                <th>Asmens kodas</th>
                <th>Sąskaita</th>
                <th>Likutis </th>

            </tr>
            <tr class="inner-login-wrapper ">
                <td><?= $user['id'] ?></td>
                <td><?= $user['name'] ?></td>
                <td><?= $user['surname'] ?></td>
                <td><?= $user['personalId'] ?></td>
                <td><?= $user['acc'] ?></td>
                <td><?= $user['balance'] ?> Eur.</td>

            <tr >
                <td>
                    <a class="add btn btn-dark " href="<?= URL ?>add/<?= $user['id'] ?>">Pridėti</a>
                </td>
                <td>
                    <a class="minus btn btn-dark" href="<?= URL ?>rem/<?= $user['id']?>">Nuskaiciuoti</a>
                </td>

    </form>


    <td>
        <form action="<?= URL ?>delete/<?= $user['id'] ?>" method="post">
            <button type="submit" class="delete btn btn-danger">Ištrinti</button>
    </form>
</td>

</tr>
</tr>
<?php endforeach ?>
</div>
</table>

<?php require __DIR__.'/end.php';?>