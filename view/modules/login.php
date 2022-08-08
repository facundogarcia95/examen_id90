<?php 
  $airlines = ID90Api::getAirlines();

?>
<div class="login-box">

  <div class="login-box-body">
    
    <p class="login-box-msg">Login</p>

    <form  method="post">

    <div class="form-group has-feedback">
      <label class="form-label-control">Airline</label>
        <select name="airline" class="form-control" required>
          <option value="" selected disabled>Seleccione...</option>
          <?php 
            foreach ($airlines as $airline) { 
          ?>
              <option value="<?= $airline["name"] ?>"> <?= $airline["display_name"]?></option>
          <?php
            }
          ?>
        </select>
      </div>

      <div class="form-group has-feedback">
      <label class="form-label-control">Username</label>
        <input type="text" class="form-control" placeholder="Username" name="username" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
      <label class="form-label-control">Password</label>
        <input type="password" class="form-control" placeholder="Password" name="password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="checkbox" class="form-check" name="remember_me">
         <span class="pl-4">Remember Me</span>
      </div>

      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
        </div>
        <!-- /.col -->
      </div>

    <?php

    $login = new ControladorAdministradores();
    $login -> ctrLoginAdministrador();

    ?>

    </form>

  </div>
  <!-- /.login-box-body -->

</div>
<!-- /.login-box -->
