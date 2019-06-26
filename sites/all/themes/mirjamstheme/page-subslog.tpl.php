
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="Description" content="Orange Entertaiment - is an L.A. based corporation that consults foreign distributors on feature film acquisitions at various stages of production and completion.">
<meta name="Keywords" content="Mirjam Wertheim, Steven Murphy, Susan Wrubel, Shawna Dwyer, Orange Entertainment, Feature Film, Acquistions">
<title>Orange Entertainment</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	
}
-->
</style>
<head>
  <?php print $head; global $user; ?>
  <title><?php print $head_title; ?></title>
  <?php print $styles; ?>
  <?php print $scripts; ?>
  <script type="text/javascript"><?php /* Needed to avoid Flash of Unstyled Content in IE */ ?> </script>
</head>

<body>
	
<?php if($is_admin): ?>
<div id="admin_left_sidebar" class ="admin_left">
	  <?php print $admin_left ?>
</div>
<?php endif; ?>

  <div id="page>
    <!-- header starts-->
    <div id="header-wrap">
      <div id="header" class="container_16">

        <div id="nav">
          <?php print theme('links',$primary_links, array('class' => 'links primary-links')); ?>
       </div>
	<div id="sbox">
	<?php print $search_box; ?>
	</div>
      </div>

    <!-- header ends here -->


    <!-- content starts -->
    <div id="content-wrapper" class="container_16">
      <!-- main -->

     <div id="main" class="grid_16">
         <br/><br/><br/>
          <?php if (!empty($tabs)): ?><div class="tabs"><?php print $tabs; ?></div><?php endif; ?>
          <?php if (!empty($messages)): print $messages; endif; ?>
          <?php if (!empty($help)): print $help; endif; ?>
&nbsp&nbsp&nbsp
<?php if (user_access('edit any film content')): ?>
	<a href="newfilm">New Submission</a>
	<a href="printbook">| Print Market Guide x Sales Co</a>
	<a href="printbook_x_title">&nbsp| Print Market Guide x Title </a><br/><br/>
<?php endif; ?>	

	<a href="printxterr">&nbsp &nbsp Print Territory Guide</a>
	<a href="printcoverage">&nbsp| Print Coverage Book</a>
	<a href="printfilmlist">&nbsp| Print Film List</a>
	<a href="printtracking">&nbsp| Print Tracking</a>


          <div id="content-content" class="clear-block">
	<div class="<?php print (user_access('edit any film content'))?("access"):("noaccess") ?>"
            <?php print $content; ?>
          </div> <!-- /content-content -->
	</div>
          <?php print $feed_icons; ?>
      </div> <!-- main ends here -->

      <!-- sidebars starts here -->

    </div>
</div>
    <!-- content ends here -->

    <!-- footer starts here -->
    <div id="footer-wrapper" class="container_16">

      <!-- footer top starts here -->
      <div id="footer-content">

        <!-- footer left starts here -->
        <div class="grid_8" id="footer-left">

          <?php print $footer_left ?>
        </div>
        <!-- footer left ends here -->

        <!-- footer right starts here -->
        <div class="grid_8" id="footer-right">
	   <?php print $footer_right ?>
        </div>
        <!-- footer right ends here -->

      </div>
      <!-- footer top ends here -->

      <!-- footer bottom starts here -->
      <div id="footer-bottom">
        <p class="bottom-left"><?php print $footer_message ?></p>
              <?php if (!empty($secondary_links)): ?>
          <div id="secondary" class="clear-block">
            <?php print theme('links', $secondary_links, array('class' => 'links secondary-links')); ?>
          </div>
        <?php endif; ?>      </div>
      <!-- footer bottom ends here -->

    </div>
    <!-- footer ends here -->

    </div><!-- page ends here -->

    <?php print $closure; ?>
      </body>
</html>


