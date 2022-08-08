
<div class="content-wrapper">


  <section class="content-header">
    <h1>
      Index
      <small>Search Hotels</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="index"><i class="fa fa-dashboard"></i> Index</a></li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-4">
        <form method="POST">
          <div class="col-sm-12">
            <div class="form-group">
              <label>Destination:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-plane"></i>
                </div>
                <input type="text" class="form-control pull-right" value="<?= (isset($_POST["destination"]) ? $_POST["destination"] : null) ?>" name="destination" required>
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
              <label>Date Range:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" value="<?= (isset($_POST["reservation"]) ? $_POST["reservation"] : null) ?>" name="reservation" id="reservation">
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
              <label>Guests:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-users"></i>
                </div>
                <input type="number" min="1" max="4" value="<?= (isset($_POST["guests"]) ? $_POST["guests"] : 1) ?>" class="form-control pull-right" name="guests" required>
              </div>
            </div>
          </div>
          <div class="col-sm-12">
            <button type="submit" name="search" value="true" class="btn btn-primary btn-lg btn-block">Search</button>
          </div>
        </form>
      </div>
      <div class="col-sm-8">
        <?php 
            $destination = new DestinationController();
            $destination->viewSearchDestination();
        ?>
      </div>
    </div>
  </section>

</div>

<script>
  $('#reservation').daterangepicker({
    minDate: moment().toDate(),
    locale: {
      format: 'DD/MM/Y'
    }
  })
</script>
