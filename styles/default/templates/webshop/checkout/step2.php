<style>
#check_profile
{
	font-family: verdana;
	font-size: 12px;
	margin-top: 10px;
}

#check_profile .green_box
{
	width: 500px;
	height: 90px;
	background: #BDF271;
	border:3px dashed green;
	padding-left: 10px;
	padding-right: 10px;
	padding-top: 10px;
}

#check_profile .red_box
{
	width: 500px;
	height: 90px;
	background: #D97C71;
	border:3px dashed red;
	padding-left: 10px;
	padding-right: 10px;
	padding-top: 10px;
}

#check_profile .img
{
	float: left;
	margin-right: 10px;
}
</style>

<div id="check_profile">
	<div class="{box_color}_box">
		<div class="img">
			<img src="{img_url}" />
		</div>
		
		<div class="error_text">
			{box_text}
		</div>
	</div>
</div>
<div style="font-size: 12px; width: 525px;">
<div style="float: left;"><a href="#">Verwijder deze bestelling</a></div>
{next_step}
</div>