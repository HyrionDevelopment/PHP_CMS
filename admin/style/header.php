<!DOCTYPE html>
<html lang="nl">
<head>
	<meta charset="utf-8">
    <title>Tutoworld Admin</title>
	
	<script type="text/javascript" src="http://localhost/cmswire/v3/admin/js/ckeditor.js"></script>
	
	<link href="{BaseUrl}admin/style/css/bootstrap.css" rel="stylesheet">
    <link href="{BaseUrl}admin/style/css/bootstrap-responsive.css" rel="stylesheet">

	<link href="{CSS_LAYOUT}" rel="stylesheet" type="text/css" />
	<link href="{CSS_MENU}" rel="stylesheet" type="text/css" />

  <script src="{BaseUrl}admin/style/js/jquery.js"></script>
  <script src="{BaseUrl}admin/style/js/bootstrap.js"></script>
  <script type="text/javascript">
  $(function() {
    if(typeof(Storage)!=="undefined")
    {
      if(sessionStorage.HrAdmin_menu)
      {
        $(sessionStorage.HrAdmin_menu).collapse({
          toggle: true
        });
        //sessionStorage.removeItem('HrAdmin_menu');
      }
    }else{
      alert("Your browser doesn't support Hyrion Admin.\nPlease update your browser. \n\nWe recommend to use Firefox or Google Chrome.");
    }

    $('.accordion-inner ul li a').click(function (e){
      //e.preventDefault();
      var parent = $(this).parents(".accordion-inner").parent().get(0).id;
      sessionStorage.HrAdmin_menu = '#'+parent;
      //return false;
    });

  });
  </script>
</head>

<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container" id="container">
          <a class="brand" href="#">{WEBSITE-NAME} Admin</a>
          <a class="brand2" href="#">Powered by: Hyrion.com</a>
          <div class="nav-collapse collapse">
            <div class="pull-right">info@tutoworld.nl</div>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <div class="sidebar-left-menu">
      <div class="menu_ul">

        <div class="search">
          <div class="input-append">
            <input class="span2" id="appendedInputButtons" type="text" placeholder="Search...">
            <button class="btn" type="button"><i class="icon-search"></i></button>
          </div>
        </div>

        <div class="menu_li">
          <!-- <div class="accordion" id="accordion1">
            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#menu-app-user">
                  <i class="icon-pencil"></i>Blog App
                </a>
              </div>
              <div id="menu-app-user" class="accordion-body collapse">
                <div class="accordion-inner">
                  <ul>
                    <li><a href="#">Add Post</a></li>
                    <li><a href="#">Manage Posts</a></li>
                  </ul> 
                </div>
              </div>
            </div>
            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#menu-app-pages">
                  <i class="icon-shopping-cart"></i>Webshop App
                </a>
              </div>
              <div id="menu-app-pages" class="accordion-body collapse">
                <div class="accordion-inner">
                  <ul>
                    <li><a href="#">Add Product</a></li>
                    <li><a href="#">Manage Product</a></li>
                  </ul> 
                </div>
              </div>
            </div>
          </div> -->
          <div class="accordion" id="apps">
          {menu}
          </div>
        </div>

        <span class="sp-sys">Systeem</span>
        <div class="menu_li">
          <div class="accordion" id="accordion2">

            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#sysMenu-dash">
                  <i class="icon-home"></i>Dashboard
                </a>
              </div>
              <div id="sysMenu-dash" class="accordion-body collapse">
                <div class="accordion-inner">
                  <ul>
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">Graphs</a></li>
                    <li><a href="#">Updates</a></li>
                  </ul> 
                </div>
              </div>
            </div>

            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#sysMenu-user">
                  <i class="icon-user"></i>Users
                </a>
              </div>
              <div id="sysMenu-user" class="accordion-body collapse">
                <div class="accordion-inner">
                  <ul>
                    <li><a href="#">Add users</a></li>
                    <li><a href="#">Manage Users</a></li>
                  </ul> 
                </div>
              </div>
            </div>

            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#sysMenu-pages">
                  <i class="icon-file"></i>Pages
                </a>
              </div>
              <div id="sysMenu-pages" class="accordion-body collapse">
                <div class="accordion-inner">
                  <ul>
                    <li><a href="#">Add Pages</a></li>
                    <li><a href="#">Manage Page</a></li>
                  </ul> 
                </div>
              </div>
            </div>

            <div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#sysMenu-settings">
                  <i class="icon-cog"></i>Settings
                </a>
              </div>
              <div id="sysMenu-settings" class="accordion-body collapse">
                <div class="accordion-inner">
                  <ul>
                    <li><a href="#">General Settings</a></li>
                    <li><a href="#">Captcha</a></li>
                  </ul> 
                </div>
              </div>
            </div>

          </div>
        </div>


      </div>
    </div>
    <div class="container" style="width: 85%; float: left;">
    <span class="app_title">Bewerk pagina</span>
    <span class="breadcrumbs"><a href="#">Admin</a> > <a href="#">Pagina's</a> > <a href="#">Pagina's Beheren</a> > <a href="#">Homepage</a></span>