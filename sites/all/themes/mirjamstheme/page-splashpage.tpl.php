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
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <?php print $styles; ?>
  <?php print $scripts; ?>
  <script type="text/javascript"><?php /* Needed to avoid Flash of Unstyled Content in IE */ ?> </script>
</head>

<body class="container_16">
	
	<?php if($is_admin): ?>
	<div id="admin_left_sidebar" class ="admin_left">
		  <?php print $admin_left ?>
	</div>
	<?php endif; ?>


<div id="login" class="grid_4"><?php print $login ?></div>

<?php if ($logged_in): ?>
    <!-- header starts-->
    <div id="header-wrap">
     <div id="header">

      <div id="nav">
          <?php print theme('links',$primary_links, array('class' => 'links primary-links')); ?>
      </div>

     </div><!-- header -->
</div><!-- header wrap -->

   <div id="content-wrapper-splashpage"><!-- content starts -->
     <!-- main -->
     <div id="main-splashpage" class="grid_16">
		<?php if (!empty($messages)): print $messages; endif; ?>
		<?php if (!empty($tabs) AND $is_admin): ?><div class="tabs"><?php print $tabs; ?></div><?php endif; ?>
		<div class="grid_3">
			<div class="left_sidebar">
				<?php print $left ?>
			</div>
		</div>
        <div class="grid_12">
			<div id="content-content" class="clear-block">
				<div id="mirjam_pix_wrapper">
				<img src="../sites/all/themes/mirjamstheme/images/mirjam_pix.jpg" alt="" id="mirjam_pix">
				</div>
				<div id="from_desk_of"><?php print "From the Desk of Mirjam Werheim" ?></div>
				<div id="splashpage_note"><?php print $node->field_field1[0]['view'] . "</br>"?></div>
			</div>
		</div>
<!-->
		<div class="grid_3">
			<div class="right_sidebar">
				<?php print $right ?>
			</div>
		</div> 
-->
	 <!-- /content-content -->
		
     </div> <!-- main ends here -->


     <?php print $feed_icons; ?>
    </div><!-- content-wrapper -->


    <!-- footer starts here -->
    <div id="footer-wrapper">

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
<?php endif ?>
    </div><!-- page ends here -->

    <?php print $closure; ?>
      </body>
</html>


