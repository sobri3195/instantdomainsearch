<?php
include dirname(__FILE__) . '/includes/header.php';
 
include dirname(__FILE__) . '/includes/header_under.php';

if(isset($_POST['arrayorder']))
{
	$array = $_POST['arrayorder'];
	
	if($_POST['update'] == "update")
	{
	
		$count = 1;
		
		foreach ($array as $idval)
		{
			
			$sql_update = mysqlQuery("UPDATE tlds SET display_order='$count' WHERE id='$idval'");
			
			$count++;
		}
		
	}
	unset($_SESSION['tlds']);
	
}
?>
	<title>Tlds Sortings: <?php echo(get_title());?></title>
	</head>
	<body>
	<?php include "includes/top_navbar.php"; ?>
	<div id="wrapper">
		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12 page-ttl">
					<h1>
						<i class="fa fa-sort"></i> Tlds Sortings <small>Update Tlds Sortings</small>
					</h1>
				</div>
			</div>
			<div class="row mrg-20-top">
				<div class="col-md-8">
					<div class="awidget">
					<div align="right" style="padding-bottom:10px;">
						<a href="whois.php" class="btn btn-success"><i class="fa fa-plus"></i> Add New TLD</a>
					</div>
					<?php
					
					$sql_select=mysqlQuery("SELECT * FROM tlds ORDER BY display_order");
					
					$count=mysql_num_rows($sql_select);
					
					if($count == 0)
					{					
					?>
					<section>
						<div class='container'>
							<div class='row'>
								<div class='col-md-8 content text-center'>				
									<h1 class='sf'>Nothing found!<small>No Pages found.</small></h1>
									<h3 class='sf'>Not to worry. You can add your pages <a href='add_page.php'> Add Page</a></h3>
								</div>
							</div>
						</div>
					</section>					
					<?php					
					} 
					else 
					{ 
						?>
						<div class="awidget-body">
							<div class="table_header" style="width:100%;line-height: 1px">
								<div style="width:35%;float:left;white-space: nowrap">Tlds Name</div>
										<div id="smalli" class="hidden-xs" style="width:45%;float:left;text-align: center;">Action</div>
										<div id="smalli" class="visible-xs" style="width:65%;float:left;text-align: center;">Action</div>
										<div class="hidden-xs" style="width:20%;float:left;text-align: center">Status</div>
							</div>
							<div id="list">
								<ul>
								<?Php 
                                $i =1;								
								while($row=mysql_fetch_array($sql_select))
								{
								
									$id     = stripslashes($row['id']);
									
									$text   = stripslashes($row['tld']);
								
									$stat   = stripslashes($row['status']);
									
									$edit   = '<a href="editwhois.php?id=' . $row['id'] . '" title="Edit ' . $text . '" class="small">Edit</a>';

									$delete = '<a class="small" data-toggle="modal" onclick="delete_pages('.$row['id'].')" id="del" class="open-dialog" href="#delete_modal_' . $row['id'] . '" title="Delete ' . $text . '" data-id='. $row['id'] . '>Delete</a>';
									
									?>
									<li id="arrayorder_<?php echo $id; ?>">
										<div class="small" style="width:100%;float:left;line-height: 1px">
											<div style="width:35%;float:left;line-height: 1px;white-space: nowrap">
												<?php echo $text; ?>
											</div>
											<div class="small smalli hidden-xs" style="width:45%;float:left;line-height: 1px;text-align: center; font-size:1.1em;">
												<?php 
												echo ($edit . " - " . $delete);
												?>
											</div>
											<div class="small smalli visible-xs" style="width:65%;float:left;line-height: 1px;text-align: center; font-size:1.1em;">
												<?php
												echo ($edit . " - " . $delete);
												?>
											</div>
											<div class="hidden-xs" style="width:20%;float:left;line-height: 1px;text-align: center">
												<?php if($stat == 0) { echo ('OFF'); } else { echo ('ON'); } ?>
											</div>
										</div>
									</li>
								<?php 
								$i++;
							} 
				            ?>
								</ul>
							</div>
							<div class="clearfix"></div>
					    </div>
					<?php
					} 
					?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	$(document).ready(function(){
		$(function(){
			$("#list ul").sortable({ opacity: 0.8, cursor: 'move', update: function(){
				var order = $(this).sortable("serialize") + '&update=update';
				$.post("tld_sorting.php", order);
			}                                                                 
			});
		});
	});   
	function delete_pages(id)
	{
		swal({   title: "Are you sure?",   text: "Do you really want to delete this Tld?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){
			$.ajax({
				type: "POST",
				url: "action.php",
				data: {id:id,'deleteTld':'deleteTld'},
				cache: false,
				success: function(result)
				{	
					swal("Deleted!", "Your Tld have been deleted successfully!", "success");
					var delay=1000;
					setTimeout(function(){
						window.location="<?php echo rootpath(); ?>/admin/tld_sorting.php";
					},delay); 
				}
			});	
		});
	}
	</script>
	</body>
</html>