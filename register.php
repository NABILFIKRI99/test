<?php
session_start (); // Starting Session

include('dbconn.php');



// Define variables and initialize with empty values
$username = $password = $confirm_password = $position = "";
$username_err = $password_err = $confirm_password_err =  "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT username FROM user WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

      // Validate password
      $position = trim($_POST["position"]);

      if($position == 'Manager'){
        $position = "1";     
    }  else{
        $position = "2";
    }
    

   
 // Check input errors before inserting in database
 if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
          
    // Prepare an insert statement
    $sql = "INSERT INTO user (username, password, userrole_id)
    VALUES ( ?, ?, ?)";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sss" , $param_username, $param_password, $param_position);
        
        // Set parameters
     
        $param_username = $username;
        $param_password = md5($password); // Creates a password hash
        $param_position = $position;

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
            header("location: index.php");
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
}
    
 
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Report | Register</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
  
</head>
<body>
    
    
    <div class="container">
  <div class="row content">
    

    <div class="col-md-12 form">

    <h3 class="card-title text-center">Register an Account!</h3>
    
      <div class="tab-content">
        <div id="login" class="tab-body active">
            <!-- Login Form -->
            <div class="wrapper">
        

    
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    </div>    
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                    </div>

                    <div class="form-group pb-3">
                        <label>Choose Position</label>
                        <select name="position" class="form-control" required>
                            <option>Manager</option>
                            <option>Seller</option>
                        </select>
                    </div>

                    
        
                  
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary  btn-user btn-block" value="Submit">
                    </div>
                    <p>Already have an account? <a href="index.php">Login here</a>.</p>
                </form>
    </div>
        </div>


      </div>
  

    
 

  </div>
</div>
<!-- End of Container-->
</div>

</body>
</html>