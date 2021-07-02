<script src="<?php echo rootpath()?>/admin/style/js/jquery-1.11.1.min.js"></script>
<script src="<?php echo rootpath()?>/admin/style/js/froala_editor.min.js"></script>
<script src="<?php echo rootpath()?>/admin/style/js/jquery.tagsinput.js"></script>
<script src="style/js/switch.js"></script>
<script src="style/switch/switch/js/bootstrap-switch.js"></script>
<script>
	$(function(){
		$('#content').editable({inlineMode: false, alwaysBlank: true})
	});
</script>
<script>
	$(".my_checkbox").bootstrapSwitch();
</script>