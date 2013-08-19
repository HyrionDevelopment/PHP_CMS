<style>
#items
{
	font-size: 12px;
	margin: 0 auto;
}


#filter_items
{
	margin: 0 auto;
	width: 80%;
}

</style>

<script>
$(document).ready(function(){
	$("select").change(function () {
          var str = "";
          $("select option:selected").each(function () {
                str += $(this).text() + " ";
              });
		  $('#cart_load').load('{setting.base_url}/admin/index.php/webshop/items/geheim/' + encodeURI(str));
        })
        .change();
	
});
</script>

<a href="{setting.base_url}/admin/index.php/webshop/items/add/">Producten toevoegen</a>

<div id="filter_items">
Aantal items:
<select id="num_items_select">
<option value="5">5</option>
<option value="10">10</option>
<option value="15">15</option>
<option value="20">20</option>
<option value="25">25</option>
</select>
</div>

<div id="cart_load">
</div>