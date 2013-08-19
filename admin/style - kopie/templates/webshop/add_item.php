<script>
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
	CKEDITOR.replace( 'short_description',
	{
		toolbar : 'Basic'
	}); 
	CKEDITOR.replace( 'description',
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

#webshop_item_image_url
{
	display: none;
}

#webshop_item_image_uploader
{
	display: none;
}

.input1
{
	width: 600px;
}
</style>
<h1>Nieuw webshop product aanmaken</h1>
<div id="add_webshop_item">
<form action="" method="POST">
	<div class="left">
		<table>
		<tr>
			<td>Product Naam:</td>
			<td><input type="text" name="item_name" id="item_name" class="input1" /></td>
		</tr>
		<tr>
			<td>Product Alias:</td>
			<td><input type="text" name="item_alias" id="item_alias" class="input1" /></td>
		</tr>
		</table>
		<hr /><br />
		Korte Product Beschrijving:<br />
		<textarea class="ckeditor" name="short_description" id="short_description"></textarea>
		<br />
		Product Beschrijving:<br />
		<textarea class="ckeditor" name="description" id="description"></textarea>
		<br />
		<button type="submit" class="comments-post yt-uix-button yt-uix-button-default" onclick=";return true;" role="button">
		<span class="yt-uix-button-content">Plaatsen</span>
		</button>
	</div>
	<div class="right">
		Prijs: &euro;<input type="text" name="item_price" id="item_price"  value="0" /><br />
		Categorie:
		<select>
		<option value="test">test</option>
		</select>
		<br /><br />
		<p>Plaatje:
		<input type="radio" name="images" class="images" value="Url" />Url
		<input type="radio" name="images" class="images" value="Uploader" />Uploader<br />
		<div id="webshop_item_image_url">
		URL: <input type="text" name="img_url" id="img_url"  value="" /> <br />
		</div>
		<div id="webshop_item_image_uploader">
		Uploader niet geinstalleert.
		</div>
		</p>
	</div>
</form>
</div>
