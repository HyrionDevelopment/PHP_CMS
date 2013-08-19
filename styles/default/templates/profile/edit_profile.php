<style>
.dialog-orange
{
	background: #F2A950;
	width: 500px;
	border: dashed #FF6600;
	text-align:center;
}
.dialog-green
{
	background: #60FF6A;
	width: 500px;
	border: dashed #53DB50;
	text-align:center;
}
</style>
<br />
{error}
<div class="dialog-{color}">{error_message}</div>
{/error}
<form id="form1" method="post" action="">
<h1>Profiel</h1>
<p>{profile}{profile_field}: 
  <input type="{form_type}" name="{profile_field}" id="{profile_id}_{profile_field}" value="{profile_data_value}" {form_input_checked} />{required2}
  <br />{/profile}
</p>
<p>
<span style="font-size:11px;">* = Verplicht veld.</span><br />
  <input type="submit" name="button" id="button" value="Aanmaken" />
</p>
</form>