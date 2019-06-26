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
	
  <?php 

print $head; 
global $user;?>
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
	
	
	<?php global $user;?>

		<?php if (!empty($messages)): print $messages; endif; ?>
		<?php if (!empty($tabs) AND ($is_admin || $user->name=="Mirjam")): ?><div class="tabs"><a href="printmail/1107">Send Email Newsletter</a><br/><?php print $tabs; ?></div><?php endif; ?>
		<?php if (!($is_admin || $user->name=="Mirjam")): print "&nbsp<br/>&nbsp<br/>&nbsp<br/>&nbsp<br/>"; endif; ?>
		<div class="grid_4">
			<div class="hdr">Film News</div><br/>
			<div class="left_sidebar">
				<script src="http://widgets.twimg.com/j/2/widget.js"></script>
				<script>
				new TWTR.Widget({
				  version: 2,
				  type: 'list',
				  rpp: 15,
				  interval: 5000,
				  title: ' ',

				  width: 200,
				  height: 500,
				  theme: {
				    shell: {
				      background: '#dc8c2c',
				      color: '#ffffff'
				    },
				    tweets: {
				      background: '#ffffff',
				      color: '#444444',
				      links: '#1573e6'
				    }
				  },
				  features: {
				    scrollbar: true,
				    loop: true,
				    live: true,
				    hashtags: true,
				    timestamp: true,
				    avatars: true,
				    behavior: 'default'
				  }
				}).render().setList('mirjam_orange_w', 'film-news').start();
				</script>
			</div>
			
		</div>
        <div class="grid_11">


	<!-- ><video controls="" autoplay="" style="margin: auto; position: absolute; top: 0; right: 0; bottom: 0; left: 0;" name="media" src="http://localhost:8888/sites/all/themes/mirjamstheme/test_video.flv"></video> -->
	

			<div id="content-content" class="clear-block">
				<div class="hdr"><?php print "Latest Film Submissions" ?></div><br/>
				<div class="right_sidebar"><?php print $right;?></div>
			</div>
		</div>
<!-->
		<div class="grid_3">
	
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


