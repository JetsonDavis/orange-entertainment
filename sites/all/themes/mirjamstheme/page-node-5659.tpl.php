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

      </div>

    <!-- header ends here -->


    <!-- content starts -->
    <div id="content-wrapper" class="container_16">

      <!-- main -->

     <div id="main" class="grid_16">
			<?php $output = '<p>'. t('The following is a demonstration of <a href="@flowplayer">Flowplayer</a>. Note that you can change the defaults of how it looks in the <a href="@settings">Flowplayer settings</a>.', array('@flowplayer' => 'http://flowplayer.org', '@settings' => url('admin/settings/flowplayer'))) .'</p>';
		      $output .= '<p>'. t("To create Flowplayer elements, you can either use the theme('flowplayer') function, or the flowplayer_add() function. The theme function will add the JavaScript to the page, as well as create the markup for you, while the <code>flowplayer_add()</code> function will just add the JavaScript.") .'</p>';

		      /**
		       * Theme Function
		       */
		      $output .= '<h3>'. t('Theme Funciton') .'</h3>';
		      $output .= '<p>'. t("Calling <code>theme('flowplayer')</code> will not only add the correct JavaScript to the page, but also construct the markup for you. The second argument passed through here is the video URL, but you can pass the <a href='http://flowplayer.org/documentation/configuration.html'>configuration options</a> instead as seen below.") .'</p>';
		      // Construct the video and output it using theme('flowplayer').
		      $output .= theme('flowplayer', 'http://e1h13.simplecdn.net/flowplayer/flowplayer.flv');
		      // The second parameter can either be the video URL or configuration options from:
		      //   http://flowplayer.org/documentation/configuration.html

		      /**
		       * Flowplayer Add
		       */
		      $output .= '<h3>'. t('Flowplayer Add') .'</h3>';
		      $output .= '<p>'. t("The <code>flowplayer_add()</code> function will add the Flowplayer JavaScript to the page, as well as register the Drupal JavaScript behaviors to load the Flowplayer appropriately. The first argument is the jQuery selector to apply the Flowplayer element to. The second argument is the <a href='http://flowplayer.org/documentation/configuration.html'>configuration options</a>. Using <code>flowplayer_add</code> requires you to already have the markup created.") .'</p>';
		      // Construct the video markup first.
		      $output .= '<a href="http://e1h13.simplecdn.net/flowplayer/flowplayer.flv" id="player" class="flowplayer"></a>';
		      // Now add the required JavaScript using some configuration options (http://flowplayer.org/documentation/configuration.html).
		      flowplayer_add('#player', array(
		        'clip' => array(
		          'autoPlay' => FALSE,
		          'linkUrl' => 'http://flowplayer.org',
		        ),
		      ));
			print ($output);  ?>
          <?php if (!empty($title)): ?><span id="film_title" id="page-title"><?php print $title; ?></span><?php endif; ?>
<?php if($node->field_tracking[0]['view'] == "Tracking") {print "&nbsp&nbsp<span id='tracking'>Tracking</span>";} ?>

<?php 
for ($i=0;$i < sizeof($node->field_fest); $i++)
	{
		
		if ($node->field_fest[$i]['nid'] == variable_get('global_fest',0)) {
			$result = db_query("SELECT title FROM {node} WHERE nid=%d",$node->field_fest[$i]['nid'] );
			$obj = db_fetch_object($result);
			print "<div id='fest_info'>".$obj->title. " -".$node->field_festprogram[$i]['value']."</div>";}
	}
?>



          <?php if (!empty($tabs)): ?><div class="tabs"><?php print $tabs; ?></div><?php endif; ?>
          <?php if (!empty($messages)): print $messages; endif; ?>
          <?php if (!empty($help)): print $help; endif; ?>
          <div id="content-content" class="clear-block">
            <?php print $content; ?>
          </div> <!-- /content-content -->
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


