<!DOCTYPE html>
<html lang="nl">
<head>
	<meta charset="UTF-8">
    <title>Untitled Document</title>
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.js" type="text/javascript"></script>
	<script type="text/javascript" src="http://localhost/cmswire/v3/admin/js/ckeditor.js"></script>
	
	<link href="{CSS_LAYOUT}" rel="stylesheet" type="text/css" />
	<link href="{CSS_MENU}" rel="stylesheet" type="text/css" />
	<link href="http://localhost/cmswire/v3/admin/style/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
	
<script type="text/javascript">
var timeout         = 500;
var closetimer		= 0;
var ddmenuitem      = 0;
function header_menu_open()
{
	header_menu_canceltimer();
	header_menu_close();
	ddmenuitem = $(this).find('ul').eq(0).css('visibility', 'visible');
}
function header_menu_close()
{
	if(ddmenuitem) ddmenuitem.css('visibility', 'hidden');
}
function header_menu_timer()
{
	closetimer = window.setTimeout(header_menu_close, timeout);
}
function header_menu_canceltimer()
{
	if(closetimer)
	{
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}
$(document).ready(function()
{
	$('#header_menu > li').bind('mouseover', header_menu_open)
	$('#header_menu > li').bind('mouseout',  header_menu_timer)
});
document.onclick = header_menu_close;
</script>
</head>

<body>
<header>
	<div id="header1">
		<div class="left">
			{WEBSITE-NAME} - Admin
		</div>
		<div class="right">
			Maarten - <a href="{l_logout}">Log Out</a>
		</div>
	</div>
	<div id="header2">
	<ul id="header_menu">
	{menu}
	</ul>
	</div>
	<div id="header_line2"></div>
	<div id="header_line"></div>
</header>
<script type="text/javascript">
U heeft voor deze versie van CMSWire admin javascript nodig!
</script>
<div id="content">