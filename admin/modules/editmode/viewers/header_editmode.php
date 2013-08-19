<!DOCTYPE html>
<html>
<head>
<title>Hallo</title>
<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script src="http://localhost/admin_test/js/jQueryRotateCompressed.2.2.js"></script>
<script src="http://localhost/admin_test/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="http://localhost/admin_test/js/ckeditor/adapters/jquery.js"></script>
<style>
body{
	padding:0;
	margin:0;
}

#admin_menu1
{
	background: url(http://localhost/admin_test/images/menu1.png);
	height: 77px;
	margin-top: -57px;
	color: #FFF;
	border-bottom: 1px solid #FFF;
	font-family: Verdana, sans-serif;
}
#admin_menu1 .logo
{
	background: url(http://localhost/admin_test/images/menu1-logo.png);
	height: 50px;
	width: 140px;
	float:left;
}
#admin_menu1_toggle
{
	background: url(http://localhost/admin_test/images/toggle_menu1.png);
	width: 46px;
	height: 37px;
	padding-left: 20px;
	float: right;
}
#editmode_text1
{
	color: #FFF;
	font-weight:bold;
	margin-top: -15px;
	padding-left: 43%;
}
#editmode_text2
{
	margin-top: 20px;
	color: #FFF;
	font-weight:bold;
	padding-left: 43%;
}
@-moz-document url-prefix() {
    #editmode_text2
	{
		margin-top: 13px;
	}
}
#admin_menu1 .small_text
{
	font-size: 10pt;
	color: #FFF;
	float:left;
	margin-top: 17px;
	margin-left: -135px;
}
#admin_menu1 .small_text a 
{
	color: #FFF;
}

#admin_menu1 .menu_text1
{
	padding-left: 40%;
}
#admin_menu1 .menu_text1 a 
{
	color: #FFF;
}

</style>
<!--[if IE]>
	<link rel="stylesheet" type="text/css" href="css/ie.css" />
<![endif]-->
<script type="text/javascript" src="{settings.BaseUrl}admin/{[HR_Admin]CacheFolder}apps/editmode/js/editmode1.js"></script>
</head>

<body>
<div id="admin_menu1">
<div class="logo"></div>
<div id="editmode_text1">
Editmode enabled!
</div>
<div class="menu_text1"><a href="#"><img src="http://localhost/admin_test/images/add.png"/>Pagina Toevoegen</a> <a href="#"><img src="http://localhost/admin_test/images/list.png"/>Pagina Lijst</a></div>
<div class="small_text"><a href="#">Terug naar Adminpanel</a></div>
<div id="editmode_text2">
Editmode enabled!
</div>
</div>
<div id="admin_menu1_toggle">
<img id="img" src="http://localhost/admin_test/images/togglearrow_menu1.png"/>
</div>