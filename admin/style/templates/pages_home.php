<style type="text/css">
.table {
	width: 0;
}
</style>
<h3>Manage Pages</h3>
<a href="{base_url}admin/pages/add">Add</a> - <a href="{base_url}admin/pages/remove">remove</a>
	<table class="table table-striped">
		<thead>
			<tr>
				<th><input type="checkbox" /></th>
				<th>ID</th>
				<th>Title</th>
				<th>Status</th>
				<th>Created by</th>
				<th>Create Date</th>
				<th>Last Change</th>
				<th>Hits</th>
			</tr>
		</thead>
		<tbody>
			{content}
			<tr>
				<td><input type="checkbox" /></td>
				<td>{page_id}</td>
				<td><a href="{base_url}admin/pages/add/edit/{page_id}">{page_title}</a></td>
				<td class="green">Online!</td>
				<td>{page_author}</td>
				<td>{page_create_date}</td>
				<td>-</td>
				<td>-</td>
			</tr>
			{/content}
		</tbody>
	</table>