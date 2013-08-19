<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{WEBSITE-NAME} - Test</title>
<link href="{setting.base_url}/admin/style/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
<link href="{setting.base_url}/css/bootstrap.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body
{
	margin: 0px 0px;
}
#header
{
	background:url({setting.base_url}/cache/style/default/images/header.png);
	width: auto;
	height: 136px;
}
#menu
{
	float: left;
	width: 12%;
	height: 100%;
	font-size: 10pt;
	padding-left: 15px;
	padding-top: 15px;
	font-family: Verdana, Geneva, sans-serif;
	
}
#footer {
	background: #CCC;
	height: 60px;
	width: auto;
	padding-top: 5px;
	font-size: 10pt;
	padding-left: 10px;
	display: block;
	clear: both;
}
#content
{
	padding-left: 13%;
	padding-right: 10px;
}
.htext
{
	color: #FFF;
	font-size: 35pt;
	font-family: Ebrima;
	padding-top: 7px;
	padding-left: 15px;
}

h1 
{
	font-size: 12pt;
	text-align: left;
	display:inline;
	font-weight: normal;
	font-family: Verdana, Geneva, sans-serif;
} 


.line1
{
	background: #CCC;
	height: 1px;
	width: auto;
}


.menu2
{
	padding-left: 5px;
	padding-top: 5px;
}

.menu2 ul
{
	list-style: square;
	padding-left: 15px;
	margin: 0;
}

.menu2 li
{
	border-bottom: 1px solid #CCC;
	padding-bottom: 7px;
	padding-top: 7px;
	font-size: 10pt;
	list-style: square;
	color:#CCC;
}
.menu2 li span
{
	color: #000000;
}


#test
{
	width: auto;
}
div#users-contain { width: auto; font-size: 10px; }
div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }

div#cart { width: auto; font-size: 11px; font-family:Verdana, Geneva, sans-serif; }
div#cart table { margin: 0 0; border-collapse: collapse; width: 700px; }
div#cart table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
.cart_amount { width: 20px; }
</style>
{jquery}
<script src="http://demo.cmswire.nl/admin_shortcuts/js/jquery.json-2.3.js"></script>
</head>

<body>
<div id="header">
<div class="htext"><strong>{WEBSITE-NAME}</strong></div>
</div>
<div id="menu">
{menu}
</div>

</div>
<div id="content">