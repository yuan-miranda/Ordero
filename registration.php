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

   $selfiePath = $_SESSION['selfie_path'] ?? "";


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
   } else if (strlen($address) < 1) {
      echo "<script>alert('Invalid address!');</script>";
   } else if (empty($selfiePath) || !file_exists($selfiePath) || getimagesize($selfiePath) === false) {
      echo "<script>alert('Please provide a valid selfie with your ID!');</script>";
   } else if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
      echo "<script>alert('Username can only contain letters, numbers, and underscores!');</script>";
   } else if (!preg_match("/^[a-zA-Z ]+$/", $firstname) || !preg_match("/^[a-zA-Z ]+$/", $lastname)) {
      echo "<script>alert('First name and last name can only contain letters!');</script>";
   } else {
      // Check for duplicates
      $check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
      if (mysqli_num_rows($check_user) > 0) {
         echo "<script>alert('Username or email already exists!');</script>";
      } else {
         $hashed_password = password_hash($password, PASSWORD_DEFAULT);
         $insert_query = "INSERT INTO users(username, f_name, l_name, email, phone, password, address, selfie_path) VALUES('$username', '$firstname', '$lastname', '$email', '$phone', '$hashed_password', '$address', '$selfiePath')";
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
      <section class="contact-page inner-page">
         <div class="container ">
            <div class="row ">
               <div class="col-md-12">
                  <div class="widget">
                     <div class="widget-body">

                        <form action="" method="post" enctype="multipart/form-data">
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

                              <div class="form-group col-sm-12">
                                 <label style="font-size: 1.2em; font-weight: bold;">
                                    Provide a Picture Holding Your Student ID Near Your Face <span
                                       style="color: red;">(required)</span>
                                 </label>

                                 <!-- Toggle buttons -->
                                 <!-- Toggle buttons -->
                                 <div style="margin-bottom: 10px;">
                                    <button type="button" id="btnUpload" class="btn btn-outline-primary active">Upload
                                       Image</button>
                                    <button type="button" id="btnCamera" class="btn btn-outline-primary">Use
                                       Camera</button>
                                    <button type="button" id="snap" class="btn btn-success"
                                       style="display: none;">Capture</button>
                                 </div>


                                 <!-- Upload input (default shown) -->
                                 <div id="uploadSection" style="position: relative;">
                                    <input type="file" class="form-control-file" name="selfieWithID" accept="image/*"
                                       onchange="previewImage(event)" id="fileInput">
                                    <div style="position: relative; display: inline-block; margin-top: 10px;">
                                       <img id="previewUpload" src="#" style="max-width: 300px; display: none;" />
                                       <span id="removePreviewBtn" onclick="removePreview()" style="
                                          position: absolute;
                                          top: 5px;
                                          right: 5px;
                                          cursor: pointer;
                                          font-size: 20px;
                                          display: none;
                                          background-color: black;
                                          color: white;
                                          border-radius: 50%;
                                          width: 32px;
                                          height: 32px;
                                          text-align: center;
                                          line-height: 30px;
                                          font-weight: bold;
                                          box-shadow: 0 0 5px rgba(0,0,0,0.5);
                                       ">&times;</span>


                                    </div>
                                 </div>


                                 <div id="cameraSection" style="display:none;">
                                    <video id="video" width="320" height="240" autoplay></video>

                                    <!-- Proper wrapper for the canvas + remove button -->
                                    <div id="capturedWrapper"
                                       style="position: relative; display: none; width: 320px; height: 240px; margin-top: 10px;">
                                       <canvas id="canvas" width="320" height="240" style="display: block;"></canvas>
                                       <span id="removeCapturedBtn" onclick="removeCapturedImage()" style="
                                          position: absolute;
                                          top: 5px;
                                          right: 5px;
                                          cursor: pointer;
                                          font-size: 22px;
                                          background-color: black;
                                          color: white;
                                          border-radius: 50%;
                                          width: 34px;
                                          height: 34px;
                                          text-align: center;
                                          line-height: 32px;
                                          font-weight: bold;
                                          box-shadow: 0 0 5px rgba(0,0,0,0.4);
                                       ">&times;</span>
                                    </div>

                                    <input type="hidden" name="capturedImage" id="capturedImage" />
                                 </div>




                                 <small class="form-text text-muted"><b>Make sure your face and ID are clearly
                                       visible.</b></small>
                              </div>


                              <div class="col-sm-4">
                                 <input type="submit" value="Register" name="submit" class="btn theme-btn">
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
   <script>
      const btnUpload = document.getElementById('btnUpload');
      const btnCamera = document.getElementById('btnCamera');
      const snapBtn = document.getElementById('snap');
      const uploadSection = document.getElementById('uploadSection');
      const cameraSection = document.getElementById('cameraSection');
      const fileInput = document.getElementById('fileInput');
      const preview = document.getElementById('previewUpload');
      const removeBtn = document.getElementById('removePreviewBtn');
      const video = document.getElementById('video');
      const canvas = document.getElementById('canvas');
      const capturedImageInput = document.getElementById('capturedImage');

      let stream;

      // Toggle buttons
      btnUpload.onclick = () => {
         btnUpload.classList.add('active');
         btnCamera.classList.remove('active');
         uploadSection.style.display = 'block';
         cameraSection.style.display = 'none';
         snapBtn.style.display = 'none';
         stopCamera();
      };

      btnCamera.onclick = () => {
         btnCamera.classList.add('active');
         btnUpload.classList.remove('active');
         uploadSection.style.display = 'none';
         cameraSection.style.display = 'block';
         snapBtn.style.display = 'inline-block';
         startCamera();
      };

      // Preview uploaded file
      function previewImage(event) {
         const file = event.target.files[0];
         if (file) {
            const reader = new FileReader();
            reader.onload = e => {
               preview.src = e.target.result;
               preview.style.display = 'block';
               removeBtn.style.display = 'block';
            };
            reader.readAsDataURL(file);
         }
      }

      function removePreview() {
         fileInput.value = "";
         preview.src = "#";
         preview.style.display = "none";
         removeBtn.style.display = "none";
      }

      // Camera functions
      function startCamera() {
         if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
               .then(s => {
                  stream = s;
                  video.srcObject = stream;
                  video.play();
               })
               .catch(err => alert('Cannot access camera: ' + err));
         } else {
            alert('getUserMedia not supported on your browser.');
         }
      }

      function stopCamera() {
         if (stream) {
            stream.getTracks().forEach(track => track.stop());
         }
         video.srcObject = null;
      }

      snapBtn.addEventListener('click', () => {
         const context = canvas.getContext('2d');
         context.drawImage(video, 0, 0, canvas.width, canvas.height);

         // Switch to canvas view
         video.style.display = 'none';
         document.getElementById('capturedWrapper').style.display = 'block';

         const dataURL = canvas.toDataURL('image/png');
         fetch('upload_selfie.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'imageData=' + encodeURIComponent(dataURL)
         })
            .then(response => response.json())
            .then(data => {
               if (data.status === 'success') {
                  capturedImageInput.value = data.path;
               }
            })
            .catch(err => {
               alert('Error uploading photo: ' + err);
            });
      });

      function removeCapturedImage() {
         // Clear hidden input
         document.getElementById('capturedImage').value = "";

         // Hide canvas and remove button
         document.getElementById('capturedWrapper').style.display = 'none';

         // Show video again
         video.style.display = 'block';
      }

      // Upload handler
      fileInput.addEventListener('change', function (event) {
         previewImage(event);

         const file = fileInput.files[0];
         if (!file) return;

         const formData = new FormData();
         formData.append("selfie", file);

         fetch("upload_selfie.php", {
            method: "POST",
            body: formData
         })
            .then(res => res.json())
            .then(data => {
               if (data.status === "success") {
                  console.log("Uploaded:", data.path);
               } else {
                  alert("Image upload failed: " + data.message);
               }
            })
            .catch(err => {
               alert("Upload error: " + err);
            });
      });
   </script>

</body>

</html>