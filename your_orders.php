<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();

if (!isset($_SESSION["user_id"])) {
	header('location:login.php');
} else {
	?>

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="#">
		<title>My Orders</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/font-awesome.min.css" rel="stylesheet">
		<link href="css/animsition.min.css" rel="stylesheet">
		<link href="css/animate.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<style type="text/css" rel="stylesheet">
			.indent-small {
				margin-left: 5px;
			}

			.form-group.internal {
				margin-bottom: 0;
			}

			.dialog-panel {
				margin: 10px;
			}

			.datepicker-dropdown {
				z-index: 200 !important;
			}

			.panel-body {
				background: #e5e5e5;
				/* Old browsers */
				background: -moz-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
				/* FF3.6+ */
				background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, #e5e5e5), color-stop(100%, #ffffff));
				/* Chrome,Safari4+ */
				background: -webkit-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
				/* Chrome10+,Safari5.1+ */
				background: -o-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
				/* Opera 12+ */
				background: -ms-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
				/* IE10+ */
				background: radial-gradient(ellipse at center, #e5e5e5 0%, #ffffff 100%);
				/* W3C */
				filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#e5e5e5', endColorstr='#ffffff', GradientType=1);
				font: 600 15px "Open Sans", Arial, sans-serif;
			}

			label.control-label {
				font-weight: 600;
				color: #777;
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
			<div class="result-show">
				<div class="container">
					<div class="row">


					</div>
				</div>
			</div>

			<section class="restaurants-page">
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
						</div>
						<div class="col-xs-12">
							<div class="bg-gray">
								<div class="row">

									<table class="table table-bordered table-hover">
										<thead style="background: #404040; color:white;">
											<tr>
												<th>Order ID</th>
												<th>Restaurant</th>
												<th>Item</th>
												<th>Quantity</th>
												<th>Price</th>
												<th>Note</th>
												<th>Date Ordered</th>
												<th>Arrive</th>
												<th>Status</th>
												<th>QR Code</th>
												<th>Action</th>

											</tr>
										</thead>
										<tbody>


											<?php


											$query_res = mysqli_query($db, "SELECT users_orders.*, remark.remark, restaurant.title AS restaurant_name
											FROM users_orders
											LEFT JOIN remark ON users_orders.o_id = remark.frm_id
											INNER JOIN restaurant ON users_orders.rs_id = restaurant.rs_id
											WHERE users_orders.u_id = '" . $_SESSION['user_id'] . "'
											ORDER BY users_orders.o_id ASC");


											if (!mysqli_num_rows($query_res) > 0) {
												echo '<td colspan="6"><center>You have No orders Placed yet. </center></td>';
											} else {

												while ($row = mysqli_fetch_array($query_res)) {

													?>
													<tr>
														<td data-column="Order ID"> <?php echo $row['o_id']; ?></td>
														<script>
															function saveQRCode(orderId) {
																// Create the QR code URL
																const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=${encodeURIComponent(orderId)}`;

																// Fetch the image as a blob
																fetch(qrCodeUrl)
																	.then(response => response.blob())  // Convert the response to a blob
																	.then(blob => {
																		// Create a URL for the blob
																		const url = URL.createObjectURL(blob);

																		// Create a hidden anchor element
																		const link = document.createElement('a');
																		link.href = url;

																		// Set the file name for download
																		link.download = `order_${orderId}_qr_code.png`;

																		// Trigger the download by programmatically clicking the link
																		link.click();

																		// Clean up the URL object after the download
																		URL.revokeObjectURL(url);
																	})
																	.catch(error => {
																		console.error("Error fetching the QR code:", error);
																	});
															}
														</script>
														<td data-column="Restaurant"> <?php echo $row['restaurant_name']; ?></td>
														<td data-column="Item"> <?php echo $row['title']; ?></td>
														<td data-column="Quantity"> <?php echo $row['quantity']; ?></td>
														<td data-column="Price">$<?php echo $row['price'] * $row['quantity']; ?>
															($<?php echo $row['price']; ?>)</td>
														<td data-column="Remark">
															<?php echo $row['remark'] ? (strlen($row['remark']) > 25 ? substr($row['remark'], 0, 30) . "..." : $row['remark']) : "No Remarks"; ?>
														</td>
														<td data-column="Date">
															<?php echo date("F j, Y", strtotime($row['date'])); ?>
														</td>
														<td data-column="Arrive">
															<?php echo $row['arrive'] ? date("F j, Y", strtotime($row['arrive'])) : "No ETA"; ?>
														</td>
														<td data-column="status">
															<?php
															$status = $row['status'];
															if ($status == "" or $status == "NULL") {
																?>
																<button type="button" class="btn btn-secondary"><span
																		aria-hidden="true"></span> Processing</button>
																<?php
															}
															if ($status == "in process") { ?>
																<button type="button" class="btn btn-info"><span
																		aria-hidden="true"></span>Accepted</button>
																<?php
															}
															if ($status == "closed") {
																?>
																<button type="button" class="btn btn-success"><span aria-hidden="true"></span>
																	Delivered</button>
																<?php
															}
															?>
															<?php
															if ($status == "rejected") {
																?>
																<button type="button" class="btn btn-danger"> <i></i> Cancelled</button>
																<?php
															}
															?>






														</td>
														<td data-column="QR Code">
															<button class="btn btn-primary"
																onclick="saveQRCode('<?php echo $row['o_id']; ?>')">
																Download QR Code
															</button>
														</td>

														<td data-column="Action">
															<?php if ($status == "" || $status == "NULL") { ?>
																<a href="delete_orders.php?order_del=<?php echo $row['o_id']; ?>"
																	onclick="return confirm('Are you sure you want to cancel your order?');"
																	class="btn btn-danger btn-flat btn-addon btn-xs m-b-10">
																	<i class="fa fa-trash-o" style="font-size:16px"></i>
																</a>
															<?php } else { ?>
																<button class="btn btn-secondary btn-xs m-b-10"
																	title="Order cannot be cancelled" disabled><i
																		class="fa fa-ban"></i></button>
															<?php } ?>
														</td>

													</tr>


												<?php }
											} ?>




										</tbody>
									</table>



								</div>

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
	<?php
}
?>