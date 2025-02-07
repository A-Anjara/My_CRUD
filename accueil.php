<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="bootstrap-5.1.3/dist/css/bootstrap.css">
    <link rel="stylesheet" href="font/css/all.css">
    <script src="bootstrap-5.1.3/dist/js/bootstrap.js"></script>
<style>
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
<?php include_once("header.php");?>
    <div class="">
        <div class="container mw-100">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header d-flex flex-wrap justify-content-end mb-3">
                        <h2 class="w-100">Employees Details</h2>
                        <a href="create.php" class="btn btn-success">Add New Employee</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM employees";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped text-center'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Username</th>";
                                        echo "<th>Sex</th>";
                                        echo "<th>Address</th>";
                                        echo "<th>Telephone</th>";
                                        echo "<th>Salary</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['username'] . "</td>";
                                        echo "<td>" . $row['sex'] . "</td>";
                                        echo "<td>" . $row['address'] . "</td>";
                                        echo "<td>" . $row['tel'] . "</td>";
                                        echo "<td>" . $row['salary'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='read.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><i class=\" fas fa-eye\"></i></a>";
                                            echo "<a href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><i class='fas fa-user-edit'></i></a>";
                                            echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><i class=\"fas fa-trash-alt\"></i></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
    <?php include_once("footer.php")?>
</body>
</html>