<?php

/**
 * The goal of this file is to show template for user interface
 * for the sign up and login, have same default code
 * CHANGE EMAIL TO MATRIC NUMBER
 */
session_start();
  include('dbconn.php');
  include("function.php");

  //PHP CODE FOR LOGIN 
  if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$username = $_POST['username'];
		$password = md5($_POST['password']);

		if(!empty($username) && !empty($password) && !is_numeric($username))
		{

			//read from database
			$query = "select * from user where username = '$username' limit 1";
			$result = mysqli_query($conn, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{

					$user_data = mysqli_fetch_assoc($result);
					
					if($user_data['password'] === $password)
					{

            if($user_data['userrole_id'] === '1')
            {
              $_SESSION['user_id'] = $user_data['user_id'];
              header("Location: manager/index.php");
              die;
            } 
            else 
            {
              $_SESSION['user_id'] = $user_data['user_id'];
              header("Location: seller/index.php");
              die;
            } 
            

					}
				}
			}
			
			// echo "wrong username or password!";
		}else
		{
			echo "wrong username or password!";
		}
	}


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Report | Login</title>
   
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
   
</head>
<body>
    
    
    <div class="container px-5 ">
  <div class="row content">
    

    <div class="col-md-12 form px-5">

    <h3 class="card-title text-center">Login the Account!</h3>
    
      <div class="tab-content">
        <div id="login" class="tab-body active">
            <!-- Login Form -->
            <div class="wrapper">
        

    
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input id="text" type="text" name="username" class="form-control" placeholder="Username">
                    </div>    
                    <div class="form-group">
                        <label>Password</label>
                        <input id="text" type="password" name="password" class="form-control" placeholder="Password">
                    </div>
             
        
                  
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary  btn-user btn-block" value="Submit">
                    </div>
                    <p>Do not have an account? <a href="register.php">Register here</a>.</p>
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