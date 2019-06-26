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
<script type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<head>
  <?php print $styles; ?>
  <?php print $scripts; ?>
  <script type="text/javascript"><?php /* Needed to avoid Flash of Unstyled Content in IE */ ?> </script>
</head>

<body id="front_body">
	
<div id="front_page">
<onload="MM_preloadImages('../sites/all/themes/mirjamstheme/images/menu_about_2.jpg','../sites/all/themes/mirjamstheme/images/menu_clients_2.jpg','../sites/all/themes/mirjamstheme/images/menu_aquisitions_2.jpg','../sites/all/themes/mirjamstheme/images/menu_contact_2.jpg','../sites/all/themes/mirjamstheme/images/menu_press_2.jpg','../sites/all/themes/mirjamstheme/images/menu_login_2.jpg')">

<?php if($is_admin): ?>
<div id="admin_left_sidebar" class ="admin_left">
	  <?php print $admin_left ?>
</div>
<?php endif; ?>

<div id="menus">
<div id="menu_home_2">
<a href="main.html"><img src="../sites/all/themes/mirjamstheme/images/menu_home_2.jpg" alt="" width="174" height="50" border="0"></a>
</div>

<div id="menu_about">
<a href="Outside_Site_Pages/about.html"><img src="../sites/all/themes/mirjamstheme/images/menu_about_1.jpg" alt="" width="174" height="48" border="0" id="Image1" onmouseover="MM_swapImage('Image1','','../sites/all/themes/mirjamstheme/images/menu_about_2.jpg',1)" onmouseout="MM_swapImgRestore()"></a>
</div>

<div id="menu_clients">
<a href="Outside_Site_Pages/clients.html"><img src="../sites/all/themes/mirjamstheme/images/menu_clients_1.jpg" alt="" width="174" height="52" border="0" id="Image2" onmouseover="MM_swapImage('Image2','','../sites/all/themes/mirjamstheme/images/menu_clients_2.jpg',1)" onmouseout="MM_swapImgRestore()"></a>
</div>

<div id="menu_press">
<a href="Outside_Site_Pages/press.html"><img src="../sites/all/themes/mirjamstheme/images/menu_press_1.jpg" alt="" width="174" height="49" border="0" id="Image5" onmouseover="MM_swapImage('Image5','','../sites/all/themes/mirjamstheme/images/menu_press_2.jpg',1)" onmouseout="MM_swapImgRestore()"></a>
</div>

<div id="menu_aq">
<a href="Outside_Site_Pages/acquisitions.html"><img src="../sites/all/themes/mirjamstheme/images/menu_aquisitions_1.jpg" alt="" width="174" height="51" border="0" id="Image3" onmouseover="MM_swapImage('Image3','','../sites/all/themes/mirjamstheme/images/menu_aquisitions_2.jpg',1)" onmouseout="MM_swapImgRestore()"></a>
</div>

<div id="menu_contact">
<a href="Outside_Site_Pages/contact.html"><img src="../sites/all/themes/mirjamstheme/images/menu_contact_1.jpg" alt="" width="174" height="44" border="0" id="Image4" onmouseover="MM_swapImage('Image4','','../sites/all/themes/mirjamstheme/images/menu_contact_2.jpg',1)" onmouseout="MM_swapImgRestore()"></a>
</div>

<div id="menu_login">
<a href="../splashpage"><img src="../sites/all/themes/mirjamstheme/images/menu_login_1.jpg" alt="" width="174" height="44" border="0" id="Image6" onmouseover="MM_swapImage('Image6','','../sites/all/themes/mirjamstheme/images/menu_login_2.jpg',1)" onmouseout="MM_swapImgRestore()"></a>
</div>

</div>

        <!-- left sidebar starts here -->

        <!-- left sidebar ends here -->

    <!-- content starts -->

      <!-- main -->

     <div id="main" class="grid_10">

          <div id="content-content" class="clear-block">
	<div id="admin_stuff">
			<?php if (!empty($messages)): print $messages; endif; ?>
			  <?php if (!empty($tabs) AND $is_admin): ?><div class="tabs"><?php print $tabs; ?></div><?php 		endif; ?>
</div>
<div id="awards">Awards:</div>
<div id="company_blurb"><?php print $node->field_field1[0]['view']?></div>
<div id="recent_aqs"><p><?php print $node->field_field2[0]['view']?><p></div>
<div id="awards_list"><?php print $node->field_field3[0]['view']?></div>
          </div> <!-- /content-content -->

          <?php print $feed_icons; ?>
      </div> <!-- main ends here -->

      <!-- sidebars starts here -->

    <!-- content ends here -->
<img id="movieposters" src="../sites/all/themes/mirjamstheme/images/moviepostersfooter.gif" alt="movie posters">
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
</div>
    <?php print $closure; ?>
      </body>
</html>
