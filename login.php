<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

    <link rel='stylesheet prefetch'
        href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

    <link rel="stylesheet" href="css/login.css">

    <style type="text/css">
        #buttn {
            color: #fff;
            background-color: #5c4ac7;
        }
    </style>


    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
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
    <!-- <div style=" background-image: url('images/img/pimg.jpg');"> -->

    <?php
    include("connection/connect.php");
    session_start();
    error_reporting(0);

    $message = "";
    $success = "";

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (!empty($username) && !empty($password)) {
            $query = "SELECT * FROM users WHERE email='$username' OR username='$username'";
            $result = mysqli_query($db, $query);
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION["user_id"] = $row['u_id'];
                    header("Location: index.php");
                    exit();
                } else {
                    $message = "Invalid Username or Password!";
                }
            } else {
                $message = "Invalid Username or Password!";
            }
        }
    }

    ?>


    <div class="pen-title">
        < </div>

            <div class="module form-module">
                <div class="toggle">

                </div>
                <div class="form">
                    <h2>Login to your account</h2>
                    <span style="color:red;"><?php echo $message; ?></span>
                    <span style="color:green;"><?php echo $success; ?></span>
                    <form action="" method="post">
                        <input type="text" placeholder="Username" name="username" required />
                        <input type="password" placeholder="Password" name="password" required />
                        <input type="submit" id="buttn" name="submit" value="Login" />
                        <input type="button" value="Go to Manager Page" onclick="window.location.href='admin';" />
                    </form>
                </div>

                <div class="cta">Not registered?<a href="registration.php" style="color:#5c4ac7;">Create an account</a>
                </div>
            </div>
            <script src="js/jquery.min.js"></script>
            <script src="js/tether.min.js"></script>
            <script src="js/bootstrap.min.js"></script>



            <div class="container-fluid pt-3">
                <p></p>
            </div>

            <script>
                function confirmLogout() {
                    return confirm("Are you sure you want to log out?");
                }
            </script>

</body>

</html>