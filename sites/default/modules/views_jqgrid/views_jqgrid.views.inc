<?php
// By Jeff - This tells the views module information about the style plug-in
//           The actual plug-in is located in the file 'views_jqgrid_style_plugin.inc'
//           Views looks here for this info - modulename.views.inc


function views_jqgrid_views_plugins() {
  return array(
    'style' => array(
      'views_jqgrid' => array(
        'title' => t('JQGrid'),
        'theme' => 'views_view_views_jqgrid',
        'help' => t('views_jqgrid help.'),
        'handler' => 'views_jqgrid_style_plugin',
        'uses row plugin' => FALSE,
        'uses fields' => TRUE,
        'uses options' => TRUE,
        'type' => 'normal',
      ),
    ),
  );
}
