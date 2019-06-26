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
	<div id="sbox">
	<?php print $search_box; ?>
	</div>
      </div>
</div>
    <!-- header ends here -->


    <!-- content starts -->
    <div id="content-wrapper" class="container_16">

      <!-- main -->

     <div id="main" class="grid_16">
          <?php if (!empty($title)): ?><h1 class="title" id="page-title"><?php print $title; ?></h1><?php endif; ?>
          <?php if (!empty($tabs)): ?><div class="tabs"><?php print $tabs; ?></div><?php endif; ?>
          <?php if (!empty($messages)): print $messages; endif; ?>
          <?php if (!empty($help)): print $help; endif; ?>
	<div id="user_page">Orange Entertainment User List</div>
	<div id="user_page_p">You may contact another user by clicking on their profile and then the contact tab.</div>
	<br/>
<?php if (user_access('edit any film content')): ?>

	<a href="admin/user/user">Edit Users</a><br/><br/>

<?php endif; ?>
          <div id="content-content" class="clear-block">
            <?php print $content; ?>
          </div> <!-- /content-content -->

      </div> <!-- main ends here -->

      <!-- sidebars starts here -->

    </div>
</div>
    <!-- content ends here -->


    </div><!-- page ends here -->

    <?php print $closure; ?>
      </body>
</html>


