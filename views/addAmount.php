<?php require __DIR__ .'/top.php';?>
<div class="col col-md-8 mx-auto inner-login-wrapper">
    <h1 class="mx-auto"><b>Sąskaitos papildymas</b></h1>
    <table class="table table-striped table-bordered">
        <tr>
            <th>
                <h2>Vartotojas: <?=$users['name']?> <?=$users['surname']?></h2>
            </th>
        </tr>
        <tr>
            <td>
                <h2>Likutis: <?=$users['balance']?> Eur.</h2>
                <form action="<?= URL ?>add/<?= $users['id'] ?>" method="post">
                    <h3>Suma:
                        <input type="text" name="add" class="plius-minus mt-2 col-md-3"> Eur.
                    </h3>
                    <button type="submit" class="btn btn-dark">Pridėti</button>
                </form>
            </td>
        </tr>
    </table>
</div>
<?php require __DIR__ .'/end.php';?>