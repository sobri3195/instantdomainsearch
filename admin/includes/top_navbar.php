<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
	<div class="navbar-header">
	<a class="navbar-brand" href="./stats.php"><img alt="Instant Domain Search logo" src="<?php echo rootpath(); ?>/style/images/admin_logo.png"/></a>
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	<div class="collapse navbar-collapse navbar-ex1-collapse">	  
		<?php include "side_navbar.php"; ?>
		<ul class="nav navbar-nav navbar-right navbar-user hidden-xs">
			<li>
				<a href="<?php echo rootpath();?>" target="_blank"><i class="fa fa-external-link"></i>&nbsp;Visit Website!</a>
			</li>
			<li class="dropdown user-dropdown">
			    <?php $administrator = mysql_fetch_array(mysqlQuery("SELECT username FROM settings")); ?>
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, <?php echo $administrator['username']; ?> <b class="caret"></b></a>	
					<ul class="dropdown-menu">
						<li><a href="account.php"><i class="fa fa-user"></i> Account Settings</a></li>
						<li class="divider"></li>
						<li><a href="logout.php"><i class="fa fa-power-off"></i> Log Out</a></li>
					</ul>
			</li>
		</ul>
	</div>
</nav>