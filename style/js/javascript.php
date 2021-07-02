<?php
include "../../config/config.php";

include "../../includes/functions.php";

if(!isset($_SESSION)) session_start();
?>

(function($){

	$.fn.invisible = function(){
	
		return this.each(function(){
		
			 $(this).css("display", "none");
		
		});  
		
	};
	$.fn.visible = function(){
	
		return this.each(function(){
		
			 $(this).css("display", "block");
		
		});
	
	};
	
}(jQuery));

$(document).ready(function()
{    
	var myTimer = undefined;	
	var delayTime = 1500;								
	var TldArray = <?php echo json_encode($_SESSION['TldArray']); ?>;	
	var currentRequest = null;
	$(document).on("click keyup",".Search" ,function(e)
	{
		if ((e.which >= 1 && e.which <= 4) || (e.which >= 48 && e.which <= 57) || (e.which >= 65 && e.which <= 90) || (e.which >= 97 && e.which <= 105) || e.which == 45 || e.which == 190 || e.which == 13 || e.which == 8 || e.which == 189 || e.which == 109 || e.which == 111 || e.which == 191) 
		{					
			var domain = search_validate($('#Search').val());	
			var domain_length = domain.length;				
			var the_char=domain.charAt(0);
			if(the_char === " " || domain.match(/^([-.@#$%^&*()=":';?></|!])/) || domain == "" || domain_length == 1)
				{
					$("#main_page").visible();				
					$("#social-button").visible();				
					$(".footer").removeClass("footer-hidden");					
					$("#tld_list").invisible();					
					$("#top-header-domain").invisible();					
					$("#links").invisible();				
				} 
			else
			{			
				$("#main_page").invisible();
				$("#social-button").invisible();
				$(".footer").addClass("footer-hidden");
				$("#tld_list").visible();
				$("#top-header-domain").visible();
				$("#links").visible();	
				$('.suggesstions-list').css('height',$('.search-tld').css('height'));
				$(".btn-dmn").css({"background-color": "#C2C7CD"});
				$(".com-btn").css({"background-color": "#C2C7CD"});
				$('.btn-dmn').html('<div class="spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>');	
				$('.com-btn').html('<div class="spinner main-tld-loader"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>');					
				$("#change-background").removeClass("main-tld-cont available").addClass("main-tld-cont is-loading");
				$("#change-background").removeClass("main-tld-cont not-available").addClass("main-tld-cont is-loading");
				$('.btn-dmn,.com-btn').attr('id', 'default');
				$('.InstantDomainShow').html(domain);
				var TotalDivWidth = $(".domain-name").width();
				var DomainWidth = $(".InstantDomainShow").width();
				var ExtWidth = $(".domain-ext").width();
				var ExtractWidth = TotalDivWidth-DomainWidth;
				if(ExtractWidth < ExtWidth)
					$(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
				else
					$(".domain-ext").css({"position": "relative", "padding": "0","top": "0", "background-color": "none"});
				var start = domain.indexOf(".");
				if(start != -1)
				{
					var FirstPart = domain.substr(0,start);
					var FindExtension = domain.substr(start+1,domain_length);
				}
				else
				{
					var FirstPart = domain;
					var FindExtension = "";
				}
				domain = FirstPart;
				if (jQuery.inArray(FindExtension, TldArray)!='-1') {
					main_tld = FindExtension;
					$('.live-domain-name').html(domain+"."+main_tld);
				} else {
					var main_tld="<?php echo $_SESSION['main_tld'];?>";
					$('.live-domain-name').html(domain+"."+main_tld);
				}
				clearTimeout(myTimer);				
				myTimer = window.setTimeout( function() {	
					domain = domain.substring(0,60);
					$.ajax({
							type:"POST",
							url: "<?php echo rootpath();?>/suggest.php",
							data: {'domain':domain},
							success: function(msg)
							{		
								$('.suggesstions-list').css({'height':'100%'});							
								$('.suggesstions-list').html(msg);								 
							},
							error: function(msg) {
								
							}							
						});
					$.ajax({
							type:"POST",
							url: "<?php echo rootpath();?>/results.php",
							data: {'domain':domain,'tld':main_tld,'tld1':'main_div'},
							dataType: "json",
							success: function(msg)
							{								    
								$("#top-header-domain").html(msg[0]);									
							},
							error: function(msg) {
								
							}
						});
					if(currentRequest != null)
						currentRequest.abort();
					<?php   
					$i = 0;
					$countArray = count($_SESSION['TldArray']);
					while($i < $countArray)
					{
					$tld = $_SESSION['TldArray'][$i];
					?>		
					currentRequest = $.ajax({
						type:"POST",
						url: "<?php echo rootpath();?>/results.php",
						data: {'domain':domain ,'tld':'<?php echo $tld?>'},
						dataType: "json",
						success: function(msg)
						{		
							$("#tab_<?php echo str_replace('.', '', $tld);?>").html(msg[0]);
							if(ExtractWidth < ExtWidth)
								$(".domain-ext").css({"position": "absolute", "right": "0", "top": "13px","background-color": "#DFE4E8"});
							else
								$(".domain-ext").css({"position": "relative", "padding": "0","top": "0","background-color": "#DFE4E8"});
						},
						error: function(msg) {
							
						}
					});
					<?php 
					$i++;
					}  
					?> 
				}, delayTime);
			}
		}			
	});		
});

function search_validate(val)
{
    var newClass;		
	newClass =val;    		
    var intIndexOfMatch = newClass.indexOf("---");	
	while (intIndexOfMatch != -1)
	{	
		newClass = newClass.replace( "---", "--" )		
		intIndexOfMatch = newClass.indexOf( "---" );	
	}	
	var intIndexOfMatch = newClass.indexOf(".-");	
	while (intIndexOfMatch != -1)
	{	
		newClass = newClass.replace( ".-", "" )		
		intIndexOfMatch = newClass.indexOf( ".-" );	
	}	
	var intIndexOfMatch = newClass.indexOf("-.");	
	while (intIndexOfMatch != -1)
	{	
		newClass = newClass.replace( "-.", "" )		
		intIndexOfMatch = newClass.indexOf( "-." );	
	}                 	
	newClass = newClass.replace(/\.+$|\-+$/g,"");	
	newClass = newClass.replace ( /[^a-zA-Z0-9.-]/g, ''); 
	return newClass;
}
function affiliate_links_change(lastID)
{
	$.ajax({
		type:"POST",
		url: "<?php echo rootpath();?>/includes/count_stats.php",
		data: {'affiliates_clicks':'1','affiliate_name':lastID},
		success: function(msg){
			$("#alert").html(msg);	
		},
		error:function(){
		}
		
	});
	
	$(".tab").removeClass("active");
	
	$("#"+lastID).addClass('active');
	
	var domain = document.getElementById("Search").value;
	
	var valid_domain=search_validate(domain);
	
	if(lastID == "godaddy") 
		godaddy_changes(lastID,valid_domain);
	else if(lastID == "iwant_my_name")
		iwantmyname_changes(lastID,valid_domain);
	else if(lastID == "media_temple")
		media_temple_changes(lastID,valid_domain);
	else if(lastID == "name_cheap")
		name_cheap_changes(lastID,valid_domain);
	else if(lastID == "one_one")
		one_one_changes(lastID,valid_domain);
	else if(lastID == "register")
		register_changes(lastID,valid_domain);
	else if(lastID == "united_domains")
		united_domains_changes(lastID,valid_domain);
	else if(lastID == "yahoo")
		yahoo_changes(lastID,valid_domain);
	else if(lastID == "hover")
		hover_changes(lastID,valid_domain);
		
}
function godaddy_changes(lastID,domain)
{
	var suggesstedDomain;
	var suggesstedExt;
	<?php
	$i = 0;
	$countArray = count($_SESSION['TldArray']);
	while($i < $countArray)
	{
		$ext = $_SESSION['TldArray'][$i];
		$tld = str_replace('.', '', $_SESSION['TldArray'][$i]);
		$affiliatesPrice = 'godaddy_'.$tld;
		?>
		$("#tld_<?php echo $tld;?>,#top_<?php echo $tld;?>_domain,#suggest_tld_<?php echo $tld;?>").html('<?php echo (convert_currency($_SESSION[$affiliatesPrice])); ?>');
		$("#href_<?php echo $tld;?>").attr("href","<?php echo $_SESSION['godaddy_url']; ?>?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.<?php echo $ext;?>&checkAvail=1");		
		<?php 
		$i++;
	}
	$c = 0;
	$totalArray = $_SESSION['suggesstion_limit'];
	while($c < $totalArray)
	{
		?>	
		suggesstedDomain = document.getElementById("suggesstedDomain<?php echo $c; ?>").value;
		suggesstedExt = document.getElementById("suggesstedExt<?php echo $c; ?>").value;
		$("#suggest_href_<?php echo $c;?>").attr("href","<?php echo $_SESSION['godaddy_url']; ?>?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+suggesstedDomain+"&tld=."+suggesstedExt+"&checkAvail=1");	
		<?php 
		$c++;
	}
	?>
	$("#top_domain_href").attr("href", "<?php echo $_SESSION['godaddy_url']; ?>?sid=1673601704.1419598115&url=https://www.godaddy.com/domains/search.aspx?domainToCheck="+ domain +"&tld=.<?php echo $_SESSION['main_tld'];?>&checkAvail=1");			
	
}
function iwantmyname_changes(lastID,domain)
{
	var suggesstedDomain;
	var suggesstedExt;
	<?php
	$i = 0;
	$countArray = count($_SESSION['TldArray']);
	while($i < $countArray)
	{
		$ext = $_SESSION['TldArray'][$i];
		$tld = str_replace('.', '', $_SESSION['TldArray'][$i]);
		$affiliatesPrice = 'iwant_'.$tld;
		?>
		$("#tld_<?php echo $tld;?>,#top_<?php echo $tld;?>_domain,#suggest_tld_<?php echo $tld;?>").html('<?php echo (convert_currency($_SESSION[$affiliatesPrice])); ?>');	
		$("#href_<?php echo $tld;?>").attr("href","<?php echo $_SESSION['iwant_url'];?>&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".<?php echo $ext;?>%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
		<?php 
		$i++;
	}
	$c = 0;
	$totalArray = $_SESSION['suggesstion_limit'];
	while($c < $totalArray)
	{
		?>	
		suggesstedDomain = document.getElementById("suggesstedDomain<?php echo $c; ?>").value;
		suggesstedExt = document.getElementById("suggesstedExt<?php echo $c; ?>").value;
		$("#suggest_href_<?php echo $c;?>").attr("href","<?php echo $_SESSION['iwant_url'];?>&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ suggesstedDomain + "."+suggesstedExt+"%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
		<?php 
		$c++;
	}
	?>
	$("#top_domain_href").attr("href", "<?php echo $_SESSION['iwant_url'];?>&afftrack=&urllink=iwantmyname.com%2Fsearch%2Fadd%2F"+ domain + ".<?php echo $_SESSION['main_tld'];?>%3Fr%3DInstantDomainSearch%26_r%3DInstantDomainSearch%26_p%3Dsession%253Dunused%2526user%253Dunused");
	
}
function media_temple_changes(lastID,domain)
{
	var suggesstedDomain;
	var suggesstedExt;
	<?php
	$i = 0;
	$countArray = count($_SESSION['TldArray']);
	while($i < $countArray)
	{
		$ext = $_SESSION['TldArray'][$i];
		$tld = str_replace('.', '', $_SESSION['TldArray'][$i]);
		$affiliatesPrice = 'media_'.$tld;
		?>
		$("#tld_<?php echo $tld;?>,#top_<?php echo $tld;?>_domain,#suggest_tld_<?php echo $tld;?>").html('<?php echo (convert_currency($_SESSION[$affiliatesPrice])); ?>');	
		$("#href_<?php echo $tld;?>").attr("href","<?php echo $_SESSION['media_url'] ; ?>");
		<?php 
		$i++;
	}
	$c = 0;
	$totalArray = $_SESSION['suggesstion_limit'];
	while($c < $totalArray)
	{
		?>	
		suggesstedDomain = document.getElementById("suggesstedDomain<?php echo $c; ?>").value;
		suggesstedExt = document.getElementById("suggesstedExt<?php echo $c; ?>").value;
		$("#suggest_href_<?php echo $c;?>").attr("href","<?php echo $_SESSION['media_url'] ; ?>");
		<?php 
		$c++;
	}
	?>
	$("#top_domain_href").attr("href","<?php echo $_SESSION['media_url'] ; ?>");
	
}
function name_cheap_changes(lastID,domain)
{
	var suggesstedDomain;
	var suggesstedExt;
	<?php
	$i = 0;
	$countArray = count($_SESSION['TldArray']);
	while($i < $countArray)
	{
		$ext = $_SESSION['TldArray'][$i];
		$tld = str_replace('.', '', $_SESSION['TldArray'][$i]);
		$affiliatesPrice = 'namecheap_'.$tld;
		?>
		$("#tld_<?php echo $tld;?>,#top_<?php echo $tld;?>_domain,#suggest_tld_<?php echo $tld;?>").html('<?php echo (convert_currency($_SESSION[$affiliatesPrice])); ?>');	
		$("#href_<?php echo $tld;?>").attr("href","<?php echo $_SESSION['namecheap_url'];?>?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".<?php echo $ext; ?>");	
		<?php 
		$i++;
	}
	$c = 0;
	$totalArray = $_SESSION['suggesstion_limit'];
	while($c < $totalArray)
	{
		?>	
		suggesstedDomain = document.getElementById("suggesstedDomain<?php echo $c; ?>").value;
		suggesstedExt = document.getElementById("suggesstedExt<?php echo $c; ?>").value;
		$("#suggest_href_<?php echo $c;?>").attr("href","<?php echo $_SESSION['namecheap_url'];?>?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+suggesstedDomain+"."+suggesstedExt);	
		<?php 
		$c++;
	}
	?>
    $("#top_domain_href").attr("href","<?php echo $_SESSION['namecheap_url'];?>?sid=1673601704.1419598115&url=https://www.namecheap.com/domains/registration/results.aspx?domain="+ domain + ".<?php echo $_SESSION['main_tld'];?>");	
	
}
function one_one_changes(lastID,domain)
{
	var suggesstedDomain;
	var suggesstedExt;
	<?php
	$i = 0;
	$countArray = count($_SESSION['TldArray']);
	while($i < $countArray)
	{
		$ext = $_SESSION['TldArray'][$i];
		$tld = str_replace('.', '', $_SESSION['TldArray'][$i]);
		$affiliatesPrice = 'one_'.$tld;
		?>
		$("#tld_<?php echo $tld;?>,#top_<?php echo $tld;?>_domain,#suggest_tld_<?php echo $tld;?>").html('<?php echo (convert_currency($_SESSION[$affiliatesPrice])); ?>');
		$("#href_<?php echo $tld;?>").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=<?php echo $ext; ?>&aid=10933941&pid=<?php echo $_SESSION['one_PID']; ?>&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");		
		<?php 
		$i++;
	}
	$c = 0;
	$totalArray = $_SESSION['suggesstion_limit'];
	while($c < $totalArray)
	{
		?>	
		suggesstedDomain = document.getElementById("suggesstedDomain<?php echo $c; ?>").value;
		suggesstedExt = document.getElementById("suggesstedExt<?php echo $c; ?>").value;
		$("#suggest_href_<?php echo $c;?>").attr("href","https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ suggesstedDomain +"&tld="+suggesstedExt+"&aid=10933941&pid=<?php echo $_SESSION['one_PID']; ?>&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");		
		<?php 
		$c++;
	}
	?>
	$("#top_domain_href").attr("href", "https://www.dpbolvw.net/interactive?sid=80072381.1420179601&domain="+ domain +"&tld=.<?php echo $_SESSION['main_tld'];?>&aid=10933941&pid=<?php echo $_SESSION['one_PID']; ?>&url=http://order.1and1.com/dcjump?ac=OM.US.US469K02463T2103a&ovm_kp=wh&ovm_wm=s_ch_360x50");			
	
}
function register_changes(lastID)
{
	var suggesstedDomain;
	var suggesstedExt;
	<?php
	$i = 0;
	$countArray = count($_SESSION['TldArray']);
	while($i < $countArray)
	{
		$ext = $_SESSION['TldArray'][$i];
		$tld = str_replace('.', '', $_SESSION['TldArray'][$i]);
		$affiliatesPrice = 'register_'.$tld;
		?>
		$("#tld_<?php echo $tld;?>,#top_<?php echo $tld;?>_domain,#suggest_tld_<?php echo $tld;?>").html('<?php echo (convert_currency($_SESSION[$affiliatesPrice])); ?>');	
		$("#href_<?php echo $tld;?>").attr("href","<?php echo $_SESSION['register_url'] ; ?>");
		<?php 
		$i++;
	}
	$c = 0;
	$totalArray = $_SESSION['suggesstion_limit'];
	while($c < $totalArray)
	{
		?>	
		suggesstedDomain = document.getElementById("suggesstedDomain<?php echo $c; ?>").value;
		suggesstedExt = document.getElementById("suggesstedExt<?php echo $c; ?>").value;
		$("#suggest_href_<?php echo $c;?>").attr("href","<?php echo $_SESSION['register_url'] ; ?>");
		<?php 
		$c++;
	}
	?>
	$("#top_domain_href").attr("href","<?php echo $_SESSION['register_url'] ; ?>");
	
}
function united_domains_changes(lastID)
{
	var suggesstedDomain;
	var suggesstedExt;
	<?php
	$i = 0;
	$countArray = count($_SESSION['TldArray']);
	while($i < $countArray)
	{
		$ext = $_SESSION['TldArray'][$i];
		$tld = str_replace('.', '', $_SESSION['TldArray'][$i]);
		$affiliatesPrice = 'united_'.$tld;
		?>
		$("#tld_<?php echo $tld;?>,#top_<?php echo $tld;?>_domain,#suggest_tld_<?php echo $tld;?>").html('<?php echo (convert_currency($_SESSION[$affiliatesPrice])); ?>');	
		$("#href_<?php echo $tld;?>").attr("href","<?php echo $_SESSION['united_url'] ; ?>");
		<?php 
		$i++;
	}
	$c = 0;
	$totalArray = $_SESSION['suggesstion_limit'];
	while($c < $totalArray)
	{
		?>	
		suggesstedDomain = document.getElementById("suggesstedDomain<?php echo $c; ?>").value;
		suggesstedExt = document.getElementById("suggesstedExt<?php echo $c; ?>").value;
		$("#suggest_href_<?php echo $c;?>").attr("href","<?php echo $_SESSION['united_url'] ; ?>");
		<?php 
		$c++;
	}
	?>
	$("#top_domain_href").attr("href","<?php echo $_SESSION['united_url'] ; ?>");
	
}
function yahoo_changes(lastID)
{
	var suggesstedDomain;
	var suggesstedExt;
	<?php
	$i = 0;
	$countArray = count($_SESSION['TldArray']);
	while($i < $countArray)
	{
		$ext = $_SESSION['TldArray'][$i];
		$tld = str_replace('.', '', $_SESSION['TldArray'][$i]);
		$affiliatesPrice = 'yahoo_'.$tld;
		?>
		$("#tld_<?php echo $tld;?>,#top_<?php echo $tld;?>_domain,#suggest_tld_<?php echo $tld;?>").html('<?php echo (convert_currency($_SESSION[$affiliatesPrice])); ?>');	
		$("#href_<?php echo $tld;?>").attr("href","<?php echo $_SESSION['yahoo_url'] ; ?>");
		<?php 
		$i++;
	}
	$c = 0;
	$totalArray = $_SESSION['suggesstion_limit'];
	while($c < $totalArray)
	{
		?>	
		suggesstedDomain = document.getElementById("suggesstedDomain<?php echo $c; ?>").value;
		suggesstedExt = document.getElementById("suggesstedExt<?php echo $c; ?>").value;
		$("#suggest_href_<?php echo $c;?>").attr("href","<?php echo $_SESSION['yahoo_url'] ; ?>");
		<?php 
		$c++;
	}
	?>
	$("#top_domain_href").attr("href","<?php echo $_SESSION['yahoo_url'] ; ?>");
	
}
function hover_changes(lastID,domain)
{
	var suggesstedDomain;
	var suggesstedExt;
	<?php
	$i = 0;
	$countArray = count($_SESSION['TldArray']);
	while($i < $countArray)
	{
		$ext = $_SESSION['TldArray'][$i];
		$tld = str_replace('.', '', $_SESSION['TldArray'][$i]);
		$affiliatesPrice = 'hover_'.$tld;
		?>
		$("#tld_<?php echo $tld;?>,#top_<?php echo $tld;?>_domain,#suggest_tld_<?php echo $tld;?>").html('<?php echo (convert_currency($_SESSION[$affiliatesPrice])); ?>');
		$("#href_<?php echo $tld;?>").attr("href","<?php echo $_SESSION['hover_url'];?>?p.domain="+ domain + ".<?php echo $ext; ?>");
		<?php 
		$i++;
	}
	$c = 0;
	$totalArray = $_SESSION['suggesstion_limit'];
	while($c < $totalArray)
	{
		?>	
		suggesstedDomain = document.getElementById("suggesstedDomain<?php echo $c; ?>").value;
		suggesstedExt = document.getElementById("suggesstedExt<?php echo $c; ?>").value;
		$("#suggest_href_<?php echo $c;?>").attr("href","<?php echo $_SESSION['hover_url'];?>?p.domain="+ suggesstedDomain + "."+suggesstedExt);
		<?php 
		$c++;
	}
	?>
    $("#top_domain_href").attr("href","<?php echo $_SESSION['hover_url'];?>?p.domain="+ domain + ".<?php echo $_SESSION['main_tld'];?>");
}
function capitalise(string) 
{
    return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}
function change_pages(page,title,e)
{
	if (!e) e = window.event;
    if (!e.ctrlKey) {
		$("#main_page").visible();
		$("#social-button").visible();	
		$("#tld_list").invisible();
		$("#top-header-domain").invisible();
		$("#links").invisible();
		$(".footer").removeClass("footer-hidden");
		var status_of_loader = '<?php echo($_SESSION['loader_session']); ?>';
		if(status_of_loader == 1)
			$('#main_page').html('<div id="preloader"><div id="facebookG"><div id="blockG_1" class="facebook_blockG"></div><div id="blockG_2" class="facebook_blockG"></div><div id="blockG_3" class="facebook_blockG"></div></div></div>').fadeIn('fast');  
		document.getElementById('Search').value= '';
		if(page == 'home')
			document.title = capitalise("<?php echo str_replace(array('"'), '', get_title());?>");
		else
			document.title = capitalise(title);
		$(".page").removeClass("active");		
		$("#"+page).addClass('active');
		if(page == 'home')
			window.history.pushState(title, capitalise(page)+ " <?php echo str_replace(array('"'), '', get_title());?> ","<?php echo rootpath();?>");
		else
			window.history.pushState(title, capitalise(page)+ " <?php echo str_replace(array('"'), '', get_title());?> ","<?php echo rootpath();?>/page/"+page);
		$.ajax({		
			type:"POST",    			
			url: "<?php echo rootpath()?>/page.php",			
			data: {'page':page},			
			dataType: "json",			
			success: function(data)
			{
				$("#main_page").html(data['0']);				
			}			
		}); 
		return false;
	}
}
function contact_page(page,e)
{ 
	if (!e) e = window.event;
    if (!e.ctrlKey) {
		$("#main_page").visible();
		$("#social-button").visible();	
		$("#tld_list").invisible();
		$("#top-header-domain").invisible();
		$("#links").invisible();
		$(".footer").removeClass("footer-hidden");
		var status_of_loader = '<?php echo($_SESSION['loader_session']); ?>';
		if(status_of_loader == 1)
			$('#main_page').html('<div id="preloader"><div id="facebookG"><div id="blockG_1" class="facebook_blockG"></div><div id="blockG_2" class="facebook_blockG"></div><div id="blockG_3" class="facebook_blockG"></div></div></div>').fadeIn('fast');  	
		document.getElementById('Search').value= '';
		document.title = capitalise('Contact Us');
		window.history.pushState("Contact Us", capitalise(page)+ " <?php echo str_replace(array('"'), '', get_title());?> ","<?php echo rootpath();?>/"+page);
		$(".page").removeClass("active");		
		$("#contact").addClass('active');
		$.ajax({	
			type:"POST",    		
			url: "<?php echo rootpath()?>/page.php",		
			data: {'page':page},		
			success: function(data)
			{
				$("#main_page").html(data);				
			}			
		}); 
		return false;
	}
}
function mailsend()
{
	var name = document.getElementById('name').value;
	var email = document.getElementById('email').value;
	var subject = document.getElementById('subject').value;
	var message_box = document.getElementById('message_box').value;
	var captcha_status = '<?php echo($_SESSION['contact_captcha_status']); ?>';
	if(captcha_status == 1)
	{
		var captcha_code = document.getElementById('captcha_code').value;
		var captcha_code2 = document.getElementById('captcha_code2').value;
	}
	else
	{
		var captcha_code = '';
		var captcha_code2 = '';
	}
	var status_of_loader = '<?php echo($_SESSION['loader_session']); ?>';
	if(status_of_loader == 1)
    $('#load-message').html('<div id="preloader"><div id="facebookG"><div id="blockG_1" class="facebook_blockG"></div><div id="blockG_2" class="facebook_blockG"></div><div id="blockG_3" class="facebook_blockG"></div></div></div>').fadeIn('fast');  	
	$.ajax({
		type:"POST",    	
		url: "<?php echo rootpath()?>/contact.php",	
		data: {'name':name,'email':email,'subject':subject,'message_box':message_box,'captcha_code':captcha_code,'captcha_code2':captcha_code2},		
		dataType: "json",		
		success: function(data)
		{
		    $('#load-message').html('');	
		    $("#replace-class").visible();	
			if(data[1] == 'danger')
			{
				$("#replace-class").removeClass("alert alert-default alert-dismissable").addClass("alert alert-danger alert-dismissable");
				$("#replace-class").removeClass("alert alert-success alert-dismissable").addClass("alert alert-danger alert-dismissable");
				$("#alert-message").html(data[0]);	
			}
			else if(data[1] == 'success')
			{
				$("#replace-class").removeClass("alert alert-default alert-dismissable").addClass("alert alert-success alert-dismissable");
				$("#replace-class").removeClass("alert alert-danger alert-dismissable").addClass("alert alert-success alert-dismissable");
				$("#alert-message").html(data[0]);
                $('input[type="text"]').val('');				
                $('input[type="email"]').val('');				
                $('#message_box').val('');				
			}			
		}		
	});  
}
function change_language(language,e)
{
	if (!e) e = window.event;
    if (!e.ctrlKey) {
		var currentLocation = window.location;
		$.ajax({
			type: "POST",
			url: "<?php echo rootpath()?>/change_language.php",
			data: {language: language},
			cache: false,
			success: function(result)
			{		
				window.location=currentLocation;
			}
		}); 
		return false;
	}
}
$(window).load(function(e) {
	$.ajax({
		type:"POST",
		url: "<?php echo rootpath();?>/includes/count_stats.php",
		data: {'pageViews':'1'},
	});
	<?php
	if (!isset($_SESSION['uniqueHit'])) { ?>
		$.ajax({
			type:"POST",
			url: "<?php echo rootpath();?>/includes/count_stats.php",
			data: {'uniqueHits':'1'},
		});
	<?php } ?>
});