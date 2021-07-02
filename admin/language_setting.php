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
			
			$sql_update = mysqlQuery("UPDATE language SET display_order='$count' WHERE id='$idval'");
			
			$count++;
		}
		unset($_SESSION['language_set']);
		unset($_SESSION['reset_language']);
		
	}
	
}
?>
	<title>Language Settings: <?php echo(get_title()) ?></title>
    </head>
    <body>
    <?php include "includes/top_navbar.php"; ?>
	<div id="wrapper">
	    <div id="page-wrapper">
			<div class="row page-ttl">
				<div class="col-lg-12">
					<h1>
						<i class="fa fa-language"></i> Language Settings <small>Sorting Language / Edit Language / Add New Language</small>
					</h1>
				</div>
			</div>
			<ol class="page-content">
				<div class="margin_sides col-md-8">
					<?php 
					$id =trim(mres($_GET['id']));
					$array = mysql_fetch_array(mysqlQuery("SELECT id  FROM language WHERE display_order = '$id'"));	
					if(isset($array['id']))
					{ 
					?>
					<div class="alert alert-success alert-dismissable col-md-12">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-check-square-o"></i> <?php echo $lang_array['add_language'];?>
					</div>
					<?php 
					} 
					?>
					<div class="row">
						<div id="language_status">
							<div class="form-group">
								<a href="add_language.php" class="btn btn-success pull-right panel-btn-top"><i class="fa fa-plus"></i> Add New Language</a>
							</div>
							<div class="clearfix"></div>
							<?php
							$sql_select=mysqlQuery("SELECT * FROM language ORDER BY display_order");

							$count=mysql_num_rows($sql_select);

							if($count == 0)
							{					
							?>
							<div class="panel panel-success">
								<div class="panel-body page-list-setting">
									<div class='col-md-12 content text-center'>				
										<h1 class='sf'>Nothing found!</h1>
										<h3 class='sf'>Not to worry. You can add your Language</h3>
									</div>
								</div>	
							</div>					
							<?php					
							} 
							else 
							{ 
							?>
							<div class="awidget-body">
								<div class="table_header" style="width:100%;line-height: 1px">
									<div style="width:50%;float:left">Language</div>
									<div id="smalli" class="hidden-xs" style="width:25%;float:left;text-align: center;">Action</div>
									<div id="smalli" class="visible-xs" style="width:50%;float:left;text-align: center;">Action</div>
									<div class="hidden-xs" style="width:25%;float:left;text-align: center">Status</div>
								</div>
								<div id="list">
									<ul>
										<?Php 
										$i =1;								
										while($row=mysql_fetch_array($sql_select))
										{
										$id     = stripslashes($row['id']);

										$language   = stripslashes($row['lang_name']);

										$stat   = stripslashes($row['status']);

										?>
										<li id="arrayorder_<?php echo $id; ?>">
											<div class="small" style="width:100%;float:left;line-height: 1px">
												<div style="width:50%;float:left;line-height: 1px">
													<?php echo $language; ?>
												</div>
												<div class="small smalli hidden-xs" style="width:25%;float:left;line-height: 1px;text-align: center; font-size:1.1em;">
													<a href="edit_language.php?id=<?php echo $row['id'];?>" title="Edit <?php echo $language;?>" class="small">Edit</a>
                                                    <?php if($count > 1){ ?>													
													- 
													<a class="small"  onclick="delete_language('<?php echo $row['lang_name']; ?>','<?php echo $row['lang_file']; ?>')" title="Delete <?php echo $language; ?>">Delete</a>
													<?php } ?>
												</div>
												<div class="small smalli visible-xs" style="width:50%;float:left;line-height: 1px;text-align: center; font-size:1.1em;">
													<a href="edit_language.php?id=<?php echo $row['id'];?>" title="Edit <?php echo $language;?>" class="small">Edit</a> 
													- 
													<?php if($count > 1){ ?>
													<a class="small"  onclick="delete_language('<?php echo $row['lang_name']; ?>','<?php echo $row['lang_file']; ?>')" title="Delete <?php echo $language; ?>">Delete</a>
													<?php } ?>
												</div>
												<div class="hidden-xs" style="width:25%;float:left;line-height: 1px;text-align: center">
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
			</ol>
	    </div>
	</div>
	<script type="text/javascript">
	$(document).ready(function(){
		$(function(){
			$("#list ul").sortable({ opacity: 0.8, cursor: 'move', update: function(){
				var order = $(this).sortable("serialize") + '&update=update';
				$.post("language_setting.php", order);
			}                                                                 
			});
		});
	});   
	</script>
	<script>
	function delete_language(language,file)
	{
		swal({   title: "Are you sure?",   text: "Do you really want to delete this language?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){
			var currentLocation = window.location;
			$.ajax({
				type: "POST",
				url: "action.php",
				data: {language_file:file,language_name:language},
				cache: false,
				success: function(result)
				{		
					swal("Deleted!", "Language deleted successfully!", "success");
					var delay=1000;
					setTimeout(function(){
						window.location=currentLocation;
					},delay); 
				}
			});	
		});  
	}
	</script>
    </body>
</html>