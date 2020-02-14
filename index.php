<?php
    require 'connection.php';

    if (isset($_GET['product_id'])) {
        $deleteProductId = $_GET['product_id'];
        $selectData = mysqli_query($connection, "select avatar from products where id = " . $deleteProductId);

        $avatarPath = mysqli_fetch_array($selectData, MYSQLI_ASSOC)['avatar'];
        if (file_exists('images/'.$avatarPath)) {
            unlink('images/'.$avatarPath);
        }

        $isDeleted = mysqli_query($connection, "delete from products where id = " . $deleteProductId);
    }

    $products = mysqli_query($connection, "select * from products");
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
    <div class="container mt-5">
        <a href="insert.php" class="btn btn-primary mb-2 float-right">Insert Records</a>

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Avatar</th>
                    <th>Brand Name</th>
                    <th>Model</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) { ?>
                    <tr>
                        <td>
                            <?php echo $product['id']; ?>
                        </td>
                        <td>
                            <img src="images/<?php echo $product['avatar']; ?>" width="100px" height="100px" class="rounded-circle">
                        </td>
                        <td>
                            <?php echo $product['brand_name']; ?>
                        </td>
                        <td>
                            <?php echo $product['model']; ?>
                        </td>
                        <td>
                            <?php echo $product['quantity']; ?>
                        </td>
                        <td>
                            <a href="edit.php?product_id=<?php echo $product['id']; ?>" class="btn btn-warning">
                                Edit
                            </a>

                            <button type="submit" class="btn btn-danger" onclick="deleteRecord(<?php echo $product['id'];?>);">
                                Delete
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/alertify.min.js"></script>
    <script>
        function deleteRecord(deleteProductId) {
            alertify.confirm("Confirm Msg","Are you sure want to delete the record?", function () {
                window.location ="index.php?act=delete&product_id=" + deleteProductId;

                alertify.set('notifier','position', 'top-center');
            }, function(){});
        }
    </script>

    <?php
        if (isset($isDeleted) == true) {
            echo"<script type='text/javascript'>
                alertify.set('notifier','position', 'top-center');
                alertify.success('Record Deleted Successfully.');
            </script>";
        }
    ?>
</body>
</html>