<?php require __DIR__ . '/top.php' ?>

<div class="container ">
    <div class="row">
        <div class="col-5 mx-auto inner-login-wrapper">
            <form action="<?= URL ?>signin" method="post" class="m-4 login-form mx-auto">
                <div class="form-group">
                    <label>Darbuotojo vardas</label>
                    <input type="text" class="form-control" name="name">
                    <small class="form-text text-muted">Įveskite vardą</small>
                </div>
                <div class="form-group">
                    <label>Elektroninis paštas</label>
                    <input type="text" class="form-control" name="email">
                    <small class="form-text text-muted">Įveskite elektroninį paštą</small>
                </div>
                <div class="form-group">
                    <label>Slaptažodis</label>
                    <input type="password" class="form-control" name="password">
                    <small class="form-text text-muted">Įveskite prisijungimo slaptažodį.</small>
                </div>
                <div class="form-group">
                    <label>Pakartokite slaptažodį</label>
                    <input type="password" class="form-control" name="pass">
                    <small class="form-text text-muted">Pakartokite prisijungimo slaptažodį.</small>
                </div>
                <button type="submit" class="btn btn-dark">Sukurti</button>

            </form>
        </div>
    </div>
</div>


<?php require __DIR__ . '/end.php' ?>