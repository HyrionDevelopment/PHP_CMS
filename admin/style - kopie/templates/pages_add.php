<div style="float: left;">
<form action="" method="post">
	<fieldset>
	<legend>New Page</legend>
		<div>
			<label for="title">Tile</label>
			<input type="text" name="title" id="title" /> 
			Alias same? <input type="checkbox" name="alias_checkbox" id="alias_checkbox" />
		</div>
		
		<div>
			<label for="title_alias">Title Alias</label>
			<input type="text" name="alias" id="alias" />
		</div>
		
		<div>
			<label for="created_by">Created by</label>
			<input type="text" name="created_by" id="created_by" disabled="disabled" value="{username}" />
		</div>
		<br />
		<div>
			<label for="content">Content Page</label><br />
			<textarea class="ckeditor" name="content" id="content"></textarea>
		</div>
		
		<div>
			<input type="submit" name="submit" id="submit" value="Plaatsen!" />
		</div>
	</fieldset>
</form>
</div>
<div style="float: left;">
		qq
</div>