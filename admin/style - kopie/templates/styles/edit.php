<style>
#styles
{
	font-family: verdana;
	font-size: 12px;
	margin: 0 auto;
}

#styles .box a
{
	color: #567D8C;
}

#styles .box
{
	height: 300px;
	width: 700px;
	background-color: #CCC;
	padding-left: 10px;	
	padding-right: 10px;
	padding-top: 10px;
	border: solid #424E4F 2px;
	margin: 0 auto;
}

#styles .box .thumb
{
	float: left;
	height: 128px;
	width: 128px;
	margin-right: 5px;
}

#styles .box .style_menu
{
	padding-top: 25px;
}

#styles .box .style_menu a
{
	color: #2A4353;
}

#styles .box .style_menu a:hover
{
	color: #457DBB;
}

#styles .box p 
{
	padding-bottom: 15px;
}
</style>
<div id="styles">
	<div class="box">
	<div class="thumb">
		<img src="{thumb}" height="128" width="128" />
	</div>
	
	<p class="double_enter">
	{lang_style_name}:<br />
	<b>{name}</b>
	</p>
	
	<p class="double_enter">
	{lang_Author} <br />
	<b>{author}</b> - <b>{copyright}</b><br />
	</p>
	
	<p class="double_enter">
	{lang_website}: <br />
	<b><a href="{website}">{website}</a></b><br />
	</p>
	
	<p>
	{COMPATIBLE_HYRION_VERSION}<br />
	<b>{compatibility_answer}</b>
	</p>
	
	<div class="style_menu">
		<a href="#">{activate}</a> <a href="#">{install}</a> <a href="#">{delete}</a> <a href="#">{default}</a> <a href="#">{clean_cache}</a>
	</div>
	</div>
</div>
