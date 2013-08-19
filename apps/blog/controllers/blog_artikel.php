<?php
class blog_artikel extends HR_Controller
{
	var $artikel_nr = 0;

	function __construct()
    {
        parent::__construct();
        $library = array(
        	'Style_loader',
        	'Template_parser'
        );
        $this->load->library($library);

    }
	
    public function __call($name, $arguments)
    {
		$this->artikel_nr = $name;
		$uri_helper = new helper_uri();
		$setting = new settings();
		$this->load->model('BlogArtikelModel');	


		if(is_numeric($this->artikel_nr) && $this->model->BlogArtikel->checkArtikelByID($this->artikel_nr) == true)
		{
			$this->model->BlogArtikel->getArtikelByID($this->artikel_nr);
			if($uri_helper->uri_segment(4) == $this->model->BlogArtikel->getArtikelAlias())
			{
				$cachefile = "cached-blog-$name.html";
				$cachetime = 60;
				if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
				    echo "<!-- Cached copy, generated ".date('H:i', filemtime($cachefile))." --> \n";
				    include($cachefile);
				    $temp = microtime(true) - $GLOBALS['x'];
					echo "<br /> $temp";
				    exit;
				}
				ob_start();
				echo $this->read($this->model->BlogArtikel);
				$cached = fopen($cachefile, 'w');
				fwrite($cached, ob_get_contents());
				fclose($cached);
				ob_end_flush();
			}else{
				$url = $setting->BaseURL_index().'blog/artikel/'.$this->artikel_nr.'/'.$this->model->BlogArtikel->getArtikelAlias().'/';
				header("Location: ".$url);
			}
		}


    }
	
	public function test()
	{
		$this->lib->Template_parser->LoadViewer('full_read',$data=null);
	}
	
	private function read($ModelBlogArtikel)
	{
		$output='';
		$this->model->BlogArtikel = $ModelBlogArtikel;
		$ModelBlogArtikel = null;
	
		$timestamp = $this->model->BlogArtikel->getArtikelTimestamp();
		
		$day1_array = array(
			"zondag",
			"maandag",
			"dinsdag",
			"woensdag",
			"donderdag",
			"vrijdag",
			"zaterdag",
		);
		
		$month_array = array(
			'',
			'Januari',
			'Februari',
			'Maart',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Augustus',
			'September',
			'Oktober',
			'November',
			'December'
		);
		
		$day1 = date("w", $timestamp);
		$day1 = $day1_array[$day1]." ";
		$day2 = date("d ", $timestamp);
		$month = intval(date("m", $timestamp));
		$month = $month_array[$month].' ';
		$year = date("Y", $timestamp);
		
		$date = $day1.$day2.$month.$year;
		$output .= $this->lib->Style_loader->header();

		$data2 = array('URL' => $_SERVER['PHP_SELF']);
		$data=array(
		'title'=>$this->model->BlogArtikel->getArtikelTitle(),
		'date' => $date,
		'time' => date("H:i", $this->model->BlogArtikel->getArtikelTimestamp()),
		'content' => $this->model->BlogArtikel->getArtikelContent(),
		'socialmedia_share' => $this->lib->Template_parser->LoadViewer('socialmedia.php',$data2),
		'username' => 'Maarten',
		);
		
		$output .= $this->lib->Template_parser->LoadViewer('full_read.php',$data);
		$output .= $this->lib->Style_loader->footer();

		return $output;
	}
}