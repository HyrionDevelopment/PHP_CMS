{webshop}
<script>
$(document).ready(function(){
	$(".button_cart").click( function()
	{
		var data = { 'item_id' : {item_id}, 'user_id' : {user_id}, 'amount' :  1 }
		var jqxhr = $.post("{base_url}webshop/winkelmandje/add_to_cart/", "data="+$.toJSON(data), function(response) {
			//if(response=="success")
			//{
				alert(response);
			//}
		});
	
	});
});
</script>
<script type="text/javascript"  >
      document.write('<BASE HREF="http://'+document.domain+'/">');
      document.domain = 'cmswire.nl';
</script>
<div style="width: 60%;">
<div class="button_cart" style="float:right; width: 120px; height:30px; text-align:center; padding-top:10px; border: solid #F30; background: #F93">
  <strong>Add to cart</strong></div>
<h2>{item_title}</h2>
<h1>prijs: &euro;{item_price2}</h1><br>
beschrijving:<br> {item_description}<br>
<br>
</div>

{/webshop}