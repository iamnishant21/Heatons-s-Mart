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
					<img src="/Applications/XAMPP/xamppfiles/htdocs/INVOICE 3333/LOGO2.jpeg" alt="code logo">
					<div class="title_wrap">
						<p class="title bold">Heaton's Mart</p>
						<p class="sub_title">Your Neighbour Grocery</p>
					</div>
				</div>
				<div class="invoice_sec">
					<p class="invoice bold">INVOICE</p>
					<p class="invoice_no">
						<span class="bold">Invoice</span>
						<span>#3488</span>
					</p>
					<p class="date">
						<span class="bold">Date</span>
						<span>28/April/2023</span>
					</p>
				</div>
			</div>
			<div class="bill_total_wrap">
				<div class="bill_sec">
					<p>Bill To</p> 
	          		<p class="bold name">Rohit pandey</p>
			        <span>
			           123 walls street, Townhall<br/>
			           +111 222345667
			        </span>
				</div>
				<div class="total_wrap">
					<p>Total Due</p>
	          		<p class="bold price">USD: $1200</p>
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
					<div class="row">
						<div class="col col_no">
							<p>01</p>
						</div>
						<div class="col col_des">
							<p class="bold">meat</p>
							<p>Lorem ipsum dolor sit.</p>
						</div>
						<div class="col col_price">
							<p>$350</p>
						</div>
						<div class="col col_qty">
							<p>2</p>
						</div>
						<div class="col col_total">
							<p>$700.00</p>
						</div>
					</div>
					<div class="row">
						<div class="col col_no">
							<p>02</p>
						</div>
						<div class="col col_des">
							<p class="bold">Fish</p>
							<p>Lorem ipsum dolor sit.</p>
						</div>
						<div class="col col_price">
							<p>$350</p>
						</div>
						<div class="col col_qty">
							<p>2</p>
						</div>
						<div class="col col_total">
							<p>$700.00</p>
						</div>
					</div>
					<div class="row">
						<div class="col col_no">
							<p>03</p>
						</div>
						<div class="col col_des">
							<p class="bold">Bakery</p>
							<p>Lorem ipsum dolor sit.</p>
						</div>
						<div class="col col_price">
							<p>$120</p>
						</div>
						<div class="col col_qty">
							<p>1</p>
						</div>
						<div class="col col_total">
							<p>$700.00</p>
						</div>
					</div>
					<div class="row">
						<div class="col col_no">
							<p>04</p>
						</div>
						<div class="col col_des">
							<p class="bold">Cake</p>
							<p>Lorem ipsum dolor sit.</p>
						</div>
						<div class="col col_price">
							<p>$350</p>
						</div>
						<div class="col col_qty">
							<p>2</p>
						</div>
						<div class="col col_total">
							<p>$700.00</p>
						</div>
					</div>
					<div class="row">
						<div class="col col_no">
							<p>05</p>
						</div>
						<div class="col col_des">
							<p class="bold">Vegetable</p>
							<p>Lorem ipsum dolor sit.</p>
						</div>
						<div class="col col_price">
							<p>$150</p>
						</div>
						<div class="col col_qty">
							<p>1</p>
						</div>
						<div class="col col_total">
							<p>$700.00</p>
						</div>
					</div>
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
			            <span>$7500</span>
			        </p>
			        <p>
			            <span>Tax Vat 18%</span>
			            <span>$200</span>
			        </p>
			        <p>
			            <span>Discount 10%</span>
			            <span>-$700</span>
			        </p>
			       	<p class="bold">
			            <span>Grand Total</span>
			            <span>$7000.0</span>
						
			        </p>
					<button onclick="payment()">OK</button>
				</div>
			</div>
		</div>
		<div class="footer">
			<p>Thank you and Best Wishes</p>
			<div class="terms">
		        <p class="tc bold">Terms & Coditions</p>
		        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit non praesentium doloribus. Quaerat vero iure itaque odio numquam, debitis illo quasi consequuntur velit, explicabo esse nesciunt error aliquid quis eius!</p>
		    </div>
		</div>
	</div>
</div>

<script>
	function payment(){
		document.location.href = 'paypal/payment.php';
	}
</script>

</body>
</html>