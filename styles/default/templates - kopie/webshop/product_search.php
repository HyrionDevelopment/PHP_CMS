<script>
$(document).ready(function(){
	$('#button1').click(function(){
		$('#q').load('{base_url}webshop/producten/search_request/' + encodeURI($("#search_words").val()));
	});
	
	$('#search_words').live("change", function() {
		$('#q').load('{base_url}webshop/producten/search_request/' + encodeURI($("#search_words").val()));
	});
	
});
</script>
<h1>Zoeken</h1>
<p>Zoekwoorden: 
  <label for="search_words"></label>
  <input type="text" name="search_words" id="search_words" />
  Categorie: 
  <label for="category"></label>
  <label for="select"></label>
  <select name="select" id="select">
    <option>Alle categorieen</option>
    <option>Telefoons</option>
  </select>
  <!-- <input type="submit" name="submit" id="submit" value="Zoeken" /> -->
  <input name="button1" type="button" id="button1" value="zoeken" />
</p>
<div width="600" height="800" id="q">
</div>