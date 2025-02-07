<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD-Employees</title>
    <link rel="stylesheet" href="bootstrap-5.1.3/dist/css/bootstrap.css">
    <link rel="stylesheet" href="font/css/all.css">
    <script src="bootstrap-5.1.3/dist/js/bootstrap.js"></script>
</head>
<style>
    .main img{
        position:absolute;
        display:block;
        box-sizing:border-box;
        padding:5px;
        background-color:rgba(255,255,255,0.25);
        transform: rotate(10deg);
        border-radius : 5px;
        width:75px;
        height:75px;
    }
    .img-1{
        top:35px;
        left: 25px;
    }
    .main .img-2{
        top:25px;
        right:50px;
        transform: rotate(-10deg);
    }
    .img-3{
        bottom:25px;
        left:150px;
    }
    .img-4{
        bottom:35px;
        right:150px;
    }
</style>
<body >
    <div class="container-fluid">
        <?php include_once("header.php");?>
    </div>
    <div class="border-3 border p-5 text-center text-light position-relative main" style="background-color:rgba(150,150,250,1);">
        <h3>Welcome</h3>
        <h3>To</h3>
        <h2>Employee Management System</h2>
        <img class="img-1" src="create.png" alt="">
        <img class="img-2" src="read.png" alt="">
        <img class="img-3" src="update.png" alt="">
        <img class="img-4" src="delete.png" alt="">
    </div>
    <div class="w-50 shadow mx-auto pb-5 text-center position-relative rounded" style="margin-top:-15px;background-color:rgba(245,245,245,0.9);z-index:15;">
        <h3 class="text-muted">Current :</h3>
        <span class="fw-bolder">
            <i class="fas fa-user-alt"></i>
            <?php
            require_once "config.php";
                    
            // Attempt select query execution
            $sql = "SELECT COUNT(id) as num FROM employees";
            if($result = mysqli_query($link, $sql)){
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_array($result);
                    echo $row["num"];
                }
            }
            ?>
            Employees
        </span>
        <a href="accueil.php" class="btn btn-success d-block w-50 mx-auto mt-4 ">Access to Database</a>
    </div>
    <?php include_once("footer.php")?>
</body>
</html>