<script>
$(document).ready(function(){

$('#button_submit').click(function(){
	$("#submitpad").css({"background":"green","font-size":"20px"});
});

});
</script>
<style>
#order_processing
{
	margin: 0px auto;
	width: 600px;
}

.items_order_processing
{
	width: 70%;
	margin-bottom: 350px;
	margin: 0px auto;
}
.items_order_processing div
{
	float: left;
	margin-bottom: 30px;
	margin-left: 15px;
}

.items_order_processing div table
{
	background: #ccc;
}

.items_order_processing div table tr td
{
	padding-right: 15px;
	padding-left: 10px;
}

.items_order_processing table .value
{
	font-weight:bold;
}

#processing_buttons
{
	margin: 0px auto;
	width: 400px;
	text-align: center;
}
</style>

<div id="processing_buttons">
<h1 style="text-align: center;">Bestellingen verwerken</h1>
<div style="width: 160px; margin: 0px auto; text-align: center;">
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td id="submitpad" > 
		<span style="cursor:pointer;"> 
		<input name="submit" type='submit' style="cursor:pointer; font-size: 16px;" value="Bestelling verwerken" id="button_submit" /></span> 
		</td>
		</tr>
		</table>
</div>
		<input name="processing_order_prev" type="button" value="<-- Vorige" id="processing_order_prev" /><input name="processing_order_next" type="button" value="Volgende -->" id="processing_order_next" />
</div>
<div id="order_processing">
<h2 style="text-align: center;">Gegevens</h2>
<table>
	<tr>
		<td>Bestelling gegevens</td>
		<td>Gebruiker gegevens</td>
		<td>Profiel gegevens</td>
	</tr>
	
	<tr>
		<td>
			<table>
				<tr>
					<td>Bestellings ID:</td>
					<td>1</td>
				</tr>
				<tr>
					<td>Bestelling betaald?</td>
					<td>Ja</td>
				</tr>
				<tr>
					<td>Bestelling vooraf betaald?</td>
					<td>Ja</td>
				</tr>
				<tr>
					<td>Bestelling Betaal metode:</td>
					<td>iDeal</td>
				</tr>
				<tr>
					<td>Bestelling totaal prijs:</td>
					<td>&euro; 300,00</td>
				</tr>
				
			</table>
		</td>
		<td>

			<table>
				<tr>
					<td>User id:</td>
					<td>1</td>
				</tr>
				<tr>
					<td>Gebruikersnaam:</td>
					<td>Maarten2</td>
				</tr>
			</table>
		
		</td>
		<td>
		
			<table>
				<tr>
					<td>Naam:</td>
					<td>Maarten Oosting</td>
				</tr>
				<tr>
					<td></td>
					<td><span style="font-size:12px;">(Voor + Achternaam)</span></td>
				<tr>
					<td>Adres:</td>
					<td>Amelterhout 45</td>
				</tr>
				<tr>
					<td>Postcode:</td>
					<td>9403EC</td>
				</tr>
				<tr>
					<td>Plaats:</td>
					<td>Assen</td>
				</tr>
			</table>
		
		</td>
	</tr>
</table>
</div>
<div class="items_order_processing">
<h2 style="text-align: center;">De bestelling</h2>
<div>
<table>
	<tr>
		<td>Product ID:</td>
		<td class="value">1</td>
	</tr>
	<tr>
		<td>Product Naam</td>
		<td class="value">Samsung Galaxy S II</td>
	</tr>
	<tr>
		<td>Aantal</td>
		<td class="value">7</td>
	</tr>
	<tr>
		<td>Prijs per stuk</td>
		<td class="value">&euro; 3,49</td>
	</tr>
	<tr>
		<td>Pijs x Aantal</td>
		<td class="value">&euro; 24,43</td>
	</tr>
</table>
</div>
<div>
<table>
	<tr>
		<td>Product ID:</td>
		<td class="value">1</td>
	</tr>
	<tr>
		<td>Product Naam</td>
		<td class="value">Samsung Galaxy S II</td>
	</tr>
	<tr>
		<td>Aantal</td>
		<td class="value">7</td>
	</tr>
	<tr>
		<td>Prijs per stuk</td>
		<td class="value">&euro; 3,49</td>
	</tr>
	<tr>
		<td>Pijs x Aantal</td>
		<td class="value">&euro; 24,43</td>
	</tr>
</table>
</div><div>
<table>
	<tr>
		<td>Product ID:</td>
		<td class="value">1</td>
	</tr>
	<tr>
		<td>Product Naam</td>
		<td class="value">Samsung Galaxy S II</td>
	</tr>
	<tr>
		<td>Aantal</td>
		<td class="value">7</td>
	</tr>
	<tr>
		<td>Prijs per stuk</td>
		<td class="value">&euro; 3,49</td>
	</tr>
	<tr>
		<td>Pijs x Aantal</td>
		<td class="value">&euro; 24,43</td>
	</tr>
</table>
</div><div>
<table>
	<tr>
		<td>Product ID:</td>
		<td class="value">1</td>
	</tr>
	<tr>
		<td>Product Naam</td>
		<td class="value">Samsung Galaxy S II</td>
	</tr>
	<tr>
		<td>Aantal</td>
		<td class="value">7</td>
	</tr>
	<tr>
		<td>Prijs per stuk</td>
		<td class="value">&euro; 3,49</td>
	</tr>
	<tr>
		<td>Pijs x Aantal</td>
		<td class="value">&euro; 24,43</td>
	</tr>
</table>
</div><div>
<table>
	<tr>
		<td>Product ID:</td>
		<td class="value">1</td>
	</tr>
	<tr>
		<td>Product Naam</td>
		<td class="value">Samsung Galaxy S II</td>
	</tr>
	<tr>
		<td>Aantal</td>
		<td class="value">7</td>
	</tr>
	<tr>
		<td>Prijs per stuk</td>
		<td class="value">&euro; 3,49</td>
	</tr>
	<tr>
		<td>Pijs x Aantal</td>
		<td class="value">&euro; 24,43</td>
	</tr>
</table>
</div><div>
<table>
	<tr>
		<td>Product ID:</td>
		<td class="value">1</td>
	</tr>
	<tr>
		<td>Product Naam</td>
		<td class="value">Samsung Galaxy S II</td>
	</tr>
	<tr>
		<td>Aantal</td>
		<td class="value">7</td>
	</tr>
	<tr>
		<td>Prijs per stuk</td>
		<td class="value">&euro; 3,49</td>
	</tr>
	<tr>
		<td>Pijs x Aantal</td>
		<td class="value">&euro; 24,43</td>
	</tr>
</table>
</div><div>
<table>
	<tr>
		<td>Product ID:</td>
		<td class="value">1</td>
	</tr>
	<tr>
		<td>Product Naam</td>
		<td class="value">Samsung Galaxy S II</td>
	</tr>
	<tr>
		<td>Aantal</td>
		<td class="value">7</td>
	</tr>
	<tr>
		<td>Prijs per stuk</td>
		<td class="value">&euro; 3,49</td>
	</tr>
	<tr>
		<td>Pijs x Aantal</td>
		<td class="value">&euro; 24,43</td>
	</tr>
</table>
</div>
</div>
