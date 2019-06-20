<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>OTA - Test</title>

    <!-- Bootstrap core CSS-->
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.css"); ?>" />

  </head>

  <body>
  <div class="container">
    <table class="table">
    <thead class="thead-light">
        <tr>
        <th scope="col">Id</th>
        <th scope="col">Origin Airport</th>
        <th scope="col">Destination Airport</th>
        <th scope="col">Airline Code</th>
        <th scope="col">Stock</th>
        <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($data_ticket as $key){ ?>
        <tr>
        <td><?php echo($key->id) ?></td>
        <td><?php echo($key->origin_airport_code . ' ( ' . $key->origin_airport . ' ) ') ?> </td>
        <td><?php echo($key->destination_airport_code . ' ( ' . $key->destination_airport . ' ) ') ?></td>
        <td><?php echo($key->airline_code . ' ( ' . $key->airline_name . ' ) ') ?></td>
        <td><?php echo($key->stock) ?></td>
        <td><a href="<?php echo base_url('/booking/ticket_id/' . $key->id)?>">Book now</a></td>
        </tr>
        <?php }?>
    </tbody>
    </table>
  </div>
  </body>
</html>