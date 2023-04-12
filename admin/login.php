<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LAFOY - auth</title>

    <?php $version = 1 ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="css/style.css?<?php echo $version ?>" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="js/functions.js"></script>
</head>
<body>
<div id="main-container" class="container-fluid">
    <div class="row">

        <div id="auth-form" class="panel panel-primary">
                <?php if (getError() != ''): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo getError() ?>
                    </div>
                <?php endif ?>
            <form enctype="multipart/form-data" role="form" class="panel-body" action="<?php echo getUrl("page=users&action=login") ?>" method="POST">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Логин</span>
                    </div>
                    <input type="text" id="login" name="login" class="form-control">
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Пароль</span>
                    </div>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary btn--radius btn-lg btn-block">Войти</button>
            </form>
        </div>
    </div>
</div>

<div class="container-fluid lafoy-footer">
    <div class="row">
        &nbsp;
    </div>
</div>
<style>
    body{
        background-color: #eee;
    }
    #auth-form {
        position: absolute;
        height: 200px;
        width: 400px;
        top: 50%;
        left: 50%;
        margin-top: -100px;
        margin-left: -200px;
        padding: 0;
    }
    #auth-form input {
        background-color: #eee;
    }
    #auth-form .input-group {margin-bottom: 10px;}
    #auth-form .panel-body {text-align: center;}
</style>
</body>
</html>