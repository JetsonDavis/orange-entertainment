<?php

/**
 * Implementation of template_preprocess
 */
function template_preprocess_views_view_views_jqgrid(&$vars) {
//dsm($vars);
//print $vars['view']->args[0];
  $is_live_preview = !(stristr($_SERVER['REDIRECT_URL'], '/admin/build/views/ajax/preview/') === FALSE);
  if ($is_live_preview){
    drupal_set_message(t('Live preview is not supported for jqgrid'));
    return;
  }
// preprocess css information for the template
  $view = $vars['view'];
  $no_of_rows=count($view->result);
  $basetable=$view->base_table;
  $vars['divh']=$vars['options']['height'];
  $vars['divw']=$vars['options']['width'];
  $vars['theme']=$vars['options']['theme'];
  $vars['rowNum']=$vars['options']['rowList'];
  
  if ($vars['rowNum'] == '') $vars['rowNum']=10;
  switch ($vars['rowNum']) {
    case '10':
        $vars['rowList']  = '10, 20, 30';
        break;
    case '25':
        $vars['rowList']  = '15, 50, 100';
        break;
    case '100':
        $vars['rowList']  = '100, 250, 500';
        break;
    default:
        $vars['rowList']  = '10, 20, 30';
        break;
  } 

  $vars['rownumbers'] = $vars['options']['rownumbers'] ? 'true' : 'false';
  $vars['viewrecords'] = $vars['options']['viewrecords'] ? 'true' : 'false';
  $vars['autowidth'] = $vars['options']['autowidth'] ? 'true' : 'false';
  $vars['hiddengrid'] = $vars['options']['hiddengrid'] ? 'true' : 'false';
  $vars['hidegrid'] = $vars['options']['hidegrid'] ? 'true' : 'false';
  $vars['multiselect'] = $vars['options']['multiselect'] ? 'true' : 'false';
  $vars['scroll'] = $vars['options']['scroll'] ? 'true' : 'false';
  
  
  if ($vars['divh'] == '') $vars['divh']=200;
  if ($vars['divw'] == '') $vars['divw']=300;
  $pattern = "/^([0-9])+$/";
  if (!preg_match($pattern, $vars['divh'])) $vars['divh']=200;
  if (!preg_match($pattern, $vars['divw'])) $vars['divw']=300;

  // Make DIV instance
  $vars['jqtable_id'] = 'views_jqgrid-'. $view->name  . '-'. $view->current_display;
  $vars['cwidth'] = $vars['options']['width'];
  $vars['cheight'] = $vars['options']['height'];
  
  $options  = $view->style_plugin->options;
  $handler  = $view->style_plugin;

  $fields   = &$view->field;
  $columns  = $handler->sanitize_columns($options['columns'], $fields);

  $active   = !empty($handler->active) ? $handler->active : '';
  $order    = !empty($handler->order) ? $handler->order : 'asc';

  $query    = tablesort_get_querystring();
  if ($query) {
    $query = '&' . $query;
  }
  
  $colNames = '';
  $colModel = ''; 
  foreach ($columns as $field => $column) {
    // render the header labels
    if ($field == $column && empty($fields[$field]->options['exclude'])) {
      $label = check_plain(!empty($fields[$field]) ? $fields[$field]->label() : '');
      $colNames .= "'" . $label . "',";
      $colum_id = $fields[$field]->options['id'];
      
      if (empty($options['info'][$field]['width'])) {
        $width = '100';
      } else {
        $width = $options['info'][$field]['width'];
      }
      $sortable = (empty($options['info'][$field]['sortable']) || !$fields[$field]->click_sortable()) ? 'false' : 'true';
      $colModel .= 
        "{name:'" . $colum_id . 
        "', index:'" . $colum_id . 
        "', width:'" . $width . 
        "', align:'left', editable:true
        , sortable:" . $sortable. "},";
    }
  }

  $get_parms = '';
  $exposed_input = $view->get_exposed_input();
  foreach ($exposed_input as $filter_name => $filter_value) {
    $get_parms .= '&' . $filter_name . '=' . $filter_value;
  }
 $jeff = '&vid='.drupal_urlencode($vars['view']->args[0]);
//print $jeff;
  $url = '/views_jqgrid?view_name='.$view->name.'&view_display_id='.$view->current_display.$jeff. $get_parms;
  $inlinet="
    var lastsel;
				
    jQuery(document).ready(function(){ 
      jQuery('#" . $vars['jqtable_id'] . "').jqGrid({
        url:'".$url."',
		editurl: '/post_back',
        pager: '#pager-".$vars['jqtable_id']."',
        datatype: 'json',
        mtype: 'GET',
        sortable: true,
        prmNames: {sort:'order', order:'sort'},
        rownumbers: "  . $vars['rownumbers']  .",
        viewrecords: " . $vars['viewrecords'] .", 
        autowidth: "   . $vars['autowidth']   .",
        rowNum:"       . $vars['rowNum']      .",
        hiddengrid:"   . $vars['hiddengrid']  .",
        hidegrid: "    . $vars['hidegrid']    .",
        multiselect: " . $vars['multiselect'] .",
        scroll: "      . $vars['scroll']      .",
        rowList:["     . $vars['rowList']     ."], 
        colNames:["    . $colNames            ."],
        colModel :["   . $colModel            ."], 
        width: "       . $vars['divw']        .",
        height: "      . $vars['divh']        . ",
        caption: '"    . $options['title']    ."',
		shrinkToFit:   false,
	    onSelectRow: function(id){
			if(id && id!==lastsel){
				jQuery('#" . $vars['jqtable_id']."').jqGrid('restoreRow',lastsel);
				jQuery('#" . $vars['jqtable_id']."').jqGrid('editRow',id,true);
				lastsel=id;
				}
			},
      });
		  jQuery('.ui-jqgrid-titlebar').click(function () {jQuery('#" . $vars['jqtable_id']."').jqGrid('restoreRow',lastsel);});
    });
  ";
  $vars['inlinet'] = $inlinet;
//dsm($vars);
}

/**
 * Overridable theme function.
 * This functions prints a warning when no data is available.
 */
function theme_views_jqgrid_nodata() {
  drupal_set_message(t('There is no data available'), 'warning');
}
