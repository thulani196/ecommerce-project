<?php
  require_once '../core/init.config.php';
    if(!is_logged_in()){
        login_error_check();
    }
    if(!permission()){
      permission_error();
    }
    include 'includes/header.php';
    include 'includes/navigation.php';

    $sql = $db->query("SELECT * FROM transactions ");
    $rCount = mysqli_num_rows($sql);
    $x = 1;
    $grand_total = 0;
?>

  <div class="container">
    <div class="page-header text-center">
      <h3>Completed Transactions Summary</h3>
    </div>
    <div class="row">
      <div class="col-md-8">
        <?php if($rCount > 0): ?>
        <a href="summary_report.php" target="_blank" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-print"></span> Generate Report</a><br /><br />
      <?php endif; ?>
        <table class="table table-condensed table-striped table-bordered">
          <thead class="w3-blue">
            <tr>
              <th>#</th>
              <th>Customer Name</th>
              <th>Transaction ID</th>
              <th>Amount (<b>$</b>)</th>
              <th>Transaction Date</th>
            </tr>
          </thead>
          <tbody>
            <?php while($transaction = mysqli_fetch_assoc($sql)): ?>
              <tr>
                <td><?= $x;  ?></td>
                <td><?=$transaction['customer_name']; ?></td>
                <td><?=$transaction['transaction_id']; ?></td>
                <td><?='$'.$transaction['grand_total']; ?></td>
                <td><?=$transaction['date']; ?></td>
              </tr>
              <?php $x++; ?>

              <!-- COMPUTER THE OVERALL GRAND TOTAL! -->
              <?php
                $grand_total += $transaction['grand_total'];
                $grand_total = (float) $grand_total;
              ?>
            <?php endwhile; ?>

          </tbody>
        </table>
      </div>

      <div class="col-md-4">
        <h3 class="">Total in Wallet:</h3>
        <div class="w3-tag w3-jumbo w3-green w3-card-8 w3-round">
            <h1><?= '$'.$grand_total; ?></h1>
        </div>
      </div>
    </div>
  </div>
