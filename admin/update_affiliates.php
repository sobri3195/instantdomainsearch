<?php 
if(!isset($_SESSION)) 
session_start();

include "../config/config.php";

include "../includes/functions.php";

$image=$_POST['image'];

$affiliate=$_POST['affiliate'];

$sql=mysqlQuery("SELECT * FROM affiliates WHERE affiliate_name='$affiliate'");

$rows=mysql_fetch_array($sql);

?>
<div style="display:none" id="update_success" class="alert alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-check-square-o"></i> Affiliates Prices Update Successfully !
</div>
<input type="hidden" id="affiliate_name" value="<?php echo $rows['affiliate_name']; ?>"/>
	<div class="panel panel-success">
		<div class="panel-body">
			<div class="form-group">
				<div class="col-lg-12">
					<img src="<?php echo $image ; ?>" class="favicon-size" /> <b><?php echo $rows['affiliate_title']; ?> Setting</b><br />
					<small class="price-in-dollars">(Enter price of TLD's in $) </small>
				</div>
			</div>
			<?php
			$count = mysql_num_rows(mysql_query("SELECT * FROM tlds"));
			$mid = $count/2;
			$mid = ceil($mid);
			?>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<?php 
				$sql1=mysqlQuery("SELECT * FROM tlds LIMIT 0,$mid");
				while($result=mysql_fetch_array($sql1))
				{
				$tld = $result['tld'];
				?>
				<div class="form-group">
					<label class="col-lg-4 control-label"><?php echo strtoupper($result['tld']); ?> Price</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="g<?php echo $tld; ?>" value="<?php echo $rows[$tld]; ?>" />
						</div>
				</div>
				<?php 
				} 
				?>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<?php 
				$sql1=mysqlQuery("SELECT * FROM tlds LIMIT $mid,$count");
				while($result=mysql_fetch_array($sql1))
				{
				$tld = $result['tld'];
				?>
				<div class="form-group">
					<label class="col-lg-4 control-label"><?php echo strtoupper($result['tld']); ?> Price</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="g<?php echo $tld; ?>" value="<?php echo $rows[$tld]; ?>" />
						</div>
				</div>
				<?php 
				} 
				?>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<label class="col-lg-2 control-label">Affiliate Url</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="gurl" value="<?php echo $rows['url']; ?>" placeholder="Enter Your affiliate link" />
						    <a target="_blank" href="<?php echo ($rows['affiliates_links']); ?>" class="btn btn-primary btn-xs mrg-10-top">Get your own "<?php echo $rows['affiliate_title']; ?>" Affiliate Link</a>
						</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="form-group">
		<div class="col-lg-12">
			<div class="col-lg-12">
				<button type="submit" onclick="back_front()" class="btn btn-default"><i class="fa fa-chevron-left"></i> Back</button>
				<button type="submit" onclick="update_prices('<?php echo $rows['affiliate_name']; ?>');" class="btn btn-success"><i class="fa fa-check"></i> Update</button> 
			</div>
		</div>
	</div>