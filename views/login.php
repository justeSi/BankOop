<?php require __DIR__ . '/top.php' ?>

<div class="container ">
        <div class="row">
            <div class="col-5 inner-login-wrapper mx-auto">
                <form action="<?= URL ?>login" method="post" class="m-4 login-form">
                    <div class="form-group">
                        <label>Elektroninis paštas</label>
                        <input type="text" class="form-control" name="email">
                        <small class="form-text text-muted">Įveskite elektroninį paštą</small>
                    </div>
                    <div class="form-group">
                        <label>Slaptažodis</label>
                        <input type="password" class="form-control" name="pass">
                        <small class="form-text text-muted">Įveskite prisijungimo slaptažodį.</small>
                    </div>
                    <button type="submit" class="btn btn-dark">Prisijungti</button>
                    
                    <a href="<?= URL ?>signin" class="btn btn-dark">Sukurti paskyrą</a>
                </form>
            </div>
        </div>
    </div>


<?php require __DIR__ . '/end.php' ?>