<ul id="sidebar-nav" class="nav navbar-nav side-nav">
	<li class="active"><?php
	if(basename($_SERVER['PHP_SELF'])=="stats.php")
	{ 
	?>
		<a href="./stats.php"><i class="fa fa-bar-chart-o"></i> Website Stats</a>
	</li>
	<?php 
	} 
	else
	{ 
	?>
	<li>
		<a href="./stats.php"><i class="fa fa-bar-chart-o"></i> Website Stats</a>
	</li>
	<li class="active">
	<?php	
	}
	if(basename($_SERVER['PHP_SELF'])=="settings.php")
	{ 
	?>
		<a href="./settings.php"><i class="fa fa-cogs"></i> Website Settings</a>
	</li>
	<?php
	} 
	else
	{
	?>
	<li>
		<a href="./settings.php"><i class="fa fa-cogs"></i> Website Settings</a>
	</li>
	<li class="active">
	<?php	
	}
	if(basename($_SERVER['PHP_SELF'])=="ads.php")
	{ 
	?>
		<a href="./ads.php"><i class="fa fa-puzzle-piece"></i> Ads Settings</a>
	</li>
	<?php
	} 
	else
	{ 
	?>
	<li>
		<a href="./ads.php"><i class="fa fa-puzzle-piece"></i> Ads Settings</a>
	</li>	
	<li class="active">
	<?php	
	}
	if(basename($_SERVER['PHP_SELF'])=="domains.php") 
	{?>  
		<a href="./domains.php"><i class="fa fa-list"></i> Domains Settings</a>
	</li>
	<?php 
	} 
	else 
	{ 
	?>
	<li>
		<a href="./domains.php"><i class="fa fa-list"></i> Domains Settings</a>
	</li>
	<li class="active">
	<?php
	}
	if(basename($_SERVER['PHP_SELF'])=="tlds.php")
	{ 
	?>
		<a href="./tlds.php"><i class="fa fa-tags"></i> Tld's Settings</a>
	</li>
	<?php 
	} 
	else
	{ 
	?>
	<li>
		<a href="./tlds.php"><i class="fa fa-tags"></i> Tld's Settings</a>
	</li>
	<li class="active">
	<?php
	}
	if(basename($_SERVER['PHP_SELF'])=="tld_sorting.php")
	{ 
	?>
		<a href="./tld_sorting.php"><i class="fa fa-sort"></i> Tld's Sortings</a>
	</li>
	<?php 
	} 
	else
	{ 
	?>
	<li>
		<a href="./tld_sorting.php"><i class="fa fa-sort"></i> Tld's Sortings</a>
	</li>
	<li class="active">
	<?php
	}
	if(basename($_SERVER['PHP_SELF'])=="affiliates_setting.php")
	{
	?>
		<a href="./affiliates_setting.php"><i class="fa fa-sign-in"></i> Affiliates Settings</a>
	</li>
	<?php
	}
	else 
	{ 
	?>
	<li>
		<a href="./affiliates_setting.php"><i class="fa fa-sign-in"></i> Affiliates Settings</a>
	</li>
	<li class="active">
	<?php	
	}
	if(basename($_SERVER['PHP_SELF'])=="language_setting.php" || basename($_SERVER['PHP_SELF'])=="add_language.php" || basename($_SERVER['PHP_SELF'])=="edit_language.php")
	{
	?>
		<a href="./language_setting.php"><i class="fa fa-language"></i> Language Settings</a>
	</li>
	<?php
	}
	else 
	{ 
	?>
	<li>
		<a href="./language_setting.php"><i class="fa fa-language"></i> Language Settings</a>
	</li>
	<li class="active">
	<?php	
	}
	if(basename($_SERVER['PHP_SELF'])=="pages.php" || basename($_SERVER['PHP_SELF']) == "add_page.php" || basename($_SERVER['PHP_SELF']) == "edit_page.php")
	{ 
	?>
		<a href="./pages.php"><i class="fa fa-files-o"></i> Manage Pages</a>
	</li>
	<?php 
	} 
	else
	{ 
	?>
	<li>
		<a href="./pages.php"><i class="fa fa-files-o"></i> Manage Pages</a>
	</li>
	<li class="active">
	<?php
	}
	if(basename($_SERVER['PHP_SELF'])=="captcha_setting.php")
	{ 
	?>
		<a href="./captcha_setting.php"><i class="fa fa-eye-slash"></i> Captcha Settings</a>
	</li>
	<?php
	} 
	else 
	{
	?>
	<li>
		<a href="./captcha_setting.php"><i class="fa fa-eye-slash"></i> Captcha Settings</a>
	</li>
	<li class="active">
	<?php	
	}
	if(basename($_SERVER['PHP_SELF'])=="cache_settings.php")
	{ 
	?>
		<a href="./cache_settings.php"><i class="fa fa-recycle"></i> Cache Settings</a>
	</li>
	<?php
	} 
	else 
	{
	?>
	<li>
		<a href="./cache_settings.php"><i class="fa fa-recycle"></i> Cache Settings</a>
	</li>
	<li class="active">
	<?php	
	}
	if(basename($_SERVER['PHP_SELF'])=="sitemap.php")
	{ 
	?>
		<a href="./sitemap.php"><i class="fa fa-sitemap"></i> Sitemaps Settings</a>
	</li>
	<?php
	} 
	else 
	{
	?>
	<li>
		<a href="./sitemap.php"><i class="fa fa-sitemap"></i> Sitemaps Settings</a>
	</li>
	<li class="active">
	<?php	
	}
	if(basename($_SERVER['PHP_SELF'])=="social.php")
	{
	?>
		<a href="./social.php"><i class="fa fa-users"></i> Social Profiles</a>
	</li>
	<?php 
	} 
	else 
	{ 
	?>
	<li>
		<a href="./social.php"><i class="fa fa-users"></i> Social Profiles</a>
	</li>
	<li class="active">
	<?php	
	}
	if(basename($_SERVER['PHP_SELF'])=="currency.php")
	{ 
	?>
		<a href="./currency.php"><i class="fa fa-usd"></i> Currency Settings</a>
	</li>
	<?php 
	} 
	else
	{ 
	?>
	<li>
		<a href="./currency.php"><i class="fa fa-usd"></i> Currency Settings</a>
	</li>
	<li class="active">
	<?php	
	}
	if(basename($_SERVER['PHP_SELF'])=="analytics.php")
	{
	?>
		<a href="./analytics.php"><i class="fa fa-code"></i> Analytics Settings</a>
	</li>
	<?php 
	} 
	else 
	{ 
	?>
	<li>
		<a href="./analytics.php"><i class="fa fa-code"></i> Analytics Settings</a>
	</li>
	<li class="active">
	<?php
	}
	if(basename($_SERVER['PHP_SELF'])=="account.php")
	{ 
	?>
		<a href="./account.php"><i class="fa fa-user"></i> Account Settings</a>
	</li>
	<?php 
	} 
	else
	{ 
	?>
	<li>
		<a href="./account.php"><i class="fa fa-user"></i> Account Settings</a>
	</li>
	<?php	
	}
	?>
	<li>
		<a href="./logout.php"><i class="fa fa-power-off"></i> Logout</a>
	</li>
</ul>