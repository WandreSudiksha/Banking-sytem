<?php
ob_start();
require_once "config.php";
session_start();
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">

<head>
        <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="bootstrap-social.css"> 
    <link rel="stylesheet" href="styles.css">
 </head>
 <body>
  <!-- NAVBAR START-->
  <?php include("nav.php") ?>
  <nav class="navbar navbar-#E75480 bg-white navbar-expand-sm  fixed-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#Navbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand mr-auto" style="color: #E75480"><i class="fa fa-university" aria-hidden="true">Sparks Bank</i></a>
            <div class="collapse navbar-collapse" id="Navbar">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item "><a class="nav-link" style="color:#E75480"><span class="fa fa-home fa-lg"></span> Home</a></li>
                     <li class="nav-item active"><a class="nav-link" href="allusers.php" style="color: #E75480"><i class="fa fa-user-o" aria-hidden="true"></i></i> View Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="history.php" style="color: #E75480"><i class="fa fa-history" aria-hidden="true"></i></span> Transaction History</a></li>
                </ul>
               
        </div>
        
      </div>
    </nav>
     <hr style="border:1px solid grey; width: 1150px">
<!-- NAVBAR END-->

<!--TRANSACTION HISTORY TABLE START-->
  <div class="row row-content">
        <div class="col-12 offset-sm-1 col-sm-10">
          <h2 style="padding-top: 30px ;text-align: center; color:white;"><b></b></h2>
            <div class="table-responsive ">
                <table class="table table-green table-striped">
                    <thead class="thead-dark">
                      <tr>
                      <th>SENDER</th>
                      <th>RECEIVER</th>
                      <th>CREDITS TRANSFERED</th>
                      </tr>
                    </thead>
                    <tbody>  
                        <tr>
                           <?php 
                              $stmt = $pdo->query("SELECT * FROM history");
                              $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                              if(count($rows)>0){
                             foreach($rows as $row ) { ?>
                             <td><?php echo htmlentities($row['sender']); ?></td>
                             <td><?php echo htmlentities($row['receiver']); ?></td>       
                             <td><?php echo htmlentities($row['trans_amount']); ?></td>
                             </tr>
                           <?php }
                                }
                             ?>
                              </tbody>
                </table>
          </div>
       </div>
   </div>
<!--TRANSACTION HISTORY TABLE END-->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
 </body>
</html>
