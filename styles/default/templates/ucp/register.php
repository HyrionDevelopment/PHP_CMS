<style type="text/css">
.form-horizontal .control-group:before,
.form-horizontal .control-group:after {
  display: inline;
}

#column-left
{
  float: left;
}

#column-right
{
  float: left;
}

.form-horizontal .control-label {
  text-align: left;
}
</style>
<h2>Nieuw bij EP:Baas</h2>
<br />
Om producten te kunnen bestellen dient u eerst een account aan te maken.
<br /><br />
<form class="form-horizontal">
<div id="column-left">
  <h4>Persoonlijke gegevens</h4>
            <div class="control-group">
              <label class="control-label" for="inputError">Voornaam</label>
              <div class="controls">
                <input type="text" id="inputError">
                <span class="help-inline"></span>
              </div>
            </div>


            <div class="control-group">
              <label class="control-label" for="inputInfo">Achternaam</label>
              <div class="controls">
                <input type="text" id="inputInfo">
                <span class="help-inline"></span>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="inputSuccess">Postcode</label>
              <div class="controls">
                <input type="text" id="inputPostcode"> 
                <span class="help-inline"></span>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="inputStraat">Straat</label>
              <div class="controls">
                <input type="text" id="inputStraat">
                Nr. 
                <input type="text" id="inputSuccess2" style="width:50px;">
                <span class="help-inline"></span>
              </div>
            </div>
</div>
<div id="column-right">
  <h4>Inloggegevens</h4>
            <div class="control-group">
              <label class="control-label" for="inputError">Email</label>
              <div class="controls">
                <input type="text" id="inputError">
                <span class="help-inline"></span>
              </div>
            </div>


            <div class="control-group">
              <label class="control-label" for="inputInfo">Email bevestigen</label>
              <div class="controls">
                <input type="text" id="inputInfo">
                <span class="help-inline"></span>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="inputSuccess">Wachtwoord</label>
              <div class="controls">
                <input type="text" id="inputPostcode"> 
                <span class="help-inline"></span>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="inputStraat">Wachtwoord bevestigen</label>
              <div class="controls">
                <input type="text" id="inputStraat">
                <span class="help-inline"></span>
              </div>
            </div>
</div>

</form>
<script type="text/javascript">
(function($) {
    $.stripSpaces = function(str) {
        var reg = new RegExp("[ ]+","g");
        return str.replace(/\s/g, '');
    }
})(jQuery);

$(function(){
  $('#inputPostcode').focusout(function(){
    var Postcode = $.stripSpaces($('#inputPostcode').val());
    if (Postcode !== '') {
      var RegEx = new RegExp("^[0-9]{4}[a-z A-Z]{2}$");
      if(RegEx.test(Postcode) == true)
      {

      }
    };
  });
});
</script>