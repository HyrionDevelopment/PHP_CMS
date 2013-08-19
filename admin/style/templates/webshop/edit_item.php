<script src="http://code.jquery.com/jquery-1.7.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	$('#item_price').priceFormat({
		prefix: '',
		thousandsSeparator: '.',
		centsSeparator: ',',
	});
	
	$('.images').click(function() {
    if (!$("input[@name='images']:checked").val()) {
       alert('Nothing is checked!');
        return false;
    }
    else {
		//alert('One of the radio buttons is checked!');
		if($("input[@name='images']:checked").val() == "Uploader")
		{
			$("#webshop_item_image_url").fadeOut("fast", function()
			{
				$('#webshop_item_image_uploader').fadeIn("slow")
			});
		}
		if($("input[@name='images']:checked").val() == "Url")
		{
			$("#webshop_item_image_uploader").fadeOut("fast", function() {
				$('#webshop_item_image_url').fadeIn("slow")
			});;
		}
    }
  });
	CKEDITOR.config.resize_maxWidth = screen.width/100*74;
	CKEDITOR.replace( 'item_short_description',
	{
		toolbar : 'Basic'
	}); 
	CKEDITOR.replace( 'item_description',
	{
		toolbar : 'Full'
	});
});
</script>
<style>
#add_webshop_item
{
	font-family: verdana;
	font-size: 10pt;
}

#add_webshop_item .left
{
	float: left;
	width: 75%;
	border-right: #CCC Solid 1px;
	padding-left: 10px;
	padding-right: 10px;
	margin-right: 10px;
	margin-bottom: 10px;
}

#add_webshop_item .right
{
	padding-right: 10px;
}

/*
#webshop_item_image_url
{
	display: none;
}

#webshop_item_image_uploader
{
	display: none;
}
*/

.input1
{
	width: 600px;
}
</style>
<h1>Webshop product bewerken</h1>
<div id="add_webshop_item">
<form action="" method="POST" enctype="multipart/form-data">
	<div class="left">
		<table>
		<tr>
			<td>Product Naam:</td>
			<td><input type="text" name="item_title" id="item_title" value="{item_title}" class="input1" /></td>
		</tr>
		<tr>
			<td>Product Alias:</td>
			<td><input type="text" name="item_title_alias" id="item_title_alias" value="{item_title_alias}" class="input1" /></td>
		</tr>
		</table>
		<hr /><br />
		Korte Product Beschrijving:<br />
		<textarea class="ckeditor" name="item_short_description" id="item_short_description">{item_short_description}</textarea>
		<br />
		Product Beschrijving:<br />
		<textarea class="ckeditor" name="item_description" id="item_description">{item_description}</textarea>
		<br />
		<button type="submit" class="comments-post yt-uix-button yt-uix-button-default" onclick=";return true;" role="button">
		<span class="yt-uix-button-content">Plaatsen</span>
		</button>
	</div>
	<div class="right">
		Prijs: &euro;<input type="text" name="item_price" id="item_price" value="{item_price}" /><br />
		Categorie:
		<select>
		<option value="test">test</option>
		</select>
		<br /><br />
		<p>Plaatje:<br />
		<i>Het huidige plaatje:</i><br />
		<img src="{item_image}" height="{item_image_height}" width="{item_image_width}" onclick="window.open('http://localhost/cmswire/alpha2/admin/webshop/items/show_image/{item_image2}','Plaatje',
'width=800,height=600,scrollbars=yes,toolbar=yes,location=yes');" style="cursor: pointer;" />
		<br />
		<input type="radio" name="images" class="images" value="Url" />Url
		<input type="radio" name="images" class="images" value="Uploader" />Uploader<br />
		<div id="webshop_item_image_url">
		URL: <input type="text" name="item_image" id="item_image"  value="{item_image}"/> <br />
		</div>
		<div id="webshop_item_image_uploader">
        File: <input type="file" name="filen" width="500" /><br /> <input type="submit" name="subform" value="Upload File!" />
		</div>
		</p>
	</div>
</form>
</div>
