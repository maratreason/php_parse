<?php
  include 'script.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Parse Data to Database</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <style>
    body {
      margin: 30px 0;
    }
    table {
      margin-top: 30px;
    }
    form {
      width: 200px;
      display: inline-block;
      margin-right: 20px;
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <?php
      if(isset($_POST['remove'])) {
        $sql->clearTable('banks');
        $banks = [];
      }

      if(isset($_POST['add'])) {
        $sql->clearTable('banks');
        get_content('https://cbu.uz/ru/credit-organizations/banks/head-offices/', $sql);
      }

      $banks = $sql->fetchAll('banks');
    ?>

    <form method="POST">
      <input type="submit" class="btn btn-success" name="add" value="Залить в базу и показать" />
    </form>
    <form method="POST">
      <input type="submit" class="btn btn-danger" name="remove" value="Очистить базу" />
    </form>

    <div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Address</th>
            <th scope="col">Phone</th>
            <th scope="col">Hope_Phone</th>
            <th scope="col">License_Number</th>
            <th scope="col">INN</th>
            <th scope="col">Email</th>
            <th scope="col">Site</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($banks as $bank) {
            ?>
            <tr>
              <th><?=$bank['id_bank']?></th>
              <th><?=$bank['name']?></th>
              <th><?=$bank['address']?></th>
              <th><?=$bank['phone']?></th>
              <th><?=$bank['hope_phone']?></th>
              <th><?=$bank['no_license']?></th>
              <th><?=$bank['identify_num']?></th>
              <th><?=$bank['email']?></th>
              <th><?=$bank['site']?></th>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>