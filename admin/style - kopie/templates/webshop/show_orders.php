<script src="http://demo.cmswire.nl/admin_shortcuts/js/jquery.json-2.3.js"></script>
<script>
$(document).ready(function(){
	$('.checkall').click(function () {
		if($(this).attr('checked')){
			$('input:checkbox').attr('checked',true);
		}else{
			 $('input:checkbox').attr('checked',false);
		}
	});
	
	$('#run_action').click(function(){
		var str = "";
        $("#action_select option:selected").each(function () {
			str += $(this).text() + " ";
			var str2 = $(this).attr('value');
			//$('#order_load').load('{setting.base_url}/admin/index.php/webshop/orders/' + encodeURI(str2) + '/post/');
			//alert('http://localhost/cmswire/v3/admin/webshop/orders/' + encodeURI(str2) + '/post/');
			var selected = new Array();
			$("input:checkbox:checked").each(function() {
				selected.push($(this).val());
			});
			
			var ajax = $.post('{setting.base_url}/admin/webshop/orders/' + encodeURI(str2) + '/post/', "data="+$.toJSON(selected), function(response) 
			{
				//if(response == "success")
				//{
					alert(response);
					window.location = '{setting.base_url}/admin/webshop/orders/' + encodeURI(str2) + '/';
				//}
			});
        });
	});
	
});
</script>
<table id="items" class="ui-widget ui-widget-content" width="80%">
	<thead>
		<tr class="ui-widget-header ">
			<th width="2%" style="text-align: left;">
			<input type="checkbox" name="select_all_orders" value="select_all_orders" class="checkall" />
			</th>
			<th width="13%">Bestelling ID</th>
			<th width="57%">Bestelling gemaakt door</th>
			<th width="10%">Bestelling (Vooraf)betaald</th>
			<th width="10%">Bestelling volitooid</th>
			<th width="10%">Totaalprijs bestelling</th>
			<th width="10%">Bewerken</th>
			<th width="10%">Verwijderen</th>
		</tr>
	</thead>
	<tbody>
{orders}	
		<tr>
			<td><input type="checkbox" name="order_select_{order_id}" class="checkbox" value="order_select_{order_id}" /></td>
			<td>{order_id}</td>
			<td>Gebruikersnaam: <a href="#">{username}</a> - Gebruikers ID: <a href="#">{user_id}</a></td>
			<td>{transactio}</td>
			<td>{completed}</td>
			<td>&euro;<span>{total_price}</span></td>
			<td>
			<a href="{setting.base_url}/admin/webshop/items/edit/{item_id}/">
			<img src="http://cdn1.iconfinder.com/data/icons/silk2/page_white_edit.png" />
			</a>
			</td>
			<td>
			X
			</td>
		</tr>
{/orders}
    </tbody>
</table>
</div>
<select id="action_select">
<option value="">Selecteer een actie:</option>
<option value="processing">Bestelling Verwerken</option>
<option value="Delete">Verwijderen</option>
</select>
<input type="button" value="Run Action" id="run_action" />
<br />
</div>

