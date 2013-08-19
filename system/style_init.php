<?php
function HR_header($mode=null)
{
	$load_template = new load_template();
	echo $load_template->header();
	return "niggur";
}