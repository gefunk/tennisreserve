<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Tennis Reservations - <?php echo $title;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<script src="<?php echo base_url();?>assets/js/jquery.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
	<script src="<?php echo base_url();?>assets/js/global.js"></script>
    <!-- Le styles -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.css">
    <link href="<?php echo base_url();?>assets/css/jquery-ui/jquery-ui.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="<?php echo base_url();?>assets/css/global.css" rel="stylesheet">
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url();?>assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url();?>assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url();?>assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url();?>assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>
	<div id="title">
		<div id="text" class="depth">
			Save Court
		</div>
	</div>
    <div id="nav">
        <ul>
          <li><a class="selected" href="<?php echo site_url('home');?>">HOME</a></li>
          <li><a href="<?php echo site_url('about');?>">ABOUT</a></li>
          <li><a href="<?php echo site_url('contact');?>">CONTACT</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li class="divider"></li>
              <li class="nav-header">Nav header</li>
              <li><a href="#">Separated link</a></li>
              <li><a href="#">One more separated link</a></li>
            </ul>
          </li>
 		<?php if($title == 'Calendar') { ?>
 			<li class="dropdown active">
				<a id="date" href="#" class="dropdown-toggle" data-toggle="dropdown">Calendar <b class="caret"></b></a>
				<ul class="dropdown-menu">
              <li id="calendar" ><?php echo $this->calendar->generate(); ?></li>
            </ul>
          </li>
 <?php } ?>
        </ul>

        <button type="submit" class="btn">Sign in</button>
    </div>

    <div class="container">

    