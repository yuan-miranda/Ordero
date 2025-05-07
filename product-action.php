<?php
if (!empty($_GET["action"])) {
	$productId = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
	$quantity = isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : '';

	switch ($_GET["action"]) {
		case "add":
			if (!empty($quantity)) {
				$stmt = $db->prepare("SELECT * FROM dishes WHERE d_id = ?");
				$stmt->bind_param('i', $productId);
				$stmt->execute();
				$productDetails = $stmt->get_result()->fetch_object();

				$availableStock = $productDetails->quantity;

				// Check current quantity in cart
				$currentInCart = 0;
				if (!empty($_SESSION["cart_item"][$productDetails->d_id])) {
					$currentInCart = $_SESSION["cart_item"][$productDetails->d_id]["quantity"];
				}

				// Total desired quantity (existing in cart + new request)
				$totalDesired = $currentInCart + $quantity;

				if ($availableStock <= 0) {
					$_SESSION['error'] = "This item is out of stock.";
					header("Location: dishes.php?res_id=" . $_GET['res_id']);
					exit();
				}

				if ($totalDesired > $availableStock) {
					$_SESSION['error'] = "Only $availableStock items available. You already have $currentInCart in your cart.";
					header("Location: dishes.php?res_id=" . $_GET['res_id']);
					exit();
				}

				$itemArray = array(
					$productDetails->d_id => array(
						'title' => $productDetails->title,
						'd_id' => $productDetails->d_id,
						'quantity' => $quantity,
						'price' => $productDetails->price
					)
				);

				if (!empty($_SESSION["cart_item"])) {
					if (array_key_exists($productDetails->d_id, $_SESSION["cart_item"])) {
						$_SESSION["cart_item"][$productDetails->d_id]["quantity"] += $quantity;
					} else {
						$_SESSION["cart_item"] = $_SESSION["cart_item"] + $itemArray;
					}
				} else {
					$_SESSION["cart_item"] = $itemArray;
				}
			}
			break;


		case "remove":
			if (!empty($_SESSION["cart_item"])) {
				foreach ($_SESSION["cart_item"] as $k => $v) {
					if ($productId == $v['d_id'])
						unset($_SESSION["cart_item"][$k]);
				}
			}
			break;

		case "empty":
			unset($_SESSION["cart_item"]);
			break;

		case "check":
			header("location:checkout.php");
			break;
	}
}