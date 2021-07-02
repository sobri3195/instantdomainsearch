<?php
include dirname(__FILE__) . '/includes/header.php';
 
include dirname(__FILE__) . '/includes/header_under.php';
?>
	<title>Tlds Settings: <?php echo(get_title());?></title>
	</head>
	<body>
	<?php include "includes/top_navbar.php"; ?>
	<div id="wrapper">		
		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12 page-ttl">
					<h1>
					<h1><i class="fa fa-tags"></i> Tlds Settings <small>Update Tld's</small>
					</h1>
				</div>
			</div>
			<div class="page-content">
				<div class="margin_sides">
					<div class="row">
					<?php 
					if($error)
					{ 
					?>
					<div id="tld_updated" class="col-md-8 alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-exclamation-triangle"></i> <?php echo $error;?>
					</div>
					<?php 
					} 
					else if(isset($_POST['submit']))
					{ 
					?>
					<div id="tld_updated" class="col-md-8 alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-check-square-o"></i> <?php echo $lang_array['tld_status_success'];?>
					</div>
					<?php 
					} 
					?>
					<div style="display:none" id="tld_selected" class="col-md-8 alert alert-success alert-dismissable">
						<button type="button" class="close"  aria-hidden="true">&times;</button><i class="fa fa-check-square-o"></i> <?php echo $lang_array['tld_main_selected'];?>
					</div>
					<div style="display:none" id="language-selected" class="col-md-8 alert alert-success alert-dismissable">
						<button type="button" class="close"  aria-hidden="true">&times;</button><i class="fa fa-check-square-o"></i> <?php echo $lang_array['suggested_language'];?>
					</div>
					<div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
						<div class="panel panel-success">
							<div class="panel-body">
								<div class="col-lg-12">
										<div class="col-lg-6 col-md-6 col-sm-7 col-xs-12">
											<span class="main-tld">Select main domain TLD</span>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
											<?php 
											    $c=1;
											    $mysql = mysqlQuery("SELECT tld FROM tlds WHERE status = 1");
											    $fetch = mysql_fetch_array(mysqlQuery("SELECT tld FROM main_tld"));
											    ?>
											    <select  class="form-control" id="main_tld" onchange="select_domain()" name="main_tld">
												    <option  value="<?php echo $fetch['tld']; ?>" selected="">
													    <?php echo $fetch['tld']; ?></option>
													    <?php 
													    while($rows = mysql_fetch_array($mysql))
													    {
															if($fetch['tld'] != $rows['tld'])
															{
															?>
															<option value="<?php echo $rows['tld']; ?>"><?php echo $rows['tld']; ?></option>
															<?php 
															}
															$c++;
													    }
													    ?>
											    </select>
										</div>
								</div>
								</br>
								</br>
								<div class="col-lg-12">
										<div class="col-lg-6 col-md-6 col-sm-7 col-xs-12">
											<span class="main-tld">Suggesstion Language</span>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
										<?php 
										$get = mysql_fetch_array(mysqlQuery("SELECT language FROM suggested_language")); 
										$language = $get['language']
										?>
											<select  class="form-control" id="language" onchange="suggested_language()" name="main_tld">
											    <option value=''><?php echo $language;?></option>
												<?php if($language != 'ENG') {?>
												<option value="ENG">ENG</option>
												<?php } if($language != 'ESP') {?>
												<option value="ESP">ESP</option>
												<?php } if($language != 'POR') {?>
												<option value="POR"> POR</option>
												<?php } if($language != 'GER') {?>
												<option value="GER">GER</option>
												<?php } if($language != 'FRE') {?>
												<option value="FRE">FRE</option>
												<?php } if($language != 'CHI') {?>
												<option value="CHI">CHI</option>
												<?php } if($language != 'TUR') {?>
												<option value="TUR">TUR</option>
												<?php } ?>
											</select>
										</div>
								</div>
								</br>
								</br>
								<div class="col-lg-12">
										<div class="col-lg-6 col-md-6 col-sm-7 col-xs-12">
											<span class="main-tld">Suggessted Domain Limit</span>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
											<input type="text" class="form-control" id="suggessted_limit" required value="<?php echo (suggessted_limit()); ?>" required="">
										</div>
								</div>
								</br>
								</br>
								<div class="col-lg-12">
										<div class="col-lg-6 col-md-6 col-sm-7 col-xs-12">
											<span class="main-tld">Preserve in Database (Days)</span>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
											<input type="text" class="form-control" id="days" required value="<?php echo (preserve_days()); ?>" required="">
										</div>
								</div>
								</br>
								</br>
								<div class="col-lg-12">
										<div class="col-lg-6 col-md-6 col-sm-7 col-xs-12">
											<span class="main-tld">Instantly Show Domain Limit</span>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12">
											<input type="text" class="form-control" id="instantLimit" required value="<?php echo (instantDomainLimit()); ?>" required="">
										</div>
								</div>
								<div class="clearfix"></div>
								
								<div class="tld-settings">
										<?php 				
										$count = mysql_num_rows(mysql_query("SELECT * FROM tlds"));
										$mid = $count/2;
										$mid = ceil($mid);
										$sql1=mysqlQuery("SELECT * FROM tlds LIMIT 0,$mid");
										?>
										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<?php 
										$i=1;
										while($rows=mysql_fetch_array($sql1))
										{  
											if($rows['status'] == 1)
											{ 
											?>
											<div class="form-group">
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
													<b>.<?php echo $rows['tld']; ?></b>
												</div>
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
													<input onchange="displayNote(this,'<?php echo $rows['id'];?>')" id="<?php echo $rows['id']; ?>" class="my_checkbox"  type="checkbox" checked>
												</div>
											</div>
											<?php 
											}
											else
											{
											?>
											<div class="form-group">
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
													<b>.<?php echo $rows['tld']; ?></b>
												</div>
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
													<input onchange="displayNote(this,'<?php echo $rows['id'];?>')" id="<?php echo $rows['id']; ?>" class="my_checkbox"  type="checkbox">
												</div>
											</div>
											<?php 
											}
											?>
											<input type="hidden" id="tld<?php echo $rows['id'];?>" class="form-control" value="<?php echo $rows['tld']; ?>">
											<input type="hidden" id="status<?php echo $rows['id'];?>" class="form-control" value="<?php echo $rows['status']; ?>"  >
											<?php
										$i++;
										}
										?>
										</div>
										<?php 																		
										$sql2=mysqlQuery("SELECT * FROM tlds LIMIT $mid,$count");
										?>
										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<?php 
										$c=11;
										while($rows=mysql_fetch_array($sql2))
										{
											if($rows['status'] == 1)
											{ 
											?>
											<div class="form-group">
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
													<b>.<?php echo $rows['tld']; ?></b>
												</div>
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
													<input onchange="displayNote(this,'<?php echo $rows['id'];?>')"  id="<?php echo $rows['id']; ?>" class="my_checkbox" type="checkbox" checked>
												</div>
											</div>
											<?php 
											}
											else 
											{
											?>
											<div class="form-group">
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
													<b>.<?php echo $rows['tld']; ?></b>
												</div>
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
													<input onchange="displayNote(this,'<?php echo $rows['id'];?>')" id="<?php echo $rows['id']; ?>" class="my_checkbox" type="checkbox">
												</div>
											</div>
											<?php 
											}
											?>
											<input type="hidden" id="tld<?php echo $rows['id'];?>" class="form-control" value="<?php echo $rows['tld']; ?>">
											<input type="hidden" id="status<?php echo $rows['id'];?>" class="form-control" value="<?php echo $rows['status']; ?>"  >
											<?php
										$c++;
										}
										?>
										</div>
								</div>
							</div>
						</div>
						<button class="btn btn-success" id="update"><i class="fa fa-check"></i> Update</button>
					</div>		
					</br>
					</br>			
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include dirname(__FILE__) . '/includes/footer.php'; ?>
	<script>
	function displayNote(chkbox,id)
		{
			var status = (chkbox.checked) ? "1" : "0";
			document.getElementById('status'+id).value = status;
			var TldName = document.getElementById('tld'+id).value;
			var status_tld = document.getElementById('status'+id).value;
			$.ajax({
				type: "POST",
				url: "action.php",
				data: {'id':id,'TldName':TldName,'status_tld':status_tld},
			});
		}
	function select_domain()
		{
		
			var main_domain = document.getElementById("main_tld").value;
			document.getElementById("tld_selected").style.display='none';
			document.getElementById("language-selected").style.display='none';
			$.ajax({
				type: "POST",
				url: "action.php",
				data: {'main_domain':main_domain},
				cache: false,
				success: function(result)
				{
					document.getElementById("tld_selected").style.display='block';
				}
			});
		
		}   
	function suggested_language()
		{
		
			var language = document.getElementById("language").value;
			document.getElementById("tld_selected").style.display='none';
			document.getElementById("language-selected").style.display='none';
			$.ajax({
				type: "POST",
				url: "action.php",
				data: {'suggest_language':language},
				cache: false,
				success: function(result)
				{
					document.getElementById("language-selected").style.display='block';
				}
			}); 
		
		} 	
	$(function()
		{
			$('#update').click(function()
			{
				swal({   title: "Are you sure?",   text: "Do you really want to Edit Tlds Settings?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#2CA86A",   confirmButtonText: "Yes, ADD!",   closeOnConfirm: false },function(){
					var SuggesstedLimit = document.getElementById('suggessted_limit').value;
					var PreserveDatabase = document.getElementById('days').value;
					var instantLimit = document.getElementById('instantLimit').value;
					$.ajax({
						type: "POST",
						url: "action.php",
						data: {'SuggesstedLimit':SuggesstedLimit,'PreserveDatabase':PreserveDatabase,'instantLimit':instantLimit},
						success: function(result)
						{
							swal("Updated!", "Your Tlds Settings has been Updated successfully!", "success");
							window.location='<?php echo rootpath(); ?>/admin/tlds.php';
						}
					}); 
				});
			});                                                                                                      
		}); 
	</script>
	</body>
</html>