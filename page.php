<?php 
if(!isset($_SESSION)) 
session_start();

include("config/config.php");

include("includes/functions.php");

include "language/lang_array.php";

include 'admin/libs/contact_captcha.php'; 

include 'libs/mail.php';

$data = array();

$_SESSION['captcha'] = simple_php_captcha(); 

if(isset($_POST['page']) && $_POST['page'] != 'contact')
{

	$permalink = mres($_POST['page']);
	
	$_SESSION['active_page'] = $_POST['page'];
	
	$language = $_SESSION['reset_lang_name'];
	$sql = mysqlQuery("SELECT content FROM page_language WHERE permalink = '$permalink' AND language = '$language'");
	$mysql = mysql_fetch_array($sql);
	$count_page = mysql_num_rows($sql);
	if($count_page == 0)
	{					
		$default = mysql_fetch_array(mysql_query("SELECT lang_name FROM `language` WHERE status = 1 AND lang_name != '$language' ORDER BY display_order"));
		$language = $default['lang_name'];				
			$mysql = mysql_fetch_array(mysql_query("SELECT content FROM `page_language` WHERE permalink='$permalink' AND language = '$language'"));
		if(!isset($mysql['content']))
			$mysql = mysql_fetch_array(mysql_query("SELECT content FROM `page_language` WHERE permalink='$permalink'"));
	}
	$content = db_decode($mysql['content']);

	$data[0] = $content;

	echo json_encode($data);

	exit();

}
else if(isset($_POST['page']) && $_POST['page'] == 'contact')
{
	?>
	<div id="load-message">
	</div>
	<h1 class="page-head"><?php echo $_SESSION['Contact Us'] ; ?></h1>
		<div style="display:none" id="replace-class"  class="alert alert-default alert-dismissable">
			<button type="button" class="close" aria-hidden="true">&times;</button> 
			<div id="alert-message"></div>
		</div>
	<div class="well">
		<div class="row">
			<div class="contact-input">
				<?php if(layout()) { ?>
				<div class="col-lg-6 col-md-6 col-sm-12 col-md-12 pull-right">
				<?php } else { ?>
				<div class="col-lg-6 col-md-6 col-sm-12 col-md-12">
				<?php } ?>
						<div class="form-group your-name">
							<label for="exampleInputEmail1"><?php echo $_SESSION['Name'] ; ?></label>
						</div>
					<div class="user-input">
						<div class="form-group">
							<input class="form-control" id="name" name="name" placeholder="<?php echo $_SESSION['Enter Your Name'] ; ?>" pattern="[A-Za-z].{3,50}"  type="text">
						</div>   
						<div class="form-group">         
							<label for="exampleInputEmail1"><?php echo $_SESSION['Email Address'] ; ?></label>
							<input class="form-control"  id="email" name="email" placeholder="<?php echo $_SESSION['Enter Your Email'] ; ?>" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}"  type="email">
						</div>										
						<div class="form-group">
							<label for="subject"><?php echo $_SESSION['Subject'] ; ?></label>
							<input class="form-control" name="subject" id="subject"  placeholder="<?php echo $_SESSION['Enter a Subject'] ; ?>"   type="text">
						</div>
						<?php 
						if (captcha_contact_status()) 
						{ 
						?>
						<div class="captcha hidden-sm hidden-xs">
							<div class="form-group">
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
									<img src="<?php echo($_SESSION['captcha']['image_src']) ?>" />
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-6 col-sm-9 col-md-6 col-lg-7 captcha-input">
									<label><?php echo $_SESSION['Enter Captcha Code'] ; ?></label>
									<input class="form-control" name="captcha_code" id="captcha_code" placeholder="<?php echo $_SESSION['Enter Code'] ; ?>" value=""  type="text">												
								</div>
							</div> 
						</div>
						<?php
						}
						?>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-md-12">
					<div class="form-group">
						<label for="exampleInputEmail1"><?php echo $_SESSION['Your Message'] ; ?></label>
						<textarea class="form-control msg-input" id="message_box" rows="9" cols="25" name="message" placeholder="<?php echo $_SESSION['Enter Your Message'] ; ?>"  style="resize:none"></textarea>
					</div>
					
					<?php 
					if (captcha_contact_status()) 
					{ 
					?>
					<div class="captcha visible-sm visible-xs">
						<div class="form-group">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<img src="<?php echo($_SESSION['captcha']['image_src']) ?>" />
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-8 col-sm-6 col-md-12 col-lg-12 captcha-input">
								<label><?php echo $_SESSION['Enter Captcha Code'] ; ?></label>
								<input class="form-control" name="captcha_code2" id="captcha_code2" placeholder="<?php echo $_SESSION['Enter Code'] ; ?>" value=""  type="text">												
							</div>
						</div> 
					</div>
					<?php } ?>
				</div>
			</div>
			<div class="clearfix"></div>
			<?php if(layout()) { ?>
			<div class="col-md-2">
			<?php } else { ?>
			<div class="col-md-12">
			<?php } ?>
				<button name="submit" onclick="mailsend();" class="btn btn-submit captcha-btn pull-right" id="submit"><i class="fa fa-paper-plane"></i> <?php echo $_SESSION['Send Message'] ; ?></button>
			</div>
		</div>
	</div>
	<script>
		$('.msg-input').css('height',$('.user-input').css('height'));
	</script>
	<?php	
	exit();
	
}
?>