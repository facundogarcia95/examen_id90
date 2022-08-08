<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Hotels</h3>
    <?php 
      for ($i=0; $i < count($search["errors"]) ; $i++) { 
        echo '<div class="alert alert-danger" role="alert">
                '.$search["errors"][$i].'
              </div>';
      }
    ?>
  </div>
  <div class="box-body">
    <table class="table table-bordered">
      <tbody>
        <tr>
          <td style='width:25px;'>#</td>
          <td>Name</td>
          <td>Location</td>
          <td>Chain</td>
          <td>Reservation</td>
          <td>Star Rating</td>
          <td>Total</td>
        </tr>
        <?php 
        if($search["data"]){
          foreach ($search["data"]["hotels"] as $hotel) {
            ?>
            <tr>
              <td style='width:25px;'><?= $hotel["id"] ?></td>
              <td><?= isset($hotel["name"])? $hotel["name"]: null ?></td>
              <td><?= isset($hotel["location"]["city"])? $hotel["location"]["city"] : null ?></td>
              <td><?= isset($hotel["chain"])? $hotel["chain"] : null ?></td>
              <td><?= isset($hotel["checkin"])? $hotel["checkin"] : null ?> to <?= isset($hotel["checkout"])? $hotel["checkout"] : null ?></td>
              <td><?= isset($hotel["star_rating"]) ? $hotel["star_rating"] : null ?></td>
              <td><?= isset($hotel["total"]) ? $hotel["total"] : null ?> USD</td>
            </tr>
            <?php
          }
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

