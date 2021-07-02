<script>
function loadData(page,search,type,order,bydefault)
{
    var status_of_loader = '<?php echo($_SESSION['admin_loader_session']); ?>';
    if(bydefault == 'default' && status_of_loader == 1)
	$('#results').html('<div id="preloader"><div id="facebookG"><div id="blockG_1" class="facebook_blockG"></div><div id="blockG_2" class="facebook_blockG"></div><div id="blockG_3" class="facebook_blockG"></div></div></div>').fadeIn('fast');
	else
	$('#results').html("<img style='display:block;margin: auto auto; margin-top:150px; margin-bottom:257px;' src='<?php echo rootpath(); ?>/style/images/ajax_loader.GIF'/>").fadeIn('fast');
	$.ajax
	({
		type: "POST",
		url: "load_data.php",
		data: {page:page,search:search,type:type,order:order},
		success: function(msg)
		{
			$("#results").ajaxComplete(function(event, request, settings)
			{
				$("#results").html(msg);
			});
		}
	}); 
}
(function($) {
	$.fn.invisible = function() {
		return this.each(function() {
			(this).css("display", "none");
		});
	};
	$.fn.visible = function() {
		return this.each(function() {
			$(this).css("display", "block");
		});
	};
}(jQuery));
$(document).ready(function() {
	$("#domain").keyup(function(event){
		if(event.keyCode == 13){
			$("#search_domain").click();
		}
	});
	$('#search_domain').click(function(){
		var search = $("#domain").val();
		search=search.trim();
		if(search != '')
		$("#cros_search").show();
		else
		$("#cros_search").hide();
		if(search != "")
		loadData(1,search,'null','null');
	});
});
function deleteBox(id)
{
    swal({   title: "Are you sure?",   text: "Do you really want to delete selected domain?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){
		var page = $('#results .pagination li.active-page').attr('p');
		var search = document.getElementById('domain').value;
		$('#results').html("<img style='display:block;margin: auto auto; margin-top:150px; margin-bottom:257px;' src='<?php echo rootpath(); ?>/style/images/ajax_loader.GIF'/>").fadeIn('fast');
		var del_complete = 'delete_all';
		var rowid =id;    
		$.ajax({
			type: "POST",
			url: "action.php",
			data: {'id':+id,'delete':del_complete,'page':page},
			cache: false,
			success: function(n)
			{
				swal("Deleted!", "Your selected domain is deleted successfully!", "success");
				if(n || page == 1)
				loadData(page,search,'null','null');
				else        
				loadData(page-1,search,'null','null');
			}
		});
	});
}
function update(id)
{
    swal({   title: "Are you sure?",   text: "Do you really want to update selected domain?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#2CA86A",   confirmButtonText: "Yes, update!",   closeOnConfirm: false }, function(){
		var update_complete = 'update_all';
		var page = $('#results .pagination li.active-page').attr('p');
		var search = document.getElementById('domain').value;
		$('#results').html("<img style='display:block;margin: auto auto; margin-top:150px; margin-bottom:257px;' src='<?php echo rootpath(); ?>/style/images/ajax_loader.GIF'/>").fadeIn('fast');	
		$.ajax({
			type: "POST",
			url: "action.php",
			data: {'id':+id,'update':update_complete},
			cache: false,
			success: function(result)
			{
				loadData(page,search,'null','null');
			}
		});
		swal("Updated!", "Your selected domain is Updated successfully!", "success");
	});
}
$(document).ready(function(){

    var search = document.getElementById('domain').value;
	loadData(1,search,'null','null','default');
	
});
function search_function(e)
{
	var type;
	var order;
	if(e.value == 'date_desc')
	{
		type = 'last_date_check';
		order = 'DESC';
	}
	else if(e.value == 'date_asc')
		{
		type = 'last_date_check';
		order = 'ASC';
	}
	else if(e.value == 'domain_asc')
	{
		type = 'domain';
		order = 'ASC';
	}
	else if(e.value == 'domain_desc')
	{
		type = 'domain';
		order = 'DESC';
	}
	
	var page = $('#results .pagination li.active-page').attr('p');
	var search = document.getElementById('domain').value;
	if(search != '')
	$("#cros_search").show();
	else
	$("#cros_search").hide();
	loadData(page,search,type,order); 
}
function finish_search()
{
	document.getElementById('domain').value = '';
	$("#cros_search").hide();
	loadData(1,'','null','null');
}
$('#results .pagination li#active').live('click',function()
	{
	
		var search = document.getElementById('domain').value;
		var page = $(this).attr('p');
		if(search != '')
		$("#cros_search").show();
		else
		$("#cros_search").hide();
		loadData(page,search,'null','null');
		
	});
</script>