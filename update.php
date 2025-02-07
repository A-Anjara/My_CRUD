<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $address = $sex = $salary = $username = $tel = "";
$name_err = $address_err = $sex_err = $salary_err = $username_err=$tel_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    //Validate username
    $input_username = trim($_POST["username"]);
     if(empty($input_username)){
         $username_err = "Please enter a username.";
     } elseif(preg_match("/[^a-zA-Z ]/",$input_username)){
         $username_err = "Please enter a valid username.";
     } else{
         $username = $input_username;
     }
     //Validate sex
     $input_sex = $_POST["sex"];
     if($input_sex == "N"){
        $sex_err = "Please choose a sex";
     }
     else{
        $sex = $input_sex;
     }

    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }

    // Validate Phone Number
    $input_telephone = trim($_POST["tel"]);
    $input_telephone = preg_replace("/\s+/",'',$input_telephone);
    if(empty($input_telephone)){
        $tel_err = "Please enter your Phone Number";
    }
    elseif (preg_match("/[^0-9]/",$input_telephone)) {
        $tel_err = "Please enter a valid Number";
    }
    else{
        $tel = $input_telephone;
    }
    
    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err) && empty($sex_err) && empty($username_err) && empty($tel_err)){
        // Prepare an update statement
        $sql = "UPDATE employees SET name=?, username=?,sex=?, address=?, tel=?, salary=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssi", $param_name, $param_username, $param_sex,$param_address, $param_tel, $param_salary, $param_id);
            
            // Set parameters
            $param_name = $name;
            $param_username = $username;
            $param_sex = $sex;
            $param_address = $address;
            $param_tel = $tel;
            $param_salary = $salary;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: accueil.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM employees WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $name = $row["name"];
                    $username = $row["username"];
                    $sex = $row["sex"];
                    $address = $row["address"];
                    $tel = $row["tel"];
                    $salary = $row["salary"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="bootstrap-5.1.3/dist/css/bootstrap.css">
    <link rel="stylesheet" href="font/css/all.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<?php include_once("header.php");?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 border border-1 p-3 border-secondary rounded">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="text-danger"><?php echo $name_err;?></span>
                        </div>
                        
                        <div class="form-group <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                            <span class="text-danger"><?php echo $username_err;?></span>
                        </div>
                        <div class="form-group">
                            <label for="">Sex: </label>
                            <select class="form-select" name="sex">
                                <option value="M" <?php echo ($sex=="M")? 'selected':'';?>>Masculin</option>
                                <option value="F"<?php echo ($sex=="F")? 'selected':'';?>>Feminin</option>
                            </select>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="text-danger"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tel_err)) ? 'is-invalid' : ''; ?>">
                            <label>Telephone</label>
                            <input type="text" name="tel" class="form-control" value="<?php echo $tel; ?>">
                            <span class="text-danger"><?php echo $tel_err;?></span>
                        </div>
                        <div class="form-group mb-2 <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
                            <span class="text-danger"><?php echo $salary_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary me-2" value="Submit">
                        <a href="accueil.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
    <?php include_once("footer.php")?>
</body>
</html>