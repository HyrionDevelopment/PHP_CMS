<script type="text/javascript">
var visibilityAliasBox = false;

$(function(){
	var width = (window.innerWidth/100)*65;
	//alert(width);
	CKEDITOR.replace( 'content',
    {
        height: 500,
        resize_minWidth: 100,
        width: width
    });
	$('#alias_checkbox').click(function() {
		var checked = $("#alias_checkbox:checked").length;
		toggleAliasBox(checked);
	});
});

function toggleAliasBox(checked)
{
	if (checked == 1) {
		$('#page_add_alias').hide();
	}else{
		if(checked == 0)
		{
			$('#page_add_alias').show();
		}
	}
}
</script>
<style type="text/css">
#pageEdit_right
{
	float: left;
	margin-left: 10px;
	padding-left: 10px;
	border-left: 1px solid #ccc;
	width: 16%;
}
</style>
<form action="" method="post">
<div style="float: left;">
	{edit}
	<fieldset>
		<label for="content">Content Page</label>
		<textarea name="content" id="content">{page_content}</textarea>
		<br />
		<input type="submit" name="submit" id="submit" value="Bewerken" class="btn btn-primary" />
	</fieldset>
</div>
<div id="pageEdit_right">

	<div style="margin-bottom: 10px;">
		<a class="btn btn-danger btn-mini" href="/hyrion/beta1/admin/pages/add/remove/{page_id}">Pagina Verwijderen</a><br />
		<label for="pageid">Pagina ID:</label>
		{page_id}
	</div>

	<div>
		<label for="title">Title</label>
		<input type="text" name="title" id="title" value="{page_title}" />
		<br />
	</div>

	<div>
		Automatic alias <input type="checkbox" name="alias_checkbox" id="alias_checkbox" />
	</div>

	<div id="page_add_alias">
		<label for="title_alias">Title Alias</label>
		<input type="text" name="alias" id="alias" value="{page_alias}" />
	</div>

	<div style="margin-top: 20px;">
		<label for="created_by">Created by</label>
		<input type="text" name="created_by" id="created_by" disabled="disabled" value="{page_author}" />
	</div>

</div>
</form>
{/edit}