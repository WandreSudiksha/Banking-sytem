<?php
ob_start();
require_once "config.php";
session_start();
if (isset($_POST['submit'])){
   $receiver=$_POST['receiver'];
   $amount=$_POST['amount'];
   $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id=:xyz");
   $stmt->execute(array(":xyz" => $_GET['user_id']));
   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   $sender=$row['user_name'];
   $balance=$row['user_credits'];
//    echo $sender;
//    echo $receiver;
   if($balance<$amount){
     ?>
        <script>
        alert("Insufficient balance");
        </script>
     <?php
   }
   else{
      
   $sql = "INSERT INTO history (sender, receiver, trans_amount) VALUES (?,?,?)";
   $stmt= $pdo->prepare($sql);
   $stmt->execute([$sender, $receiver, $amount]);

   $sql = "UPDATE users SET user_credits=user_credits-$amount WHERE user_name='$sender'";
   $stmt= $pdo->prepare($sql);
   $stmt->execute();

   $sql = "UPDATE users SET user_credits=user_credits+$amount WHERE user_name='$receiver'";
   $stmt= $pdo->prepare($sql);
   $stmt->execute();
 ?>
 <script>
   alert("Payment Successful");
 </script>

<?php 
}
} 
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="bootstrap-social.css">
    <link rel="stylesheet" type="text/css" href="styles.css"> 
    <link rel="stylesheet">
</head>
<body>

   <!-- NAVBAR START-->  
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
<!-- NAVBAR END-->

<hr style="border:1px solid grey; width: 1250px">
<?php
$stmt = $pdo->prepare("SELECT * FROM users where user_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['user_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$sender=$row['user_name']?? 'default value';;
?>
<!-- USER DETAILS START-->
    <div class="container" style=" padding-top:200px;"  >
          <div class="row">
             <div class="col-sm offset-md-3 col-md-6">
                  <div class="panel panel-default bg-dark  " style="padding: 10px; color:white; border-radius: 0px;">
                       <h2 style="text-align: center;">User Details</h2>
                           <hr style="border:1px solid white;">
                                <div class="panel panel-default" style="color:  black;" >
                                   <div class="panel-body">
            <p><b>Name:</b> <?php echo htmlentities($row['user_name']?? 'default value'); ?></p>
            <p><b>Email Id:</b> <?php echo htmlentities($row['email']?? 'default value'); ?></p>
            <p><b>Credits:</b> <?php echo htmlentities($row['user_credits']?? 'default value'); ?></p>   
            <p><button class="btn btn-dark btn-xs view_data" data-toggle="modal" data-target="#transfer<?php echo $row['user_id'] ?>">Transfer Amount</button></p> 
                                   </div>
                                </div>
            </div>
            </div>
          </div>
   </div>
<!-- USER DETAILS END-->

<!-- TRANSACTION MODAL START-->
   <div id="transfer<?php echo $row['user_id'] ?>" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" role="content">
            <!-- Modal content-->
            <div class="modal-content">
                <?php $id=$row['user_id']; ?>
                <div class="modal-header">
                    <h4 class="modal-title">Transfer Money </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group row">
                        <label for="name" name="<?php echo $row['user_id'] ?>" class="col-md-2 col-form-label">Sender:</label>
                        <div class="col-md-10" id="uname">
                           <p><?php echo $row['user_name'] ?></p>
                        </div>
                        </div>
                       <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">Reciever:</label>
                        <div class="col-md-10">
                            <select name="receiver" class="form-control">
                                <?php 
                                   $stmt = $pdo->query("SELECT * FROM users WHERE user_id!=$id ");
                                   $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                   if(count($rows)>0){
                                   foreach($rows as $row ) { ?>

                                     <option><?php echo $row['user_name'] ?></option>
                                  
                                  <?php }
                                       } 
                                 ?>
                            </select>
                        </div>
                        </div>
                    <div class="form-group row">
                        <label for="amount" class="col-md-2 col-form-label">Transfer Amount</label>
                        <div class="col-md-10">
                            <input type="number" class="form-control" id="amount" name="amount" placeholder=" Credits\Amount" required>
                        </div>
                    </div>   
                       <div class="form-group row">
                          <button href="profile.php?user_id=$id" type="submit" id="submit" name="submit" class="btn btn-primary btn-sm ml-auto">Transfer</button>  
                         
                         <button type="button" class="btn btn-secondary btn-sm ml-1" data-dismiss="modal">Cancel</button>     
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- TRANSACTION MODAL END-->

 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script> 
<!-- TO CHECK THE REQUIRED FIELDS-->  
<script>
     $(document).ready(function(){
    document.getElementById("submit").onclick = function () {
        if() {
            alert('error please fill all fields!');
            }      

         };   
  });
</script>

</body>
</html>
