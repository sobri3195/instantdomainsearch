<?php
include dirname(__FILE__) . '/includes/header.php';
 
include dirname(__FILE__) . '/includes/header_under.php'; 

if($_SESSION['type'] == 'last_date_check' && $_SESSION['order'] == 'ASC')
{
	$selection ='date_asc';
	$value = 'Oldest';
}
else if($_SESSION['type'] == 'domain' && $_SESSION['order'] == 'ASC')
{
	$selection ='domain_asc';
	$value = 'A to Z (Ascending)';
}
else if($_SESSION['type'] == 'domain' && $_SESSION['order'] == 'DESC')
{
	$selection ='domain_desc';
	$value = 'Z to A (Descending)';
}
else
{
	$selection ='date_desc';
	$value = 'Newest';
}
?>
	<title>Domains Settings: <?php echo (get_title());?></title>
	<script src="<?php echo rootpath()?>/admin/style/js/jquery-1.10.2.js"></script> 
	</head>
	<body>
	<?php 
	include "includes/top_navbar.php"; 
	include "style/js/javascript.php"; 	
	?>
	<div id="wrapper">
		<div id="page-wrapper">
			<div class="row page-ttl">
				<div class="col-lg-12">
					<h1><i class="fa fa-list"></i> Domains <small>Update Domains</small></h1>
				</div>
			</div><!-- /.row -->
			<ol class="page-content">
				<div class="margin_sides">
					<div class="row">
						<div class="pull-right">
							<div class="form-group">
								<div id="order_in_name" class="btn-group">
								<select  class="btn btn-default dropdown-toggle btn-sm" onchange="search_function(this);"> 
									<option selected = "selected" value = "<?php echo $selection; ?>"><?php echo $value;?></option>
									<?php if($selection != "date_desc"){ ?>
									<option value = "date_desc">Newest</option>
									<?php }if($selection != "date_asc"){ ?>
									<option value = "date_asc">Oldest</option>
									<?php }if($selection != "domain_asc"){ ?>
									<option value = "domain_asc">A to Z (Ascending)</option>
									<?php }if($selection != "domain_desc"){ ?>
									<option value = "domain_desc">Z to A (Descending)</option>
									<?php } ?>
								</select>
								</div>
							</div>
						</div>
						<div class="pull-right">
							<div class="input-group">
								<div class="input-group searchbar-size">
									<?php 
									if(isset($_GET['domain']))
									{
									?>
										<input type="text" placeholder="Search..." class="form-control input-sm domain" value="<?php echo $_GET['domain']?>" name="domain" id="domain" required/>
									<?php 
									} 
									else
									{ 
									?>
										<input type="text" placeholder="Search..." class="form-control input-sm domain" name="domain" id="domain" required/>
									<?php
									} 
									?>
									<span onclick="finish_search()"; style="display:none" id="cros_search" class="btn btn-search-cancel"><i class="fa fa-times"></i></span>
									<span class="input-group-btn" style="padding-right: 4px;">
										<button id="search_domain"  class="btn btn-primary btn-sm" type="button"><i class="fa fa-search icon-size"></i></button>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div id="results" class="table-dmns">
					</div>
				</div>
			</ol>
		</div>
	</div>
	<script>
		$(function () { $("[data-toggle='tooltip']").tooltip(); });
	</script>
	<button class="notify-without-image" style="display: none;" id="deletevideo"></button>
	</body>
</html>