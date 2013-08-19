<?php
class model_admin_webshop_orders extends CW_Admin_Model
{
	public function __construct()
	{
		parent::construct();
	}
	
	public function get_all_orders($page=null, $number_item=null)
	{
		if(isset($page))
		{
			$start_point = $page*$number_item;
		}else{
			$start_point = 0;
		}
		
		$mysql = new mysql();
		$sql = "SELECT * FROM webshop_orders ORDER BY order_id DESC LIMIT ".$mysql->escape($start_point).",".$mysql->escape($number_item);
		if($mysql->num_row($sql) > 0)
		{
			$result = mysql_query($sql);
			$result_array = array();
			while($row = mysql_fetch_assoc($result))
			{
				//Gebruikersnaam				
				$user_sql = "SELECT username FROM users WHERE user_id=".$mysql->escape($row['user_id']);
				$user_result = mysql_query($user_sql);
				$user_row = mysql_fetch_assoc($user_result);
				$row['username'] = $user_row['username'];
				
				//Bestelling volitooid?
				if($row['order_completed'] == 1)
				{
					$row['completed'] = 'Ja';
				}else{
					$row['completed'] = 'Nee';
				}
				
				//Totaal bedrag
				$totalprice_sql =  "SELECT SUM(o.amount*i.item_price) as total FROM webshop_order_items AS o LEFT JOIN webshop_items AS i ON i.item_id = o.item_id WHERE o.order_id=".$mysql->escape($row['order_id'])." GROUP BY o.order_id";
				$totalprice_result = mysql_query($totalprice_sql);
				$totralprice_row = mysql_fetch_assoc($totalprice_result);
				$row['total_price'] = $totralprice_row['total'];
				
				//Transaction sql
				$transaction_sql = "SELECT * FROM webshop_transactions WHERE order_id=".$mysql->escape($row['order_id']);
				if($mysql->num_row($transaction_sql, $data=null) == 1)
				{
					$transaction_result = mysql_query($transaction_sql);
					$transaction_row = mysql_fetch_assoc($transaction_result);
					
					$payment_sql = "SELECT * FROM webshop_payment_options WHERE webshop_payment_options_id=".$mysql->escape($transaction_row['payment_option_id']);
					$payment_result = mysql_query($payment_sql);
					$payment_row = mysql_fetch_assoc($payment_result);
					
					$row['transactio'] = 'Ja - '.$payment_row['payment_option_name'];
				}else{
					$row['transactio'] = 'Nee';
				}
				
				array_push($result_array, $row);
			}
			return $result_array;
		}else{
			return false;
		}
	}
	
	public function get_pages($number_item=null)
	{
		$mysql = new mysql();
		//if(isset($pages) && isset($number_item))
		//{
			
			$sql = "SELECT COUNT(*) as count FROM webshop_orders LIMIT 0,".$mysql->escape($number_item);
			$result = mysql_query($sql);
			$row = mysql_fetch_assoc($result);
			$page1 = $row['count']/$number_item;
			$page = ceil($page1);
			
			//echo $page1;
			//echo $page;
			
			$i = 1;
			$j = '';
			while($i <= $page)
			{
				$j .= '<a href="#">'.$i.'</a> ';
				$i++;
			}
			
			echo $j;
			
		//}else{
		//	return false;
		//}
	}
}