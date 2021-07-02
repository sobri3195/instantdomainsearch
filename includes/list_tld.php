<?php   
$i = 0;
$countArray = count($_SESSION['TldArray']);
while($i < $countArray)
{
	$tld = $_SESSION['TldArray'][$i];
	?>
	<div id="tab_<?php echo str_replace('.', '', $tld); ?>" class="extra">
		<a target="blank" id="href_<?php echo str_replace('.', '', $tld);?>">
		<div  class="col-lg-8 col-md-8 col-sm-7 col-xs-7 domain-name">
			<span class="InstantDomainShow"></span><span class="domain-ext">.<?php echo $tld; ?></span>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 domain-button">
			<div id="tld_<?php echo str_replace('.', '', $tld); ?>" class="btn-dmn btn-grey">                                 
			</div>
		</div>
		</a>
	</div>
	<?php
	$i++;
}
?>