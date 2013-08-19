<?php
	session_start();
	mysql_connect('localhost','root','Zz90Zkm6');
	mysql_select_db('v3') or die( "Unable to select database");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Test pages</title>
	<style>
		body { font-size: 62.5%; }
		label, input { display:block; }
		input.text { margin-bottom:12px; width:95%; padding: .4em; }
		fieldset { padding:0; border:0; margin-top:25px; }
		h1 { font-size: 1.2em; margin: .6em 0; }
		div#users-contain { width: auto; }
		div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
		div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
		.ui-dialog .ui-state-error { padding: .3em; }
		.validateTips { border: 1px solid transparent; padding: 0.3em; }
		
		.green { color: #008500; font-weight: bold;  }
		#add
		{
			background: url(images/add.png);
			width: 16px;
			height: 16px;
			cursor:pointer;
		}
	</style>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.3/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="css/jquery-ui-1.8.16.custom.css">
	<script language="javascript">
	$(document).ready(function()
	{
	
		$( "#add" ).click(function() {
			$( "#dialog-form" ).dialog( "open" );
		});
		
		$( "#dialog-form" ).dialog({
			autoOpen: false,
			modal: true,
			hide: 'fade',
			show: 'fade',

			buttons: {
				"Add Shortcut": function() {
						$( this ).dialog( "close" );
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
			}
		});
			
	});
	</script>	
	</head>
<body>
	<div id="dialog-form" title="Add a Shortcut">
	<iframe style="border: 0px; " src="add.php" width="100%" height="99%"></iframe>
	</div>
<div id="add" ></div>
<div id="users-contain" class="ui-widget">
	<table id="users" class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header ">
				<th>ID</th>
				<th>Title</th>
				<th>Status</th>
				<th>Access</th>
				<th>Created by</th>
				<th>Date</th>
				<th>Hits</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$result = mysql_query("SELECT * FROM pages ORDER BY `page_date` ASC") or die(mysql_error());
								
			while($row = mysql_fetch_array($result))
			{
				$sql2 = mysql_query("SELECT * FROM users WHERE user_id=".$row['page_create_user_id']) or die(mysql_error());
				$row2 = mysql_fetch_row($sql2);
			?>
			
			<tr>
				<td><?php echo $row['page_id']; ?></td>
				<td><a href="#"><?php echo $row['page_name']; ?></a></td>
				<td class="green">Online!</td>
				<td>-</td>
				<td><?php echo $row2[2]; ?></td>
				<td><?php echo $row['page_date']; ?></td>
				<td>-</td>
			</tr>
			
			<?php
				
			}
			?>
		</tbody>
	</table>
</div>
</body>
</html>