<?php
include("connection/connect.php");
session_start();
error_reporting(0);

if (!isset($_GET['dish_id'])) {
    echo "No dish selected.";
    exit;
}

$dish_id = intval($_GET['dish_id']);
$query = mysqli_query($db, "SELECT * FROM dishes WHERE d_id = $dish_id");

if (mysqli_num_rows($query) == 0) {
    echo "Dish not found.";
    exit;
}

$dish = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($dish['title']); ?> - Dish Details</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .carousel-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .carousel {
            max-width: 1000px;
            flex: 1;
        }

        .carousel-inner {
            display: flex;
            justify-content: center;
        }

        .carousel-controls {
            position: absolute;
            top: 50%;
            display: flex;
            justify-content: space-between;
            width: 100%;
            transform: translateY(-50%);
            z-index: 10;
            /* Optional: Adjust the height of buttons */
            padding: 0 20px;
        }

        .carousel-control-prev,
        .carousel-control-next {
            background-color: rgba(0, 0, 0, 0.5);
            /* semi-transparent background */
            color: white;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }


        /* Change indicator color to black */
        .carousel-indicators li {
            background-color: white;
            border: 1px solid black;
            /* Set default indicator color to black */
        }

        /* Change the color of the active indicator */
        .carousel-indicators .active {
            background-color: black;
            /* Set the active indicator color to white */
        }
    </style>
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
                        <li class="nav-item"> <a class="nav-link active" href="index.php">Home <span
                                    class="sr-only">(current)</span></a> </li>
                        <li class="nav-item"> <a class="nav-link active" href="restaurants.php">Restaurants <span
                                    class="sr-only"></span></a> </li>

                        <?php
                        if (empty($_SESSION["user_id"])) {
                            echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a> </li>
							  <li class="nav-item"><a href="registration.php" class="nav-link active">Register</a> </li>';
                        } else {


                            echo '<li class="nav-item"><a href="your_orders.php" class="nav-link active">My Orders</a> </li>';
                            echo '<li class="nav-item"><a href="your_profile.php" class="nav-link active">My Profile</a> </li>';
                            echo '<li class="nav-item"><a href="logout.php" class="nav-link active" onclick="return confirmLogout();">Logout</a> </li>';
                        }

                        ?>

                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Dish Detail Section -->
    <section class="popular" style="padding-bottom: 20px;">
        <div class="container" style="margin-top: 20px; border: 1px solid #ddd; border-radius: 5px;">
            <div class="row">
                <div class="col-md-6">
                    <img src="admin/Res_img/dishes/<?php echo $dish['img']; ?>" class="img-fluid rounded"
                        alt="<?php echo htmlspecialchars($dish['title']); ?>">
                </div>
                <div class="col-md-6" style="padding: 20px;">
                    <h2><?php echo htmlspecialchars($dish['title']); ?></h2>
                    <p><strong>Slogan:</strong> <?php echo htmlspecialchars($dish['slogan']); ?></p>
                    <h4><strong>$<?php echo $dish['price']; ?></strong></h4>
                    <!-- Optional: Add more info like ingredients, category, etc. -->
                    <a href="dishes.php?res_id=<?php echo $dish['rs_id']; ?>" class="btn theme-btn-dash pull-right">View
                        Cart</a>
                </div>
            </div>
        </div>
    </section>

    <section class="carousel-section" style="padding: 15px 0;">
        <div class="container">
            <h3 class="mb-4">More Photos</h3>
            <div class="carousel-wrapper">
                <div id="carouselExample" class="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExample" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExample" data-slide-to="1"></li>
                        <li data-target="#carouselExample" data-slide-to="2"></li>
                    </ol>

                    <!-- Slides -->
                    <div class="carousel-inner text-center">
                        <div class="carousel-item active">
                            <img src="admin/Res_img/dishes/<?php echo $dish['img']; ?>" alt="Slide 1"
                                style="width: 1000px; height: auto; aspect-ratio: 2 / 1; display: inline-block;">
                        </div>
                        <div class="carousel-item">
                            <img src="admin/Res_img/dishes/<?php echo $dish['img']; ?>" alt="Slide 2"
                                style="width: 1000px; height: auto; aspect-ratio: 2 / 1; display: inline-block;">
                        </div>
                        <div class="carousel-item">
                            <img src="admin/Res_img/dishes/<?php echo $dish['img']; ?>" alt="Slide 3"
                                style="width: 1000px; height: auto; aspect-ratio: 2 / 1; display: inline-block;">
                        </div>
                    </div>
                </div>

                <!-- Controls (Buttons beside carousel) -->
                <div class="carousel-controls">
                    <a class="carousel-control-prev" href="javascript:void(0);" role="button" id="prevBtn">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="javascript:void(0);" role="button" id="nextBtn">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

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
        const slides = document.querySelectorAll('.carousel-item');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const indicators = document.querySelectorAll('.carousel-indicators li');

        let currentIndex = 0;

        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            indicators.forEach(indicator => indicator.classList.remove('active'));

            slides[index].classList.add('active');
            indicators[index].classList.add('active');
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % slides.length;
            showSlide(currentIndex);
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            showSlide(currentIndex);
        }

        nextBtn.addEventListener('click', nextSlide);
        prevBtn.addEventListener('click', prevSlide);

        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                currentIndex = index;
                showSlide(currentIndex);
            });
        });

        showSlide(currentIndex);
        setInterval(nextSlide, 5000);

    </script>

</body>

</html>