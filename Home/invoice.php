<?php
	session_start();
	include('../connection.php');

	echo "\n".$_SESSION['slot_id'] ;
	echo "\n".$_SESSION['cart_id'] ;
	echo "\n".$_SESSION['total'] ;

	unset($_SESSION['order_id']);

	$sql_order = 'SELECT * FROM "ORDER" WHERE SLOT_ID = :slot_id AND CART_ID = :cart_id AND TOTAL_AMOUNT = :total_amount';
	$stmts = oci_parse($conn, $sql_order);
	oci_bind_by_name($stmts , ":slot_id" , $_SESSION['slot_id']);
	oci_bind_by_name($stmts, ":cart_id" , $_SESSION['cart_id']);
	oci_bind_by_name($stmts , ":total_amount" ,$_SESSION['total']);
	oci_execute($stmts);
	while($data = oci_fetch_array($stmts)){
		$order_id = $data['ORDER_ID'];
		$invoice_no = $data['INVOICE_NO'];
		$order_date = $data['ORDER_DATE'];
	}
	
	$_SESSION['order_id'] = $order_id;

		$order_sql = "SELECT * FROM CART_PRODUCT WHERE CART_ID = :cart_id";
		$stmt = oci_parse($conn, $order_sql);
		oci_bind_by_name($stmt, ":cart_id", $_SESSION['cart_id']);
		oci_execute($stmt);

        while ($data = oci_fetch_array($stmt, OCI_ASSOC)) {
          $product_id = $data['PRODUCT_ID'];
          $quantity = $data['QUANTITY'];

          $sql = "INSERT INTO ORDER_PRODUCT(ORDER_ID,PRODUCT_ID,ORDER_QUANTITY) VALUES (:order_id,:product_id,:quantity)";
          $stid = oci_parse($conn, $sql);
          oci_bind_by_name($stid, ":order_id", $_SESSION['order_id']);
          oci_bind_by_name($stid, ":product_id", $product_id);
          oci_bind_by_name($stid, ":quantity", $quantity);
          oci_execute($stid);
		}

	$delcart = "DELETE FROM CART_PRODUCT WHERE CART_ID = :cart_id";
	$delstmt = oci_parse($conn,$delcart);
	oci_bind_by_name($delstmt , ":cart_id" , $_SESSION['cart_id']);
	oci_execute($delstmt);

	$usersql = 'SELECT * FROM "USER" WHERE USER_ID = :user_id';
	$userstmt = oci_parse($conn,$usersql);
	oci_bind_by_name($userstmt , ":user_id" , $_SESSION['user_ID']);
	oci_execute($userstmt);
	while($data = oci_fetch_array($userstmt)){
		$firstname = $data['FIRSTNAME'];
		$lastname = $data['LASTNAME'];
		$email = $data['EMAIL_ADDRESS'];
		$phone = $data['PHONE_NUMBER'];
		$address = $data['ADDRESS'];
	} 

include('paypal/payment.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>Invoice Template Design</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<div class="wrapper">
	<div class="invoice_wrapper">
		<div class="header">
			<div class="logo_invoice_wrap">
				<div class="logo_sec">
					<!-- <img src="/Applications/XAMPP/xamppfiles/htdocs/INVOICE 3333/Heaton's Mart.png"> -->
					<div class="title_wrap">
						<p class="title bold">Heaton's Mart</p>
						<p class="sub_title">Your Neighbour Grocery</p>
					</div>
				</div>
				<div class="invoice_sec">
					<p class="invoice bold">INVOICE</p>
					<p class="invoice_no">
						<span class="bold">Invoice</span>
						<span>#<?php echo $invoice_no; ?></span>
					</p>
					<p class="date">
						<span class="bold">Date</span>
						<span><?php echo $order_date; ?></span>
					</p>
				</div>
			</div>
			<div class="bill_total_wrap">
				<div class="bill_sec">
					<p>Bill To</p> 
	          		<p class="bold name"><?php echo $firstname . " ".$lastname; ?></p>
			        <span>
					<?php echo $email; ?><br/>
			           <?php echo $address; ?><br/>
			           <?php echo $phone; ?>
			        </span>
				</div>

			</div>
		</div>
		<div class="body">
			<div class="main_table">
				<div class="table_header">
					<div class="row">
						<div class="col col_no">NO.</div>
						<div class="col col_des">ITEM DESCRIPTION</div>
						<div class="col col_price">PRICE</div>
						<div class="col col_qty">QTY</div>
						<div class="col col_total">TOTAL</div>
					</div>
				</div>
				<div class="table_body">

				<?php 
					
					$count = 0;
					$prodsql ="SELECT op.*, p.*
					FROM ORDER_PRODUCT op
					JOIN PRODUCT p ON op.PRODUCT_ID = p.PRODUCT_ID
					WHERE op.ORDER_ID = :order_id";

					$stmts = oci_parse($conn,$prodsql);

					oci_bind_by_name($stmts , ":order_id" , $order_id);
					oci_execute($stmts);
					
					while($row = oci_fetch_array($stmts)){
						$productprice = 0;
						$totalprice = 0;
						$count += 1;
						$quantity = (int)$row['ORDER_QUANTITY'];
						$product_price = $row['PRODUCT_PRICE'];
						
						if (!empty($row['DISCOUNT_ID'])) 
						{
							$sql = 'SELECT DISCOUNT_PERCENT FROM "DISCOUNT" WHERE DISCOUNT_ID = :disc_id';
							$stmt = oci_parse($conn, $sql);
							oci_bind_by_name($stmt, ":disc_id", $row['DISCOUNT_ID']);
							oci_execute($stmt);
							while ($data = oci_fetch_array($stmt, OCI_ASSOC)) {
								$discount = (int)$data['DISCOUNT_PERCENT'];
								$discount_price = $product_price - $product_price * ($discount / 100);
								$productprice =  $quantity * $discount_price;
								$totalprice += $quantity * $discount_price;
							}
							} else {
								$discount_price = $product_price;
								$productprice =  $quantity * $discount_price;
								$totalprice += $quantity * $discount_price;
							}

						echo "
						<div class='row'>
						<div class='col col_no'>
							<p>$count</p>
						</div>
						<div class='col col_des'>
							<p class='bold'>".$row['PRODUCT_NAME']."</p>
						</div>
						<div class='col col_price'>
							<p>&pound; ".$product_price."</p>
						</div>
						<div class='col col_qty'>
							<p>".$quantity."</p>
						</div>
						<div class='col col_total'>
							<p>&pound; ".$totalprice."</p>
						</div>
					</div>";
					}
					
				?>

				</div>
			</div>
			<div class="paymethod_grandtotal_wrap">
				<div class="paymethod_sec">
					<p class="bold">Payment Method</p>
					<p>PAYPAL</p>
				</div>
				<div class="grandtotal_sec">
			        <p class="bold">
			            <span>SUB TOTAL</span>
			            <span><?php echo $_SESSION['total'];?></span>
			        </p>
			        <p>
			            <span>Tax Vat 13%</span>
			            <span>
							<?php 
								$amount = $_SESSION['total'];
								$tax = 13;
								$taxamount = $_SESSION['total'] * 0.13;
								echo $taxamount;
							?>
						</span>
			        </p>
			       
			       	<p class="bold">
			            <span>Grand Total</span>
			            <span><?php 
								unset($_SESSION['finalamount']);
									$finalamount =$taxamount + $_SESSION['total'];
									echo $finalamount;
									$_SESSION['finalamount'] = number_format($finalamount,2);
									
							 ?>
						</span>
						
			        </p>
					<!-- for paypal -->
					<form action="<?php echo PAYPAL_URL; ?>" method='post'>
						<div class="place-btn">
							
							<input type="hidden" name="business" value="<?php echo PAYPAL_ID; ?>">

							<input type="hidden" name="amount" value="<?php echo $finalamount; ?>">
							
							<input type="hidden" name="currency_code" value="<?php echo PAYPAL_CURRENCY; ?>">
						<!-- Specify a Buy Now button. -->
							<input type="hidden" name="cmd" value="_xclick">
							<!-- Specify URLs -->
							<input type="hidden" name="return" value="<?php echo PAYPAL_RETURN_URL; ?>">
							<input type="hidden" name="cancel_return" value="<?php echo PAYPAL_CANCEL_URL; ?>">

							<input type="submit" name="submit" value="Payment By Paypal" />
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="footer">
			<p>Thank you and Best Wishes</p>
			<div class="terms">
		        <p class="tc bold">Terms & Coditions</p>
				<p>At HeatonsMart, we are your ultimate destination for all your grocery needs. We bring together 
                  a delightful selection of bakery products, fresh meats from our butcher shop, a wide variety of fish, 
                  and an extensive range of grocery items. With HeatonsMart, you can conveniently shop for all your kitchen essentials
                  in one place.  Join us at HeatonsMart and experience the convenience, quality, and variety that we have to offer. Start 
                  your grocery shopping journey with us today!
        </p>
		    </div>
		</div>
	</div>
</div>

</body>
</html>