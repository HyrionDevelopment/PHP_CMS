Op deze pagina kan je later paginas toegoeven, aanpassen en verwijderen.<br>
Helaas zijn wij deze functie nog aan het ontwikkelen<br>
<br>
<a href="{base_url}/admin/pages/home/add">Add</a> - <a href="{base_url}/admin/pages/home/remove">remove</a>
<div id="users-contain" class="ui-widget">
	<table id="users" class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header ">
				<th>ID</th>
				<th>Title</th>
				<th>Status</th>
				<th>Access</th>
				<th>Created by</th>
				<th>Date</th>
				<th>Hits</th>
			</tr>
		</thead>
		<tbody>
			{content}
			<tr>
				<td>{page_id}</td>
				<td><a href="/cmswire/v3/admin/pages/add/edit/{page_id}">{page_title}</a></td>
				<td class="green">Online!</td>
				<td>-</td>
				<td>{page_author}</td>
				<td>{page_date}</td>
				<td>-</td>
			</tr>
			{/content}
		</tbody>
	</table>
	</div>