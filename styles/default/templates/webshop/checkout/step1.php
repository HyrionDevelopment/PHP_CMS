<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.3/jquery-ui.min.js"></script>
<link rel="stylesheet" href="http://demo.cmswire.nl/admin_shortcuts/css/jquery-ui-1.8.16.custom.css">
<link rel="stylesheet" href="http://demo.cmswire.nl/admin_shortcuts/js/demos.css">

<h1>Klopt deze bestelling??</h1>
<table id="cart" class="ui-widget ui-widget-content" width="600" >

	<thead>
	
		<tr class="ui-widget-header ">
			<th width="13%">Aantal</th>
			<th width="57%">Product</th>
			<th width="15%">Prijs per stuk</th>
			<th width="15%">Totaalprijs</th>
		</tr>
		
	</thead>
	
	<tbody>
		{order}
		<tr>
			<td>{amount}</td>
			<td><a href="{setting.base_url}webshop/producten/bekijk/{item_alias}">{item_name}</a></td>
			<td id="price_3.20" class="cart_price"><div style="float: right;">&euro;<span>{item_ppe}</span></div></td>
			<td class="cart_subtotalprice"><div style="float: right;">&euro;<span>{item_price}</span></div></td>
		</tr>
		{/order}
	<tbody>
	
</table>
<table id="cart2" class="ui-widget ui-widget-content" width="600" >
		<tr>
			<td width="13%"></td>
			<td width="55%"></td>
			<td width="29%" style="font-size: 12px;" id="cart_totalprice">Totaal prijs:<div style="float: right; color: red; font-weight:bold;">&euro;<span>{total_price}</span></div></td>
		</tr>
</table>

<div style="font-size: 12px; width: 600px;">
<div style="float: left;"><a href="#">Nee, verwijder deze bestelling</a></div>
<div style="float: right;"><a href="{setting.base_url}webshop/checkout/step2/{order_id}/">Ja, volende stap!</a></div>
</div>
