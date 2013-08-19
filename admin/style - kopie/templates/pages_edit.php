<div style="float: left;">
<form action="" method="post">
	{edit}
	<fieldset>
	<legend>Bewerk pagina</legend>
		<label for="pageid">Pagina ID:</label>
		{page_id}<br />
		<label for="title">Tile</label>
		<input type="text" name="title" id="title" value="{page_title}" /> Alias same? <input type="checkbox" name="alias_checkbox" id="alias_checkbox" />
		<br />
		<label for="title_alias">Title Alias</label>
		<input type="text" name="alias" id="alias" value="{page_title}" />
		<br />
		<label for="created_by">Created by</label>
		<input type="text" name="created_by" id="created_by" disabled="disabled" value="{page_author}" />
		<br />
		<br />
		<label for="content">Content Page</label><br />
		<textarea class="ckeditor" name="content" id="content">{page_content}</textarea>
		<input type="submit" name="submit" id="submit" value="Bewerken" />
	</fieldset>
</form>
</div>
<div style="float: left;">
		<a href="/cmswire/v3/admin/pages/add/remove/{page_id}">Verwijderen</a>
</div>
{/edit}