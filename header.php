<!DOCTYPE html>
<?php get_template_part('stamp'); ?>
<html class="no-js" xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><html <?php language_attributes(); ?>><![endif]-->

<head>

  <!-- Basic Page Needs
    ================================================== -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <!-- Mobile Specific Metas
  ================================================== -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  
  <!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <!-- Favicons
  ================================================== -->
  <link rel="shortcut icon" href="/favicon.ico">

  <?php wp_head(); ?>
  
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>

<body <?php body_class(); ?>>

  <header id="header" class="navbar navbar-default navbar-static-top" role="header">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation">
          <span class="sr-only">Toggle navigation</span>
          <span class="fa fa-bars"></span>
        </button>
        <a id="logo" class="site-title navbar-brand" href="<?php echo home_url(); ?>">
          <?php bloginfo('name') ?>
        </a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <nav class="collapse navbar-collapse" id="navigation" role="navigation">
        
      <?php /* Primary navigation */
      wp_nav_menu( array(
        'menu' => 'primary',
        'depth' => 2,
        'container' => false,
        'menu_id' => 'primary-navbar',
        'menu_class' => 'nav navbar-nav',
        //Process nav menu using our custom nav walker
        'walker' => new wp_bootstrap_navwalker())
      );
      ?>

      </nav><!-- /.navbar-collapse -->
  </header>

  <div id="content" class="container">
