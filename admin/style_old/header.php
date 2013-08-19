
<!DOCTYPE html>
<html lang="nl">
<head>
	<meta charset="UTF-8">
    <title>Untitled Document</title>
    
    <style type="text/css">
    body 
    {
        margin: 0px 0px;
        background: #efebe8;
    }
    
	header
    {
        width: auto;
        height: 116px;
    }
	
	#header1
	{
		background: url(images/header1.png);
		height: 71px;
		color: #FFF;
		font-family:Verdana, Geneva, sans-serif;
		font-size: 24pt;
		font-weight: bold;
		
		padding-left: 15px;
		padding-top: 10px;
	}
	#header2
	{
		background: url(images/header2.png);
		height: 37px;
		padding-left: 20px;
	}
	
	#menu_header1
	{
		height: 37px;
	}
	
	#menu_header1 .left
	{
		float: left;
		background: url(images/menu_header1_left.png);
		height: 37px;
		width: 9px;
	}
	
	#menu_header1 .mid
	{
		float: left;
		background: url(images/menu_header1_mid.png);
		height: 37px;
		width: auto;
	}
	
	#menu_header1 .right
	{
		float: left;
		background: url(images/menu_header1_right.png);
		height: 37px;
		width: 10px;
	}
	
	.menu_header2
	{
		float: left;
	}
	
	.menu_header2 .left
	{
		float: left;
		background: url(images/menu_header2_left.png);
		height: 37px;
		width: 10px;
	}
	.menu_header2 .mid
	{
		float: left;
		background: url(images/menu_header2_mid.png);
		height: 37px;
		width: auto;
	}
	.menu_header2 .right
	{
		float: left;
		background: url(images/menu_header2_right.png);
		height: 37px;
		width: 11px;
	}
	
	#menu_header3
	{
		background:url(images/menu_header3.png);
		height: 45px;
	}
	
	#header_msgbar
	{
		background:url(images/header_msgbar.png);
		height: 37px;
	}
    </style>
    
</head>

<body>
<header>
<div id="header1">CMSWire - Admin</div>

<div id="header2">

<div id="menu_header1">
<div id="menu_header1" class="left"></div>

<div id="menu_header1" class="mid">Lorem Ipsum1</div>

<div id="menu_header1" class="right"></div>

<div class="menu_header2">
<div class="left"></div>
<div class="mid">
Lorem Ipsum
</div>
<div class="right"></div>
</div>

<div class="menu_header2">
<div class="left"></div>
<div class="mid">
Lorem Ipsum
</div>
<div class="right"></div>
</div>

<div class="menu_header2">
<div class="left"></div>
<div class="mid">
Lorem Ipsum
</div>
<div class="right"></div>
</div>
</div>

</div>
<div id="menu_header3"></div>
<div id="header_msgbar"></div>
</header>