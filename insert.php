<?php
    session_start();
    require 'connection.php';

    if (isset($_POST['insert']) == "Insert") {
        $brandName = $_POST['brand_name'];
        $model = $_POST['model'];
        $quantity = $_POST['quantity'];
        $tmp = rand(1, 100);
        $avatar = $_FILES['photo']['name'];
        $photo ='images/'.$tmp.$avatar;

        if (empty($brandName) || empty($model) || empty($quantity) || empty($avatar)) {
            if (empty($brandName)) {
                $_SESSION['error']['brand_name'] = "<font color='red'>Brand Name Require</font>";
            }

            if (empty($model)) {
                $_SESSION['error']['model'] = "<font color='red'>Model Require</font>";
            }

            if (empty($quantity)) {
                $_SESSION['error']['quantity'] = "<font color='red'>Quantity Require</font>";
            }

            if (empty($avatar)) {
                $_SESSION['error']['avatar'] = "<font color='red'>Avatar Require</font>";
            }
        } else {
            move_uploaded_file($_FILES['photo']['tmp_name'],$photo);

            $inserted = mysqli_query($conn, "insert into products(avatar,brand_name,model,qty) values('$tmp$avatar', '$brandName', '$model', '$quantity')");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD in PHP</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/alertify.min.css" />
    <link rel="stylesheet" href="css/themes/default.min.css" />
</head>
<body>
    <div class="container">
        <form class="form" action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3" name="brand_name">
                    Brand Name:
                </label>

                <div class="col-md-4 col-sm-4">
                    <input type="text" name="brand_name" class="form-control">
                </div>

                <?php
                    echo isset($_SESSION['error']['brand_name']) ? $_SESSION['error']['brand_name'] : "";
                    unset($_SESSION['error']['brand_name']);
                ?>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3" name="model">
                    Model:
                </label>

                <div class="col-md-4 col-sm-4">
                    <input type="text" name="model" class="form-control">
                </div>

                <?php
                    echo isset($_SESSION['error']['model']) ? $_SESSION['error']['model'] : "";
                    unset($_SESSION['error']['model']);
                ?>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3" name="quantity">
                    Quantity:
                </label>

                <div class="col-md-4 col-sm-4">
                    <input type="text" name="quantity" class="form-control">
                </div>

                <?php
                    echo isset($_SESSION['error']['quantity']) ? $_SESSION['error']['quantity'] : "";
                    unset($_SESSION['error']['quantity']);
                ?>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3" name="avatar">
                    Avatar:
                </label>

                <div class="col-md-4 col-sm-4">
                    <input type="file" name="photo" accept="image/*" class="form-control">
                </div>

                <?php
                    echo isset($_SESSION['error']['avatar']) ? $_SESSION['error']['avatar'] : "";
                    unset($_SESSION['error']['avatar']);
                ?>
            </div>

            <div class="col-md-8 row">
                <div class="col-md-3">
                    <input type="submit" name="insert" value="Insert" class="form-control btn btn-primary">
                </div>

                <div class="col-md-3">
                    <a href="index.php" class="btn btn-secondary">
                        View Records
                    </a>
                </div>
            </div>
        </form>
    </div>

    <script src="js/alertify.min.js"></script>

    <?php
        if (isset($inserted) == true) {
            echo"<script type='text/javascript'>
                alertify.set('notifier','position', 'top-center');
                alertify.success('Record Inserted Successfully.');
            </script>";
        }
    ?>
</body>
</html>
