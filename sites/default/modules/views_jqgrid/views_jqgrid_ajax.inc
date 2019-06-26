<?php

/**
 * Menu callback to load a view via AJAX.
 */
function views_jqgrid_get_items() {

  if (isset($_REQUEST['view_name']) && isset($_REQUEST['view_display_id'])) {  
    $name = $_REQUEST['view_name'];
    $display_id = $_REQUEST['view_display_id'];

	$arg = $_REQUEST['vid'];
	
    $page = $_REQUEST['page'];  // get the requested page
    $limit = ($_REQUEST['rows'])?$_REQUEST['rows']:'0'; // get how many rows we want to have into the grid

    // Load the view.
    if ($view = views_get_view($name)) {
      if ($view->access($display_id)) {
        $view->set_display($display_id);
		$view->set_arguments($arg);
        $view->set_items_per_page($limit);
        $view->is_cacheable = FALSE;
        $view->get_total_rows = TRUE;
        $view->pager['current_page'] = $page - 1;
        $view->render($display_id);
        $result = $view->result;
//dsm($view);

        $vars['rows'] = array();
        $options  = $view->style_plugin->options;
        $handler  = $view->style_plugin;
        $fields   = &$view->field;
        $columns  = $handler->sanitize_columns($options['columns'], $fields);
        
        // Fields must be rendered in order as of Views 2.3, so we will pre-render
        // everything.
        $renders = array();
        
        $keys = array_keys($view->field);
        foreach ($result as $count => $row) {
          foreach ($keys as $id) {
            //$renders[$count][$id] = $view->field[$id]->theme($row);
            $renders[$count][$id] = $view->style_plugin->rendered_fields[$count][$id];
            
          }
        }
        foreach ($columns as $field => $column) {
          // Create a second variable so we can easily find what fields we have and what the
          // CSS classes should be.
          $vars['fields'][$field] = views_css_safe($field);
          if ($active == $field) {
            $vars['fields'][$field] .= ' active';
          }

          // Render each field into its appropriate column.
          foreach ($result as $num => $row) {
            if (!empty($fields[$field]) && empty($fields[$field]->options['exclude'])) {
              $field_output = $renders[$num][$field];

              // Don't bother with separators and stuff if the field does not show up.
              if (empty($field_output) && !empty($vars['rows'][$num][$column])) {
                continue;
              }

              // Place the field into the column, along with an optional separator.
              if (!empty($vars['rows'][$num][$column])) {
                if (!empty($options['info'][$column]['separator'])) {
                  $vars['rows'][$num][$column] .= filter_xss_admin($options['info'][$column]['separator']);
                }
              }
              else {
                $vars['rows'][$num][$column] = '';
              }

              $vars['rows'][$num][$column] .= $field_output;
            }
          }
        }
        
        $count = $view->total_rows;
        if( $count > 0 ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;
        if ($start<0) $start = 0;
        
        // Construct the json data
        $response = array();
        $response['page'] = $page; // current page
        $response['total'] = $total_pages; // total pages
        $response['records'] = $count; // total records

        $i=0;
        foreach ($vars['rows'] as $row) {
          foreach ($row as $field) {
            $response['rows'][$i]['cell'][]=$field;
          }
          $i++;
        }  
//dsm($response);
        return drupal_json($response);
      }  
    }    
  }
}