<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/dream_shops/core/init.config.php';
  if(!is_logged_in()){
      login_error_check();
  }
  if(!permission()){
    permission_error();
  }
	$i = 1;
	$total = 0;
	$sub_total = 0;
	$grand_total = 0;
	$itemQuantity = 0;
	$x = 1;

	$date = date("d-m-Y");
	$pdf = new FPDF('p','mm','A4');

	$pdf->AddPage();
	$pdf->SetFont("Arial","B","14");
  $pdf->Cell(189,5,'',0,1);

  $pdf->Cell(130,5,"Online Express Store",0,0);
  $pdf->Cell(59,5,"Invoice",0,1);//End of line

  //SET FONT TO ARIAL, REGULAR, 12PT
  $pdf->SetFont("Arial",'',12);

  $pdf->Cell(130, 5, 'Cairo Road, Society Bulding, Room 12',0,0);
  $pdf->Cell(59, 5, '',0,1);

  $pdf->Cell(130, 5, 'Lusaka, Zambia, 10101',0,0);
  $pdf->Cell(25, 5, 'Date',0,0);
  $pdf->Cell(34, 5, ': '.$date, 0,1);

  $pdf->Cell(189, 5, 'Phone: +260976245430',0,1);
  // $pdf->Cell(25, 5, 'Invoice ID     :',0,0);
  // $pdf->Cell(34, 5, '  '.$customer['invoice'],0,1);

  $pdf->Cell(130, 5, 'Email: onlineexpress@info.com',0,0);
  $pdf->Cell(25, 5, '',0,1);
  // $pdf->Cell(34, 5, '  '.$customer['id'],0,1);


  $pdf->Cell(189,5,'',0,1);
  $pdf->SetFont("Arial","B","12");
  $pdf->Cell(5, 5, '#',1,0);
  $pdf->Cell(55, 5, 'Customer Name',1,0,'C');
  $pdf->Cell(50, 5, 'Transaction ID',1,0,'C');

  $pdf->Cell(45, 5, 'Trans. Date',1,0,'C');
  $pdf->Cell(34, 5, 'Amount($)',1,1,'C');

	$transactions = $db->query("SELECT * FROM transactions");
	while($transaction = mysqli_fetch_assoc($transactions)) {
      			$pdf->SetFont("Arial","","12");
            $pdf->Cell(5,6,$x,1,0);
            $pdf->Cell(55,6,$transaction['customer_name'],1,0,'L');
            $pdf->Cell(50,6,$transaction['transaction_id'],1,0,'C');

            $pdf->Cell(45,6,$transaction['date'],1,0,'C');
            $pdf->Cell(34,6,$transaction['grand_total'],1,1,'C');
            $x++;

            $grand_total += $transaction['grand_total'];
            $grand_total = (float) $grand_total;
	}
  $pdf->Cell(189,5,'',0,1);
  $pdf->Cell(5,6,'',0,0);
  $pdf->Cell(55,6,'',0,0,'L');
  $pdf->Cell(50,6,'',0,0,'C');
  $pdf->SetFont("Arial","B","12");
  $pdf->Cell(45,6,'Total in Wallet',1,0,'C');
  $pdf->Cell(34,6,$grand_total,1,1,'C');
  $pdf->Output();
