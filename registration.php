<!DOCTYPE html>
<html lang="en">
<?php

session_start();
error_reporting(0);
include("connection/connect.php");
if (isset($_POST['submit'])) {
   // Sanitize input
   $username = mysqli_real_escape_string($db, $_POST['username']);
   $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
   $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
   $email = mysqli_real_escape_string($db, $_POST['email']);
   $phone = mysqli_real_escape_string($db, $_POST['phone']);
   $address = mysqli_real_escape_string($db, $_POST['address']);
   $password = $_POST['password'];
   $cpassword = $_POST['cpassword'];

   if (
      empty($username) || empty($firstname) || empty($lastname) ||
      empty($email) || empty($phone) || empty($password) || empty($cpassword) || empty($address)
   ) {
      echo "<script>alert('All fields must be filled out!');</script>";
   } else if ($password !== $cpassword) {
      echo "<script>alert('Passwords do not match');</script>";
   } else if (strlen($password) < 6) {
      echo "<script>alert('Password must be at least 6 characters long');</script>";
   } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "<script>alert('Invalid email address!');</script>";
   } else if (strlen($phone) < 10) {
      echo "<script>alert('Invalid phone number!');</script>";
   } else {
      // Check for duplicates
      $check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
      if (mysqli_num_rows($check_user) > 0) {
         echo "<script>alert('Username or email already exists!');</script>";
      } else {
         $hashed_password = password_hash($password, PASSWORD_DEFAULT);
         $insert_query = "INSERT INTO users(username, f_name, l_name, email, phone, password, address)
                            VALUES('$username', '$firstname', '$lastname', '$email', '$phone', '$hashed_password', '$address')";
         if (mysqli_query($db, $insert_query)) {
            header("Location: login.php");
            exit;
         } else {
            echo "<script>alert('Registration failed. Try again later.');</script>";
         }
      }
   }
}




?>


<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="">
   <meta name="author" content="">
   <link rel="icon" href="#">
   <title>Registration</title>
   <link href="css/bootstrap.min.css" rel="stylesheet">
   <link href="css/font-awesome.min.css" rel="stylesheet">
   <link href="css/animsition.min.css" rel="stylesheet">
   <link href="css/animate.css" rel="stylesheet">
   <link href="css/style.css" rel="stylesheet">
</head>

<body>
   <!-- <div style=" background-image: url('images/img/pimg.jpg');"> -->
   <header id="header" class="header-scroll top-header headrom">
      <nav class="navbar navbar-dark" style="background-image: none; background-color: black;">
         <div class="container">
            <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse"
               data-target="#mainNavbarCollapse">&#9776;</button>
            <a class="navbar-brand" href="index.php">ORDERO</a>
            <div class="collapse navbar-toggleable-md  float-lg-left" id="mainNavbarCollapse">
               <ul class="nav navbar-nav">
                  <li class="nav-item"> <a class="nav-link active" href="restaurants.php">Restaurants <span
                           class="sr-only"></span></a> </li>

                  <?php
                  if (!isset($_SESSION["user_id"])) {
                     echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a> </li>
							  <li class="nav-item"><a href="registration.php" class="nav-link active">Register</a> </li>';
                  } else {


                     echo '<li class="nav-item"><a href="your_orders.php" class="nav-link active">My Orders</a> </li>';

                     echo '<li class="nav-item"><a href="logout.php" class="nav-link active" onclick="return confirmLogout();">Logout</a> </li>';
                  }

                  ?>

               </ul>
            </div>
         </div>
      </nav>
   </header>
   <div class="page-wrapper">

      <div class="container">
         <ul>


         </ul>
      </div>

      <section class="contact-page inner-page">
         <div class="container ">
            <div class="row ">
               <div class="col-md-12">
                  <div class="widget">
                     <div class="widget-body">

                        <form action="" method="post">
                           <div class="row">
                              <div class="form-group col-sm-12">
                                 <label for="exampleInputEmail1">User-Name</label>
                                 <input class="form-control" type="text" name="username"
                                    value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                              </div>
                              <div class="form-group col-sm-6">
                                 <label for="exampleInputEmail1">First Name</label>
                                 <input class="form-control" type="text" name="firstname"
                                    value="<?php echo htmlspecialchars($_POST['firstname'] ?? ''); ?>">
                              </div>
                              <div class="form-group col-sm-6">
                                 <label for="exampleInputEmail1">Last Name</label>
                                 <input class="form-control" type="text" name="lastname"
                                    value="<?php echo htmlspecialchars($_POST['lastname'] ?? ''); ?>">
                              </div>
                              <div class="form-group col-sm-6">
                                 <label for="exampleInputEmail1">Email Address</label>
                                 <input type="text" class="form-control" name="email"
                                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                              </div>
                              <div class="form-group col-sm-6">
                                 <label for="exampleInputEmail1">Phone number</label>
                                 <input class="form-control" type="text" name="phone"
                                    value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                              </div>
                              <div class="form-group col-sm-6">
                                 <label for="exampleInputPassword1">Password</label>
                                 <input class="form-control" type="password" name="password"
                                    value="<?php echo htmlspecialchars($_POST['password'] ?? ''); ?>">
                              </div>
                              <div class="form-group col-sm-6">
                                 <label for="exampleInputPassword1">Confirm password</label>
                                 <input class="form-control" type="password" name="cpassword"
                                    value="<?php echo htmlspecialchars($_POST['cpassword'] ?? ''); ?>">
                              </div>
                              <div class="form-group col-sm-12">
                                 <label for="exampleTextarea">Delivery Address</label>
                                 <textarea class="form-control" name="address"
                                    rows="3"><?php echo htmlspecialchars($_POST['address'] ?? ''); ?></textarea>
                              </div>

                           </div>

                           <div class="row">
                              <div class="col-sm-4">
                                 <p> <input type="submit" value="Register" name="submit" class="btn theme-btn"> </p>
                              </div>
                           </div>
                        </form>

                     </div>

                  </div>

               </div>

            </div>
         </div>
      </section>

   </div>

   <script src="js/jquery.min.js"></script>
   <script src="js/tether.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <script src="js/animsition.min.js"></script>
   <script src="js/bootstrap-slider.min.js"></script>
   <script src="js/jquery.isotope.min.js"></script>
   <script src="js/headroom.js"></script>
   <script src="js/foodpicky.min.js"></script>
   <script src="js/REPLACEDOLLAR.js"></script>
   <script>
      function confirmLogout() {
         return confirm("Are you sure you want to log out?");
      }
   </script>

</body>

</html>