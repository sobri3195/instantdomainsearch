<?php
if(!isset($_SESSION))
session_start();

include "../config/config.php";

include "../includes/functions.php";
?>
<script> 
$(function()
{
	$('#delete').click(function()
	{
		swal({   title: "Are you sure?",   text: "Do you really want to delete selected domains?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){
				var page = $('#results .pagination li.active-page').attr('p');
				var search = document.getElementById('domain').value;
				$('input[type=checkbox]:checked').each(function(){
					var the_id = $(this).val();
					var del_complete='delete_all';
					$('#results').html("<img style='display:block;margin: auto auto; margin-top:150px; margin-bottom:257px;' src='<?php echo rootpath(); ?>/style/images/ajax_loader.GIF'/>").fadeIn('fast');
					$.ajax({
						type: "POST",
						url: "action.php",
						data: {'id':+the_id,'delete':del_complete,'page':page},
						success: function(n)
						{
							swal("Deleted!", "Your selected domains has been deleted successfully!", "success");
							if(n || page == 1)
							loadData(page,search,'null','null');
                            else        
                            loadData(page-1,search,'null','null');							
						}
					});
				});
		});
	});
	$('#update').click(function()
	{
	    swal({   title: "Are you sure?",   text: "Do you really want to update selected domains?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#2CA86A",   confirmButtonText: "Yes, update!",   closeOnConfirm: false }, function(){
			var page = $('#results .pagination li.active-page').attr('p');
			var search = document.getElementById('domain').value;
			$('input[type=checkbox]:checked').each(function()
			{
				var the_id = $(this).val();
				var upt_complete='update_all';
				if(the_id != "on"){
					$('#results').html("<img style='display:block;margin: auto auto; margin-top:150px; margin-bottom:257px;' src='<?php echo rootpath(); ?>/style/images/ajax_loader.GIF'/>").fadeIn('fast');
					$.ajax({
					type: "POST",
					url: "action.php",
					data: {'id':+the_id,'update':upt_complete},
					success: function(n)
					{
						loadData(page,search,'null','null');                            
					}
					});
				}
			});
			swal("Updated!", "Your selected domains has been Updated successfully!", "success");
		});
	});                                                    
	$("input[type=checkbox]").click(function()
	{
		var x = $("input[type=checkbox]:checked").length;
		var t = $("input[type=checkbox]").length;             
		if(t==x)
		{                                                     
			$("#delete ,#update").show();
		} 
		else 
		{                                                    
			$("#delete ,#update").show();
			if(x==0)
			{
				$("#delete,#update").hide();
			}
		}
	});                                                    
	$("#chkall").live("click", function()
	{                                                     
		$("input[type=checkbox]").each(function()
		{
			$(this).attr("checked", true);
		});												  
		$(this).hide();
		$("#unchkall, #delete,#update").show();
	});                                                   
	$("#unchkall").live("click", function()
	{                                                     
		$("input[type=checkbox]").each(function()
		{
			$(this).attr("checked", false);
		});												  
		$("#unchkall, #delete, #update").hide();
		$("#chkall").show(); 
	});
}); 	
</script>
<?php

$search = $_POST['search'];

$page = $_POST['page'];

$type = $_POST['type'];

$order = $_POST['order'];

if($type == 'null' && !isset($_SESSION['type']))
{

	$type = 'last_date_check';
	$_SESSION['type'] = $type;

}
else if($type != 'null')
{

	$_SESSION['type'] = $type;
	
}
if($order == 'null' && !isset($_SESSION['order']))
{

	$order = 'DESC';
	$_SESSION['order'] = $order;

}
else if($order != 'null')
{

	$_SESSION['order'] = $order;
	
}

$cur_page = $page;

$page -= 1;

$per_page = 8;

$first_btn = true;

$last_btn = true;

$start = $page * $per_page;

if(isset($_POST['page']))
{

	$result_pag_data = mysqlQuery("SELECT * from instant_domain  WHERE  domain LIKE '%$search%' order by ".$_SESSION['type']." ".$_SESSION['order']." LIMIT $start, $per_page ") or die('MySql Error' . mysql_error()); 

	$n = mysql_num_rows($result_pag_data); 
	
	$data = mysqlQuery("select * from instant_domain where domain like '%" . $search . "%'");
	
	$rows = mysql_num_rows($data);
	
	$no_of_paginations = ceil($rows / $per_page);
}
                                 /*Calculating the starting and endign values for the loop*/
if ($cur_page >= 7)
{
	$start_loop = $cur_page - 3;
	
	if($no_of_paginations > $cur_page + 3)
	$end_loop = $cur_page + 3;
	else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6)
	{
	
		$start_loop = $no_of_paginations - 6;
		$end_loop = $no_of_paginations;
		
	} 
	else 
	{
	
	    $end_loop = $no_of_paginations;
	
	}
}
else 
{

	$start_loop = 1;
	
	if ($no_of_paginations > 7)
	$end_loop = 7;
	else
	$end_loop = $no_of_paginations;
	
}

$msg="";

$msg .= "<div class='pagination pg-domains'><ul >";

if ($first_btn && $cur_page > 1)
{

	$msg .= "<li p='1' style='border-left-width: 1px;
	-webkit-border-radius: 3px 0 0 3px;
	-moz-border-radius: 3px 0 0 3px;
	 border-radius: 3px 0 0 3px;' id='active'  class='active'>First</li>";
	 
} 
else if ($first_btn)
{

	$msg .= "<li p='1' style='border-left-width: 1px;
	-webkit-border-radius: 3px 0 0 3px;
	-moz-border-radius: 3px 0 0 3px;
	border-radius: 3px 0 0 3px; id='active' class='inactive'>First</li>";
	
}

for ($i = $start_loop; $i <= $end_loop; $i++)
{

	if ($cur_page == $i)
	$msg .= "<li p='$i' id='active' class='active active-page'>{$i}</li>";
	else
	$msg .= "<li p='$i' id='active' class='active'>{$i}</li>";
	
}
                                                    /*TO ENABLE THE END BUTTON*/
if ($last_btn && $cur_page < $no_of_paginations)
{

	$msg .= "<li p='$no_of_paginations' id='active' class='active' style='-webkit-border-top-right-radius: 3px;-webkit-border-bottom-right-radius: 3px;-moz-border-radius-topright: 3px;-moz-border-radius-bottomright: 3px;border-top-right-radius: 3px;border-bottom-right-radius: 3px;'>Last</li>";

}
else if ($last_btn) 
{

	$msg .= "<li p='$no_of_paginations' id='active' class='inactive'>Last</li>";

}
$msg = $msg. "</div>";
$msg .= "<div class='total-pages'>".$cur_page." out of ".$no_of_paginations." Total : ".$rows."</div>";

if($n)
{

?>
<div class="row pull-left dmn-slct">
	<div class="col-lg-12">
	    <?php
		echo '
		<div class="bs-example">
		<div class="btn-group">
		<button   id="delete" style=" display: none;" type="button" class="btn btn-danger btn-sm" title="Delete Selected"><i class="fa fa-trash-o"></i> Delete</button>
		</div><!-- /btn-group -->
		<div class="btn-group">   
		<button  style=" display: none;" id="update" type="button" class="btn btn-success btn-sm"  title="Update Selected"><i class="fa fa-retweet"></i> Update</button>
		</div><!-- /btn-group -->
		</div>
	</div>
</div>';

} 
?>
<div class="row">
	<div class="col-lg-12">	
		<?php 
		if($n)
		{
		?>	
		<div class="table-responsive">
			<div id="t1">
				<table id="website_domain" class="table table-striped table-bordered table-hover table-striped tablesorter" cellspacing="0" width="100%">
					<thead>
						<tr>
						<th width="50px"><input id="chkall" type="checkbox"><input style=" display: none;" id="unchkall" type="checkbox"></th>
						<th width="130px">Domain Name</th>
						<?php 
						$mysql = mysqlQuery("select tld from  tlds ORDER BY display_order");
						while($rows = mysql_fetch_array($mysql))
						{
						?>
						<th width="55px"><?php echo $rows['tld'];?> </th>
						<?php
						}
						?>
						<th width="100px">Updated</th>
						<th width="100px">Action</th>
					</tr>
					</thead>
					<tbody>
						<?php 
						$i=1;
						while ($exists = mysql_fetch_array($result_pag_data))
						{
						$id=$exists['id'];
						?>
						<tr  id="list">
							<?php
							echo '<td width="7%"><input  id="chk" type="checkbox" value="'.$id.'"></td>';
							?>
							<td id="remove" class="ellipsis"><?php echo $exists['domain'];?></td>
							<?php 
							$mysql = mysqlQuery("select tld from  tlds ORDER BY display_order");
							while($rows = mysql_fetch_array($mysql))
						    {
							    $tld = $rows['tld']; 								
								if($exists[$tld]=='1')
								{
								?>
								<td><i class="fa fa-check available"></i></td>
								<?php
								} 
								else
								{
								?>
								<td><i class="fa fa-times taken"></i></td>
								<?php 
								}
							}
							?>
							<td width="12%"><?php echo $exists['last_date_check'];?></td>
							<td width="12%">
								<center>
									<?php echo '<a href="javascript:void()"><button onclick=update("'.$exists['id'].'") type="button" class="btn btn-xs btn-success dmn-actn-btn" data-toggle="tooltip" data-placement="top" title="Update"><i class="fa fa-retweet"></i></button></a>';?>
									<?php echo ' <a href="javascript:void()"><button onclick=deleteBox("'.$exists['id'].'") type="button" class="btn btn-xs btn-danger dmn-actn-btn" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-times"></i></button></a>'; ?>
								</center>
							</td>
						</tr>
						<?php
						$i++;
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
		<?php
		}
		else
		{
		?>
		<section>
		    <div class='col-md-12 content text-center not-found-dmn'>				
			<h1>No domain found for search result "<strong><?php echo $search;  ?></strong>"</h1>
		    </div>
		</section>					
		<?php
		}
		?>		
	</div>
	<div class="row">
		<div class="col-lg-12">
		<?php 
		if($n)
		{
		
			echo $msg;
			
		}
		?>
		</div>
	</div>
</div>
