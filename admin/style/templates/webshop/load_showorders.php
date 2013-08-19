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
	$("#num_items_select").change(function () {
        var str = "";
        $("#num_items_select option:selected").each(function () {
			str += $(this).text() + " ";
        });
		$('#order_load').load('{setting.base_url}/admin/index.php/webshop/orders/geheim/' + encodeURI(str));
    })
    .change();
		
	
	
});
</script>

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

<div id="order_load">
</div>