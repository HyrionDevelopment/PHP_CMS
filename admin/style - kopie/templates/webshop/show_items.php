<table id="items" class="ui-widget ui-widget-content" width="80%">
	<thead>
		<tr class="ui-widget-header ">
			<th width="13%">Product ID</th>
			<th width="57%">Product Naam</th>
			<th width="57%">Alias</th>
			<th width="15%">Prijs per stuk</th>
			<th width="15%">Bewerken</th>
		</tr>
	</thead>
	<tbody>
{items}	
		<tr>
			<td><a href="{setting.base_url}webshop/producten/bekijk/{item_title_alias}" target="_blank">{item_id}</a></td>
			<td><a href="{setting.base_url}webshop/producten/bekijk/{item_title_alias}" target="_blank">{item_title}</a></td>
			<td>{item_title_alias}</td>
			<td><div style="float: right;">&euro;<span>{item_price}</span></div></td>
			<td>
			<a href="{setting.base_url}/admin/webshop/items/edit/{item_id}/">
			<img src="http://cdn1.iconfinder.com/data/icons/silk2/page_white_edit.png" />
			</a>
			</td>
		</tr>
{/items}
    </tbody>
</table>

