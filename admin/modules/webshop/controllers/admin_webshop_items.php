<?php
class admin_webshop_items extends CW_Admin_Controller
{
	public function __construct()
    {
        parent::construct();
    }
	
	public function index()
	{
		$load_style = new CW_admin_loadstyle();
		$template = new Template_parser();
		
		echo $load_style->header();
				
		echo $template->parse('style/templates/webshop/load_showitems',$data=null);

		echo $load_style->footer();
	}
	
	public function geheim()
	{
		$seg1 = new CW_admin_segments();
		$seg = $seg1->get_segments();
		$load_style = new CW_admin_loadstyle();
		$template = new Template_parser();
		require_once '../apps/webshop/model/model_webshop_producten.php';
		
		if(isset($seg[4]))
		{
			$data = array();
			$model_producten = new model_webshop_producten();
			$data['items'] = $model_producten->get_all_products(0, $seg[4]);
			echo $template->parse('style/templates/webshop/show_items',$data);
		}
	}
	
	public function add()
	{	
		$load_style = new CW_admin_loadstyle();
		$template = new Template_parser();
		if($_SERVER['REQUEST_METHOD'] == "POST")
		{
			print_r($_POST);
			$model_additem = new model_admin_webshop_items();
			if($model_additem->add($data=$_POST) != false)
			{
				echo $load_style->header();
				echo "Succesvol aangemaakt!";
				echo $load_style->footer();
			}else{
				echo $load_style->header();
				echo "ERROR!";
				echo $load_style->footer();
			}
		}else{
			echo $load_style->header();
			echo $template->parse('style/templates/webshop/add_item',$data=null);
			echo $load_style->footer();
		}
	}
	
	public function edit()
	{
		$seg1 = new CW_admin_segments();
		$seg = $seg1->get_segments();
		$load_style = new CW_admin_loadstyle();
		$template = new Template_parser();
		$model_item = new model_admin_webshop_items();
		$setting = new settings();
		
		$extensions = array('png', 'gif', 'jpg', 'jpeg', 'bmp', 'pdf', 'doc', 'docx', 'html', 'psd', 'css');
		$tfolder = "../images/"; // UPLOADS FOLDER WITH "/" AT THE END (JUST DIR)!
		$tfolder2 = "images/"; // UPLOADS FOLDER WITH "/" AT THE END (JUST DIR)!
		$scriptloc = $setting->base_url(); // SCRIPT LOCATION WITH "/" AT THE END (FULL URL)!
		$maxfsize = 10; // MAXIMUM FILESIZE (IN MEGABYTES)
		
		if(isset($seg[4]))
		{
			if($_SERVER['REQUEST_METHOD'] == "POST")
			{
				//START FILE UPLOAD
				$fname = $_FILES['filen']['name']; // FILE NAME FOR EXTENSION CHECK
				$fext = strtolower(end(explode('.', $fname))); // GET EXTENSION
				$ftemp = $_FILES['filen']['tmp_name']; // TEMP NAME
				$newname = md5(rand(rand(1, 9999), rand(1, 9999))) . "." . $fext; // RANDOM NUMBER BETWEEN 2 RANDOM NUMBERS BETWEEN 1 AND 9999 AND MD5 ENCODED = RANDOM FILE NAME
				$target = $tfolder . $newname; // LOCATION FILE
				$target2 = $tfolder2 . $newname; // LOCATION FILE
				if(!empty($fname)) {
					foreach($extensions as $check) {
						if($check == $fext) {
							$extensioncheck = true;
						}
					}
					if($extensioncheck == true) {
						if(filesize($ftemp) > $maxfsize * (1024*1024)) {
							echo "Your file is too big. The maximum filesize is <b>" . $maxfsize . "</b>MB.";
						}else {
							if(!strstr(strtolower($fname), "php")) {
								$upload = move_uploaded_file($ftemp, $target);
								if($upload) {
									$succes = true;
								}else{
									echo "upload error";
								}
							}else{
								echo "Your file cannot contain the string 'php'!";
							}
						}
					}else{
						echo "This extension is not allowed.";
					}
				}else{
					echo "Please select a file to upload.";
				}
				//END FILE UPLOAD
				
				$data = array(0 => $_POST, 1 => $setting->base_url().$target2);
				echo $load_style->header();
				if($model_item->edit($item_id=$seg[4], $data))
				{
					echo "success";
				}else{
					echo "error";
				}
				echo $load_style->footer();
			}else{
				echo $load_style->header();
				if($model_item->load_product($seg[4]) != false)
				{
					$data = $model_item->load_product($seg[4]);
					$size = getimagesize($data['item_image']);
					$data['item_image2'] = str_replace("http://localhost/cmswire/alpha2/images/", '', $data['item_image']);
					if(is_array($size))
					{
						if($size[0] > 600)
						{
							$width = $size[0]/3;
							if($width > 500)
							{
								$data['item_image_width'] = $size[0]/6;
							}else{
								$data['item_image_width'] = $size[0]/3;
							}
						}
						if($size[1] > 400)
						{
							$height = $size[1]/4;
							if($height > 400)
							{
								$data['item_image_height'] = $size[1]/5;
							}else{
								$data['item_image_height'] = $size[1]/4;
							}
							
						}
					}else{
						$data['item_image'] = 'http://roseleighton.nl/wp-content/uploads/2011/01/testbeeld.jpg';
						$data['item_image_height'] = 200;
						$data['item_image_width'] = 300;
					}
					echo $template->parse('style/templates/webshop/edit_item',$data);
				}else{
					echo "Product niet gevonden!";
				}
				
				echo $load_style->footer();
			}
		}
	}
	
	public function show_image()
	{
		$seg1 = new CW_admin_segments();
		$seg = $seg1->get_segments();
		$setting = new settings();
		if(isset($seg[4]))
		{
			echo '<img src="'.$setting->base_url().'images/'.$seg[4].'" /><br />';
			echo '<b>Orginele grote.</b>';
		}
	}
	
	public function browse()
	{
		$seg1 = new CW_admin_segments();
		$seg = $seg1->get_segments();
		$load_style = new CW_admin_loadstyle();
		$template = new Template_parser();
		$model_item = new model_admin_webshop_items();
		$setting = new settings();
	
		$glob = glob("../images/*");
		$array = array();
		print_r($glob);
		if(count($glob) > 0)
		{
			
			foreach($glob as $key=>$val)
			{
				$array2 = array();
				$array2['img'] = str_replace('../', '' ,$val);
				$array2['extention'] = preg_replace("/^.*\.(jpg|jpeg|png|gif)$/i", '${1}', $val);
				$name = str_replace('.'.$array2['extention'], '' ,$val);
				$array2['name'] = str_replace('../images/', '' ,$name);
				$array2['base_url'] = $setting->base_url();
				
				$array[] = $array2;
			}
		}
		$data['images'] = $array;
		echo $template->parse('style/templates/webshop/browse1',$data);
	}
}
