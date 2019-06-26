<?php
// $Id: views-view-gvs.tpl.php,v 1.1 2010/03/04 08:55:30 btomic Exp $
/**
 * @file
 */
?>
<?php
  drupal_add_js($inlinet, 'inline');
  drupal_add_css(drupal_get_path('module', 'views_jqgrid') .'/views_jqgrid.css');
  drupal_add_css(drupal_get_path('module', 'views_jqgrid') .'/jqgrid/themes/ui.jqgrid.css');
  drupal_add_css(drupal_get_path('module', 'views_jqgrid') .'/jqgrid/themes/'.$theme.'/jquery-ui-1.8.custom.css');
  
  drupal_add_js(drupal_get_path('module', 'views_jqgrid') .'/jqgrid/js/i18n/grid.locale-en.js');
  drupal_add_js(drupal_get_path('module', 'views_jqgrid') .'/jqgrid/js/jquery.jqGrid.min.js');
?>
<div class="view-jqgrid">
<table id="<?php echo $jqtable_id; ?>"></table> 
<div id="pager-<?php echo $jqtable_id; ?>"></div>
</div>