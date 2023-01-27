<?php


session_start();
  include('../dbconn.php');
  include("../function.php");
  $user_id = $_SESSION['user_id'];


  $sql = "SELECT * FROM sales WHERE user_id = $user_id ";
  $result = $conn->query($sql);
  $arr_users = [];
  if ($result->num_rows > 0) {
      $arr_users = $result->fetch_all(MYSQLI_ASSOC);
  }
  

    //Code for add data
    if (!empty($_POST['submit_1'])) { 
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {

        $user_id = $sales = $sales_dates = "";

        //something was posted
        $user_id = $_SESSION['user_id'];
        $sales = $_POST['sales'];
        $sales_dates = $_POST['sales_dates'];

       
 {

                      //Save to your Database
                      $query = "insert into sales (user_id, sales, sales_dates) values ('$user_id', '$sales','$sales_dates')";
                     
                      mysqli_query($conn, $query);
                      // mysqli_query($connect_to_db, "INSERT INTO images (user, filelocation) VALUES ('$user', '$filelocation', '$size')");

                      header("Location: index.php");
                  }
              
       
        }
    }

        //Code for update data
        if (!empty($_POST['submit_edit'])) { 
          if($_SERVER['REQUEST_METHOD'] == "POST")
          {
  
          $user_id = $sales_id = $sales = $sales_dates = "";
  
          //something was posted
          $user_id = $_SESSION['user_id'];
          $sales_id = $_POST['sales_id'];
          $sales = $_POST['sales'];
          $sales_dates = $_POST['sales_dates'];
  
         
   {
  
                        //Save to your Database
                        $query_edit =  "UPDATE sales SET sales='$sales' , sales_dates='$sales_dates' WHERE sales_id=$sales_id";
                       
                        if (mysqli_query($conn, $query_edit )) {
                           header("Location: index.php");
                        } else {
                          echo "Error updating record: " . mysqli_error($conn);
                        }

                       
                    }
                
         
          }
      }

      //ChartJS
      //query to get data from the table
      $query = "SELECT DATE(sales_dates) as DATE, SUM(`sales`) totalCOunt
      FROM      sales
      WHERE user_id = $user_id
      GROUP BY  DATE(sales_dates)";
			$result = mysqli_query($conn, $query);

      // $query = $conn->query("
      // SELECT * FROM sales ORDER BY sales_dates 
      // ");
    
      foreach($result as $data)
      {
        $month[] = $data['DATE'];
        $amount[] = $data['totalCOunt'];
      }

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Report | Seller</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../style.css">
  </head>
<body>
    
    
    <div class="container">
  <div class="row content">
    

    <div class="col-md-12 form">

    <div class="container">
  <div class="row">
  <h1 class="col h3 mb-2 mt-3 text-gray-800">Dashboard Seller</h1>
   

  <button type="button" class="col btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Add
</button>


  </div>
</div>



<div class="container">
<div class="row">

<a href="../logout.php" class="col mb-2 mt-3 col btn btn-secondary" >Log Out</a>


</div>
</div>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Sales</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <!-- PHP REFERENCE -->
          <form class="text-start mb-3" method="post" method="post" enctype="multipart/form-data">
               
                <div class="form-floating mb-4">
                  <input type="number" name="sales" class="form-control" placeholder="number" name="items_quantity">
                
                </div>

                <div class="form-floating mb-4">
                  <input type="date" name="sales_dates" class="form-control" placeholder="name" name="items_name">
              
                </div>
                
                <input class="btn btn-primary rounded-pill w-100 mb-2" type="submit" value="Submit" name="submit_1" ></input>
              </form>
              <!-- /form -->
              
      </div>
      
    </div>
  </div>
</div>


                   
      <div class="col mb-2 mt-3">
     
      <table id="sales">
    <thead>
        <th>Sales</th>
        <th>Date</th>
        <th>Edit</th>
        <th>Delete</th>
    </thead>
    <tbody>
        <?php if(!empty($arr_users)) { ?>
            <?php foreach($arr_users as $user) { ?>
                <tr>
                    <td>RM<?php echo $user['sales']; ?></td>
                    <td><?php echo $user['sales_dates']; ?></td>
                    <td><!-- Button trigger modal -->
<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal1" <?php echo $user['sales_id']; ?>>
  Edit
</button>

<!-- Modal Edit -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Sales</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
         <!-- PHP REFERENCE -->
         <form class="text-start mb-3" method="post" method="post" enctype="multipart/form-data">
               
               <div class="form-floating mb-4">
                 <input type="number" value="<?php echo $user['sales']; ?>" name="sales" class="form-control" placeholder="number" name="items_quantity">
               
               </div>

               <div class="form-floating mb-4">
                 <input type="date" value="<?php echo $user['sales_dates']; ?>" name="sales_dates" class="form-control" placeholder="name" name="items_name">
                 <input type="hidden"  name="sales_id" value="<?php echo $user['sales_id']; ?>" >
               </div>
               
               <input class="btn btn-primary rounded-pill w-100 mb-2" type="submit" value="Submit" name="submit_edit" ></input>
             </form>
             <!-- /form -->
             
      </div>
     
    </div>
  </div>
</div></td>
                    <td><a class="btn btn-danger deletebtn" href="delete.php?sales_id=<?php echo $user["sales_id"]; ?>">Delete</td>
                </tr>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>
 

  </div>
</div>

</div>

<div>
  <!-- <canvas class="mt-4 pt-4" id="mycanvas"></canvas> -->





  <!-- <div id="chart-container">
        <canvas id="graphCanvas"></canvas>
    </div> -->
    <div class="container graph mb-4">
  <div class="row">
  <div class="col-12" style="width: 100%;">
  <canvas id="myChart"></canvas>
</div>
  </div>
</div>
  
 

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" ></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<!-- Data table -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>

<script>
jQuery(document).ready(function($) {
    $('#sales').DataTable();
} );
</script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // === include 'setup' then 'config' above ===
  const labels = <?php echo json_encode($month) ?>;
  const data = {
    labels: labels,
    datasets: [{
      label: 'Total Sales vs Day',
      data: <?php echo json_encode($amount) ?>,
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 205, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(201, 203, 207, 0.2)'
      ],
      borderColor: [
        'rgb(255, 99, 132)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
        'rgb(153, 102, 255)',
        'rgb(201, 203, 207)'
      ],
      borderWidth: 1
    }]
  };

  const config = {
    type: 'line',
    data: data,
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    },
  };

  var myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>

        <script>
  // === include 'setup' then 'config' above ===
  const labels = <?php echo json_encode($month) ?>;
  const data = {
    labels: labels,
    datasets: [{
      label: 'My First Dataset',
      data: <?php echo json_encode($amount) ?>,
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 205, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(201, 203, 207, 0.2)'
      ],
      borderColor: [
        'rgb(255, 99, 132)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
        'rgb(153, 102, 255)',
        'rgb(201, 203, 207)'
      ],
      borderWidth: 1
    }]
  };

  const config = {
    type: 'line',
    data: data,
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    },
  };

  var myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>

</body>
</html>