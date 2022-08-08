<!--=====================================
USUARIOS
======================================-->	

<!-- user-menu -->
<li class="dropdown user user-menu">

	<!-- dropdown-toggle -->
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		
		<span class="hidden-xs"><?php echo $_SESSION["username"]; ?></span>
	
	</a>
	<!-- dropdown-toggle -->

	<!-- dropdown-menu -->
	<ul class="dropdown-menu">

		<li class="user-header">

			<p>
			<?php echo $_SESSION["username"]; ?>
			<h4 style="color:white"><?php echo $_SESSION["airline"]; ?></h4>
			</p>
		
		</li>

		<li class="user-footer">
			
			<div class="pull-right">
			
				<a href="out" class="btn btn-default btn-flat">Logout</a>
			
			</div>

		</li>

	</ul>
	<!-- dropdown-menu -->

</li>
<!-- user-menu -->