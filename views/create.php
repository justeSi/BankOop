<?php require __DIR__ .'/top.php';?>
<h1><b>Naujo vartotojo pridėjimas į sistemą</b></h1>
<div class = "col col-md-6 mx-auto inner-login-wrapper">
    <form class="add-acc-form " action="<?= URL ?>create" method="POST">
        <div class="mb-3 acc-data">
            <input type="hidden" name="id" value="<?= showId() ?>" readonly>

        </div>
        <div class="mb-3 acc-data">
            <label for="fname" class="form-label">Vardas: </label>
            <input type="text" class="form-control" name="fname" value="">

        </div>
        <div class="mb-3 acc-data">
            <label for="lname" class="form-label">Pavardė: </label>
            <input type="text" class="form-control" name="lname" value="">

        </div>
        <div class="mb-3 acc-data">
            <label for="ak" class="form-label">Asmens kodas: </label>
            <input type="text" class="form-control" name="ak" value="">
        </div>
        <div class="mb-3 acc-data">
            <label for="acc" class="form-label">Sąskaitos numeris: </label>
            <input type="text" class="form-control" name="acc" value="<?= showIban() ?>" readonly>
        </div>
        <div>
            <button type="submit" class="btn btn-dark add-acc">Įvesti</button>
        </div>

    </form>
</div>
<?php require __DIR__ .'/end.php';?>