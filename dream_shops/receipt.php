<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/dream_shops/core/init.config.php';
	$i = 1;
	$total = 0;
	$sub_total = 0;
	$grand_total = 0;
	$itemQuantity = 0;
	$x = 1;

	$get = $db->query("SELECT * FROM orders WHERE `cart_id`='$cart_id' ");
    $rows = mysqli_num_rows($get);
    if($rows <= 0) {
      header("Location: cart.php");
    }

	$date = date("d-m-Y");
	$pdf = new FPDF('p','mm','A4');

	$pdf->AddPage();
	$pdf->SetFont("Arial","B","14");

	if(!empty($cart_id)){

			$cust_details = $db->query("SELECT * FROM orders WHERE `cart_id` = {$cart_id} LIMIT 1");
			$customer = mysqli_fetch_assoc($cust_details);
			//DUMMY CELLS TO CREATE A PADDING FROM THE TOP
			$pdf->Cell(189,10,'',0,1);
			$pdf->Cell(130,5,"Online Express Store",0,0);
			$pdf->Cell(59,5,"Invoice",0,1);//End of line

			//SET FONT TO ARIAL, REGULAR, 12PT
			$pdf->SetFont("Arial",'',12);

			$pdf->Cell(130, 5, 'Cairo Road, Society Bulding, Room 12',0,0);
			$pdf->Cell(59, 5, '',0,1);

			$pdf->Cell(130, 5, 'Lusaka, Zambia, 10101',0,0);
			$pdf->Cell(25, 5, 'Date',0,0);
			$pdf->Cell(34, 5, ': '.$date, 0,1);

			$pdf->Cell(130, 5, 'Phone: +260976245430',0,0);
			$pdf->Cell(25, 5, 'Invoice ID     :',0,0);
			$pdf->Cell(34, 5, '  '.$customer['invoice'],0,1);

			$pdf->Cell(130, 5, 'Email: onlineexpress@info.com',0,0);
			$pdf->Cell(25, 5, 'Customer ID : ',0,0);
			$pdf->Cell(34, 5, '  '.$customer['id'],0,1);

			//DUMMY VERTICAL CELL AS A VERTICAL SPACER
			$pdf->Cell(189, 10, '',0,1);
			//SHIPPING DETAILS
			$pdf->SetFont("Arial","B","12");
			$pdf->Cell(100, 10, "Delivering To:",0,1);

			$pdf->SetFont("Arial","","12");
			//Customer details
			$pdf->Cell(50,5,"Customer Name:",0,0);
			$pdf->Cell(89,5,$customer['fullname'],0,1);
			$pdf->Cell(50,5,"Contact Number:",0,0);
			$pdf->Cell(89,5,$customer['phone'],0,1);
			$pdf->Cell(50,5,"Email Address:",0,0);
			$pdf->Cell(89,5,$customer['email'],0,1);

			$pdf->Cell(50,5,"Province:",0,0);
			$pdf->Cell(89,5,$customer['province'],0,1);

			$pdf->Cell(50,5,"City:",0,0);
			$pdf->Cell(89,5,$customer['city'],0,1);

			$pdf->Cell(50,5,"Street Address:",0,0);
			$pdf->Cell(89,5,$customer['address'],0,1);

			$pdf->Cell(189,5,'',0,1);

			$pdf->Cell(189,5,'',0,1);
			$pdf->SetFont("Arial","B","12");
			$pdf->Cell(5, 5, '#',1,0);
			$pdf->Cell(95, 5, 'Description',1,0);
			$pdf->Cell(30, 5, '       QTY',1,0);
			$pdf->Cell(59, 5, '               Price(K)',1,1);

			$pdf->SetFont("Arial",'',12);

			$sql = $db->query("SELECT * FROM cart WHERE id = {$cart_id}");
			$result = mysqli_fetch_assoc($sql);
			$items_decode = json_decode($result['items'], true);
			//////////////////////////////////////////////////////////////
			foreach($items_decode as $item) {
					$item_id = $item['id'];
					$sql2 = $db->query("SELECT * FROM products WHERE id = {$item_id}");
					$product = mysqli_fetch_assoc($sql2);
					/////////////////////////////////////////////////////////
					$sizesArray = explode(',',$product['sizes']);
					foreach($sizesArray as $sizeString){
						$string = explode(':',$sizeString);

						if($string[0] == $item['size']){
							$available = $string[1];

							$itemQuantity = $itemQuantity + $item['quantity'];
							$total = $item['quantity'] * $product['price'];
							$sub_total = $sub_total + $total;
							$tax = TAX * $sub_total;
							$tax = number_format($tax, 2);
							$grand_total = $tax + $sub_total;
						}
					}

					$pdf->Cell(5,5,$x,1,0);
					$pdf->Cell(95, 5, $product['title'],1,0,'C');
					$pdf->Cell(30, 5, $item['quantity'].'',1,0,'C');
					$pdf->Cell(59, 5, $product['price']  * $item['quantity'].'',1,1,'C');
					$x++;
		}

		//TAX CHARGE
		//$pdf->Cell(189, 10, '',0,1); //DUMMY CELL
		
		$pdf->Cell(189, 5, '',0,1);
		$pdf->SetFont("Arial","B",12);
		$pdf->Cell(100,5, '',0,0);
		$pdf->Cell(30, 5, 'VAT @ 5.0%',1,0);
		$pdf->Cell(59, 5, '              '.$tax.'',1,1);

		//TOTAL PRICE
		//$pdf->Cell(189, 10, '',0,1);
		$pdf->SetFont("Arial","B",12);
		$pdf->Cell(100, 5, '',0,0);
		$pdf->Cell(30, 5, 'Total Price',1,0);
		$pdf->Cell(59, 5, '             '.$grand_total.'',1,1);

		//DUMMY CELLS TO CREATE SOME SPACES
		$pdf->Cell(189, 5, '',0,1);
		$pdf->Cell(189, 5, '',0,1);
		$pdf->Cell(189, 5, '',0,1);
		$pdf->Cell(189, 5, '',0,1);
		$pdf->Cell(189, 5, '',0,1);
		$pdf->Cell(189, 5, '',0,1);
		$pdf->Cell(189, 5, '',0,1);
		$pdf->Cell(189, 5, '',0,1);
		$pdf->Cell(189, 5, '',0,1);
		$pdf->Cell(189, 5, '',0,1);


		$pdf->SetFont('Arial','',12);
		$pdf->Cell(94.5, 5, $customer['fullname'],0,0);
		$pdf->Cell(94.5, 5, 'Delivering Agent Name:',0,1);

		$pdf->Cell(94.5, 5, '....................................',0,0);
		$pdf->Cell(94.5, 5, '....................................',0,1);

		$pdf->Cell(94.5, 5, 'Signature',0,0);
		$pdf->Cell(94.5, 5, 'Signature',0,1);

		$pdf->Cell(94.5, 5, 'Date of delivery:...............................',0,0);
		$pdf->Cell(94.5, 5, 'Date of delivery:...............................',0,1);

//SHOW PDF FILE
$pdf->Output();

	}

else {
	header("Location: cart.php");
}
