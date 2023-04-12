<?php include "functions.php" ?>
<?php if (file_exists(__DIR__ . "/actions/" . getCurrentPage() . ".php")) include __DIR__ . "/actions/" . getCurrentPage() . ".php" ?>
<?php if(!isLogged()): ?>
<?php include "login.php" ?>
<?php else: ?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LAFOY - admin</title>

    <meta name="description" content="">
    <meta name="author" content="">

    <?php $version = 1 ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="css/style.css?<?php echo $version ?>" rel="stylesheet">
    <link rel="stylesheet" href="css/article/article-editor.min.css" />

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="js/article-editor.min.js"></script>
    <script src="js/plugins/underline/underline.min.js"></script>
    <script src="js/functions.js"></script>
  </head>
  <body>

    <div class="container-fluid lafoy-navi">
        <div class="row">
            <?php include "navi.php" ?>
        </div>
    </div>

    <div class="container-fluid lafoy-content">
        <div class="row">
            <div class="col-md-12">
                <?php if (getSuccess() != ''): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo getSuccess() ?>
                    </div>
                <?php endif ?>

                <?php if (getError() != ''): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo getError() ?>
                    </div>
                <?php endif ?>
            </div>

            <?php if (file_exists(__DIR__ . "/pages/" . getCurrentPage() . ".php")) include __DIR__ . "/pages/" . getCurrentPage() . ".php" ?>
        </div>
    </div>

    <div class="container-fluid lafoy-footer">
        <div class="row">
            &nbsp;
        </div>
    </div>

  </body>
</html>
<?php endif; ?>