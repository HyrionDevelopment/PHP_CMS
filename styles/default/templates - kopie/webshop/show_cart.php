<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.3/jquery-ui.min.js"></script>
<link rel="stylesheet" href="http://demo.cmswire.nl/admin_shortcuts/css/jquery-ui-1.8.16.custom.css">
<link rel="stylesheet" href="http://demo.cmswire.nl/admin_shortcuts/js/demos.css">
<script>
$(document).ready(function(){
	//var Arrays=new Array();

		$( "#dialog1" ).dialog({
			resizable: false,
			autoOpen: false,
			height:140,
			modal: true,
			buttons: {
				"Ja": function() {
					window.location = "http://google.nl/";
				},
				"Nee": function() {
					$( this ).dialog( "close" );
				}
			}
		});
	
	$('a.delete').click(function() 
	{
		var id = $(this).parent().parent().attr('id');
		
		var data = { 'user_id' : {user_id}, 'item_id' : id }
		var parent = $(this).parent().parent();
		
		var jqxhr = $.post("{setting.base_url}webshop/winkelmandje/delete/", "data="+$.toJSON(data), function(response) {
			//parent.fadeOut('slow', function() {$(this).remove();});
			if(response=="success")
			{
				//alert(response);
				parent.fadeOut('slow', function() {$(this).remove();});
			}
		});
	});
	$('.plus_cart').click(function()
	{
		var id1 = $(this).attr('id');
		var id = id1.replace("plus_", "");
		var amount = "#cart_amount_"+id;
		var price_per_unit1 = $("#"+id).children(".cart_price").find('span').html();
		var price_per_unit = price_per_unit1.replace(",",".");
		var ppu_int = parseFloat(price_per_unit);
		
		
		
		var plus1 = parseInt($(amount).val()) +1;
		var min1 = parseInt($(amount).val()) -1;
		
		if(parseInt($(amount).val()) < 1)
		{
			$(amount).val('1');
		}else{
			if(plus1 < 21)
			{
				$(amount).val(plus1);				
				var total1 = parseInt(plus1)*ppu_int;
				var total2 = total1.toFixed(2);
				var total = total2.replace(".", ",");
				$("#"+id).children(".cart_subtotalprice").find('span').html(total);
				
				//var array2 = new Array('{user_id}', id, plus1);
				//document.write(array2);
				
				var data2 = { 'item_id' : id, 'user_id' : {user_id}, 'amount' :  plus1 }
				
				var ajax2 = $.post("{setting.base_url}webshop/winkelmandje/add_price_total/", "data="+$.toJSON(data2), function(response) {
					if(response)
					{
						$("#cart_totalprice").find('span').html(response);
					}
				});
			}
		}
	});
	$('.min_cart').click(function()
	{
		var id1 = $(this).attr('id');
		var id = id1.replace("min_", "");
		var amount = "#cart_amount_"+id;
		var price_per_unit1 = $("#"+id).children(".cart_price").find('span').html();
		var price_per_unit = price_per_unit1.replace(",",".");
		var ppu_int = parseFloat(price_per_unit);
		
		var plus1 = parseInt($(amount).val()) +1;
		var min1 = parseInt($(amount).val()) -1;
		
		if(parseInt($(amount).val()) > 21)
		{
			$(amount).val('1');
		}else{
			if(plus1 > 2)
			{
				$(amount).val(min1);
				var total1 = parseInt(min1)*ppu_int;
				var total2 = total1.toFixed(2);
				var total = total2.replace(".", ",");
				$("#"+id).children(".cart_subtotalprice").find('span').html(total);
				//var array2 = new Array('{user_id}', id, min1);
				//document.write(array2);
				
				var data2 = { 'item_id' : id, 'user_id' : {user_id}, 'amount' :  min1 }
				
				var ajax2 = $.post("{setting.base_url}webshop/winkelmandje/add_price_total/", "data="+$.toJSON(data2), function(response) {
					//if(response=="success")
					//{
						$("#cart_totalprice").find('span').html(response);
					//}
				});
			}
		}
	});	
	
	$('.cart_amount').change(function() {
		var id1 = $(this).attr('id');
		var id = id1.replace("cart_amount_", "");
		var amount = $("#cart_amount_"+id).val();
		var amount2 = "#cart_amount_"+id;
		
		var price_per_unit1 = $("#"+id).children(".cart_price").find('span').html();
		var price_per_unit = price_per_unit1.replace(",",".");
		var ppu_int = parseFloat(price_per_unit);
				
		
		if(amount != parseInt(amount))
		{
			$(amount2).val('1');
			var amount = '1';
		}
		
		if(parseInt(amount) > 21)
		{
			$(amount2).val('1');
			var amount = '1';
		}
		
		if(parseInt(amount) < 2)
		{
			$(amount2).val('1');
			var amount = '1';
		}
		
		var total1 = parseInt(amount)*ppu_int;
		var total2 = total1.toFixed(2);
		var total = total2.replace(".", ",");
		$("#"+id).children(".cart_subtotalprice").find('span').html(total);
		
		var data2 = { 'item_id' : id, 'user_id' : {user_id}, 'amount' : amount }
				
		var ajax2 = $.post("{setting.base_url}webshop/winkelmandje/add_price_total/", "data="+$.toJSON(data2), function(response) {
			$("#cart_totalprice").find('span').html(response);
		});
	});
	
	$('#show_array').click(function()
	{
		document.write(Arrays);
	});
	
	$('#buy').click(function()
	{
		var data = { 'user_id' : {user_id} }
		var ajax = $.post("{setting.base_url}webshop/orders/cart_2_order/", "data="+$.toJSON(data), function(response) 
		{
			if(response=="error")
			{
				alert('Er zit ergens een fout. Leeg uw winkelmandje.\n Als u deze melding nogmaals krijgt neem dan contact op met de website beheerder.');
			}else{
				window.location = "{setting.base_url}webshop/checkout/step1/"+response+"/"
			}
		});
	});
});

function round(n,dec) {
	n = parseFloat(n);
	if(!isNaN(n)){
		if(!dec) var dec= 0;
		var factor= Math.pow(10,dec);
		return Math.floor(n*factor+((n*factor*10)%10>=5?1:0))/factor;
	}else{
		return n;
	}
}
</script>

<div id="dialog1" title="Wilt u afrekenen?">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Weet u zeker dat u wil afrekenen? uw winkelmandje wordt dan geleegd.</p>
</div>

<div id="cart">
<br />
<table id="cart" class="ui-widget ui-widget-content" >
	<thead>
		<tr class="ui-widget-header ">
			<th width="13%">Aantal</th>
			<th width="57%">Product</th>
			<th width="15%">Prijs per stuk</th>
			<th width="15%">Totaalprijs</th>
		</tr>
	</thead>
	<tbody>
		{webshop}
		<tr id="{item_id}">
			<td>
				<input type="text" name="amount" id="cart_amount_{item_id}" class="cart_amount" value="{item_amount}" />
				<div style="float: right;">
				<a href="#"><img class="plus_cart" id="plus_{item_id}" src="http://cdn1.iconfinder.com/data/icons/splashyIcons/add_small.png" /></a>
				<a href="#"><img class="min_cart"  id="min_{item_id}" src="http://cdn1.iconfinder.com/data/icons/Sizicons/12x12/minus.png" /></a>
				</div>
				<a class="delete" href="#">Verwijderen</a>
			</td>
			<td><a href="{setting.base_url}webshop/producten/bekijk/{item_title_alias}/">{item_title}</a></td>
			<td id="price_{item_price}" class="cart_price"><div style="float: right;">&euro;<span>{item_price2}</span></div></td>
			<td class="cart_subtotalprice"><div style="float: right;">&euro;<span>{item_subtotal}</span></div></td>
		</tr>
		{/webshop}

    </tbody>
</table>
<table id="cart2" class="ui-widget ui-widget-content" >
		<tr>
			<td width="13%"></td>
			<td width="55%"></td>
			<td width="29%" style="font-size: 12px;" id="cart_totalprice">Totaal prijs:<div style="float: right; color: red; font-weight:bold;">&euro;<span>{total_price}</span></div></td>
		</tr>
</table>
</div>
<a href="#" id="buy">Afrekenen</a>