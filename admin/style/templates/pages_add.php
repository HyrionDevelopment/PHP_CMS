<style type="text/css">
#page_add_alias
{
	display: none;
}
</style>
<script type="text/javascript">
var visibilityAliasBox = false;

$(function(){
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

<div style="float: left;">
<form action="" method="post">
	<fieldset>
	<legend>New Page</legend>
		<div>
			<label for="content">Content Page</label>
			<textarea class="ckeditor" name="content" id="content"></textarea>
		</div>
		
		<div>
			<input type="submit" name="submit" id="submit" value="Plaatsen!" />
		</div>
	</fieldset>
</div>
<div style="float: left;">
		<div>
			<label for="title">Title</label>
			<input type="text" name="title" id="title" placeholder="Page title" /> 
		</div>

		<div>
			Alias same as title? <input type="checkbox" name="alias_checkbox" id="alias_checkbox" checked="checked" />
		</div>
		
		<div id="page_add_alias">
			<label for="title_alias">Title Alias</label>
			<input type="text" name="alias" id="alias" />
		</div>
</div>
</form>