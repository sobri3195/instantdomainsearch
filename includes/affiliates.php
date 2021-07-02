<?php
$mysql_query=mysql_query("SELECT * FROM affiliates WHERE status=1");

$count = mysql_num_rows($mysql_query);

$i=1;				

if($count > 1)
{
?>
<div class="container">
    <div class="links">
<?php
	while($rows=mysql_fetch_array($mysql_query))
	{
		if($rows['affiliate_name'] == $_SESSION['affiliate_name'] || !isset($_SESSION['affiliate_name']) && $i == 1)
		{
		
			?>
			<a class="tab active" onclick="affiliate_links_change(this.id);" id="<?php echo $rows['affiliate_name'];?>"><?php echo $rows['affiliate_title'];?></a>
			<?php
			
		}
		else
		{
		
			?>
			<a class="tab" onclick="affiliate_links_change(this.id);" id="<?php echo $rows['affiliate_name'];?>"><?php echo $rows['affiliate_title'];?></a>
			<?php
		
		}					
		$i++;
	}
?>
    </div>
</div>
<?php
}				
?>