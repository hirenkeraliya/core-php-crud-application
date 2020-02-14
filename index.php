<?php
    require 'connection.php';

    $results = mysqli_query($conn, "select * from products");

    if (isset($_GET['id1'])) {
        $deleteId = $_GET['id1'];

        $selectData = mysqli_query($conn, "select * from products where id = '$deleteId'");

        while ($records = mysqli_fetch_array($selectData, MYSQLI_ASSOC)) {
            if (file_exists('images/'.$records['avatar'])) {
                unlink('images/'.$records['avatar']);
            }
        }
        $deleted = mysqli_query($conn, "delete from products where id = '$deleteId'");
    }
    $results = mysqli_query($conn, "select * from products");
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
                <?php foreach ($results as $result) { ?>
                    <tr>
                        <td>
                            <?php echo $result['id']; ?>
                        </td>
                        <td>
                            <img src="images/<?php echo $result['avatar']; ?>" width="100px" height="100px" class="rounded-circle">
                        </td>
                        <td>
                            <?php echo $result['brand_name']; ?>
                        </td>
                        <td>
                            <?php echo $result['model']; ?>
                        </td>
                        <td>
                            <?php echo $result['qty']; ?>
                        </td>
                        <td>
                            <a href="edit.php?id1=<?php echo $result['id']; ?>" class="btn btn-warning">
                                Edit
                            </a>

                            <button type="submit" class="btn btn-danger" onclick="deleteRecord();">
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
        function deleteRecord() {
            alertify.confirm("Confirm Msg","Are you sure want to delete the record?", function () {
                window.location ="index.php?act=delete&id1=<?php echo $result['id']; ?>";
                alertify.set('notifier','position', 'top-center');
            }, function(){});
        }
    </script>

    <?php
        if (isset($inserted) == true) {
            echo"<script type='text/javascript'>
                alertify.set('notifier','position', 'top-center');
                alertify.success('Record Inserted Successfully.');
            </script>";
        }

        if (isset($updated) == true) {
            echo"<script type='text/javascript'>
                alertify.set('notifier','position', 'top-center');
                alertify.success('Record Updated Successfully.');
            </script>";
        }

        if (isset($deleted) == true) {
            echo"<script type='text/javascript'>
                alertify.set('notifier','position', 'top-center');
                alertify.success('Record Deleted Successfully.');
            </script>";
        }
    ?>
</body>
</html>