<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<style>
* {
    box-sizing: border-box;
    padding: 0;
    margin: 0;
    font-family: 'Open Sans', sans-serif;
}
body {
    background: #f1f1f1;
    
}

.exit {
    color: lightgrey;
}

.exit:hover {
    color: #fff;
}

.btn:hover {
    background: #f6f6f6 !important;
    color: #060606 !important;
    text-decoration: none !important;

}

h1,
h2 {
    padding-top: 1.5%;
    text-align: center;
    padding-bottom: 1% !important;

}

th {
    background: linear-gradient(to bottom, #696969 5%, #3B3B3B 100%) !important;
    color: #fff !important;
}

.msg {
    margin-top: 2%;
    animation: showMsg 0s ease-in 5s forwards;
}


@keyframes showMsg {
    to {
        width: 0;
        height: 0;
        overflow: hidden;
    }
}

p {
    display: grid !important;
    place-self: center !important;
    text-align: center !important;
}

.msg-container {
    height: 100px;
}

.container {
    display: grid;
    grid-template-rows: auto;
    padding-left: 0 !important;
    padding-right: 0 !important;


}

.clearfix {
    overflow: auto;
}

.nav a,
.exit {
    color: white !important;
    font-size: 1.2rem !important;

}

.nav a:hover,
.exit:hover {
    background-color: #959995 !important;
}

input[type=password]:active,
input[type=password]:focus,
input[type=text]:active,
input[type=text]:focus {
    /* outline: none !important; */
}

input[type=submit]:hover,
input[type=submit]:active {
    box-shadow: 0 0 3px #7C7C7C !important;
}

input[type=password],
input[type=text] {
    display: inline-block !important;
    /* border: none !important; */
    background-color: #f3f3f3 !important;
    color: #060606 !important;
    font-size: 1.1rem !important;
    border-radius: 5px !important;
    padding: 7px !important;
}

.inner-login-wrapper {
    margin-top: 3% ;
    background: lightgrey;
    box-shadow: 0 12px 15px 0 rgba(0, 0, 0, .24), 0 17px 50px 0 rgba(0, 0, 0, .19) !important;
    padding: 3% !important;
    padding-bottom: 5% !important;
    font-weight: 700;
}
.table td, 
.table th {
    border: none !important;
}

.alert {
   text-align: center;
   font-size: 1.1rem;
   font-weight: 600;
}
</style>

<body>
    <nav class="navbar navbar-dark navbar-expand-sm bg-dark nav">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navbarCollapse" class="collapse navbar-collapse w-100">
            <ul class="navbar-nav ">
                <li class="nav-item">
                    <a href="<?=URL?>" class=" btn nav-link active">
                        Pagrindinis
                    </a>
                </li>
                <?php if (isLogged()) : ?>
                <li class="nav-item">
                    <a href="<?=URL?>create" class=" btn nav-link active">
                        Nauja sąskaita
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=URL?>list" class="btn nav-link active">
                        Vartotojai
                    </a>
                </li>
                <li class="nav-item">
                    <form action="<?= URL ?>logout" method="post">
                        <button type="submit" class="btn exit nav-link active"> Atsijungti </button>
                    </form>
                </li>
                <?php else : ?>
                <li class="nav-item">
                    <a href="<?=URL?>login" class=" btn nav-link active">
                        Prisijungti
                    </a>
                </li>
            </ul>
            <?php endif ?>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="container">
            <div class="container msg-container">
                <div class="w-100 msg mx-auto ">
                    <?php showMessages();?>
                </div>
            </div>