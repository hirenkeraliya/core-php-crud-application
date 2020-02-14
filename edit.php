<?php
    session_start();

    require 'connection.php';

    $productId = $_GET['product_id'];

    if (isset($_POST['update']) == "Update") {
        $brandName = $_POST['brand_name'];
        $model = $_POST['model'];
        $quantity = $_POST['quantity'];
        $avatarUpdateQuery = '';

        if ($_FILES['photo']['name'] != '') {
            $temporaryNumber = rand(1, 100);
            $avatar = $_FILES['photo']['name'];
            $photo ='images/'.$temporaryNumber.$avatar;

            $selectData = mysqli_query($connection, "select avatar from products where id = " . $productId);
            $avatarPath = mysqli_fetch_array($selectData, MYSQLI_ASSOC)['avatar'];
            if (file_exists('images/'.$avatarPath)) {
                unlink('images/'.$avatarPath);
            }

            move_uploaded_file($_FILES['photo']['tmp_name'], $photo);

            $avatarUpdateQuery = "avatar = '".$temporaryNumber.$avatar."', ";
        }

        $isUpdated = mysqli_query($connection, "UPDATE products set ".$avatarUpdateQuery."brand_name = '".$brandName."', model = '".$model."', quantity = ".$quantity." WHERE id = " . $productId);
    }

    $fetchProductQuery = mysqli_query($connection, "select * from products where id = ".$productId);
    $product = mysqli_fetch_array($fetchProductQuery, MYSQLI_ASSOC);
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
                <label class="control-label col-md-3 col-sm-3">Brand Name:</label>

                <div class="col-md-4 col-sm-4">
                    <input type="text" name="brand_name" value="<?php echo $product['brand_name']; ?>" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3" name="model">Model:</label>
                <div class="col-md-4 col-sm-4">
                    <input type="text" name="model" value="<?php echo $product['model']; ?>" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3" name="quantity">Quantity:</label>
                <div class="col-md-4 col-sm-4">
                    <input type="text" name="quantity" value="<?php echo $product['quantity']; ?>" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3" name="avatar">Avatar:</label>

                <div class="col-md-4 col-sm-4">
                    <input type="file" name="photo" accept="image/*" class="form-control">
                </div>
            </div>

            <div class="col-md-8 row">
                <div class="col-md-3">
                    <input type="submit" name="update" value="Update" class="form-control btn btn-primary">
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
        if (isset($isUpdated) == true) {
            echo"<script type='text/javascript'>
                alertify.set('notifier','position', 'top-center');
                alertify.success('Record Updated Successfully.');
            </script>";
        }
    ?>
</body>
</html>