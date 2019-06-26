<?php
// $Id: gvs_style_plugin.inc,v 1.4 2010/03/26 16:05:04 btomic Exp $
/**
 * @file
 */

class views_jqgrid_style_plugin extends views_plugin_style {

  function option_definition() {
    $options = parent::option_definition();

    $options['columns'] = array('default' => array());
    $options['title'] = array('default' => 'Table name');
    $options['theme'] = array('default' => 'start');
    $options['width'] = array('default' => '300');
    $options['height'] = array('default' => '200');
    $options['rowList'] = array('default' => '10');
    $options['rownumbers'] = array('default' => TRUE);
    $options['viewrecords'] = array('default' => TRUE);
    $options['autowidth'] = array('default' => TRUE);
    $options['hiddengrid'] = array('default' => FALSE);
    $options['hidegrid'] = array('default' => TRUE);
    $options['multiselect'] = array('default' => FALSE);
    $options['scroll'] = array('default' => FALSE);
    
    
    return $options;
  }

  /**
   * Determine if we should provide sorting based upon $_GET inputs.
   */
  function build_sort() {
    if (!isset($_GET['order'])) {
      // check for a 'default' clicksort. If there isn't one, exit gracefully.
      if (empty($this->options['default'])) {
        return TRUE;
      }
      $sort = $this->options['default'];
      $this->order = !empty($this->options['order']) ? $this->options['order'] : 'asc';
    }
    else {
      $sort = $_GET['order'];
      // Store the $order for later use.
      $this->order = !empty($_GET['sort']) ? strtolower($_GET['sort']) : 'asc';
    }

    // If a sort we don't know anything about gets through, exit gracefully.
    if (empty($this->view->field[$sort])) {
      return TRUE;
    }

    // Ensure $this->order is valid.
    if ($this->order != 'asc' && $this->order != 'desc') {
      $this->order = 'asc';
    }

    // Store the $sort for later use.
    $this->active = $sort;

    // Tell the field to click sort.
    $this->view->field[$sort]->click_sort($this->order);

    // Let the builder know whether or not we're overriding the default sorts.
    return empty($this->options['override']);
  }
  
  function sanitize_columns($columns, $fields = NULL) {
    $sanitized = array();
    if ($fields === NULL) {
      $fields = $this->display->handler->get_option('fields');
    }

    // Preconfigure the sanitized array so that the order is retained.
    foreach ($fields as $field => $info) {
      // Set to itself so that if it isn't touched, it gets column
      // status automatically.
      $sanitized[$field] = $field;
    }

    foreach ($columns as $field => $column) {
      // first, make sure the field still exists.
      if (!isset($sanitized[$field])) {
        continue;
      }

      // If the field is the column, mark it so, or the column
      // it's set to is a column, that's ok
      if ($field == $column || $columns[$column] == $column && !empty($sanitized[$column])) {
        $sanitized[$field] = $column;
      }
      // Since we set the field to itself initially, ignoring
      // the condition is ok; the field will get its column
      // status back.
    }

    return $sanitized;
  }
  
  function options_form(&$form, &$form_state) {
    $handlers = $this->display->handler->get_handlers('field');
    if (empty($handlers)) {
      $form['error_markup'] = array(
        '#value' => t('You need at least one field before you can configure your table settings'),
        '#prefix' => '<div class="error form-item description">',
        '#suffix' => '</div>',
      );
      return;
    }

    $form['title'] = array(
        '#title' => t('Title'),
        '#type' => 'textfield',
        '#size' => 50,
        '#maxlength' => 50,
        '#default_value' => isset($this->options['title']) ? $this->options['title'] : '',
    );

    $form['width'] = array(
        '#title' => t('Width'),
        '#type' => 'textfield',
        '#description' => t('Chart width in px.'),
        '#size' => 4,
        '#maxlength' => 4,
        '#default_value' => isset($this->options['width']) ? $this->options['width'] : '300',
    );

    $form['height'] = array(
        '#title' => t('Height'),
        '#type' => 'textfield',
        '#description' => t('Chart height in px.'),
        '#size' => 4,
        '#maxlength' => 4,
        '#default_value' => isset($this->options['height']) ? $this->options['height'] : '200',
    );

    $form['theme'] = array(
        '#title' => t('Theme'),
        '#description' => t('Theme name.'),
        '#type' => 'select',
        '#options' => array(
        'start' => 'Start',
        'redmond' => 'Redmond',
        'cupertino' => 'Cupertino',
        'ui-darkness' => 'ui-darkness',
        'ui-lightness' => 'ui-lightness',
        ),
        '#default_value' => isset($this->options['theme']) ? $this->options['theme'] : 'start',
    );

    $form['rowList'] = array(
        '#title' => t('Row list'),
        '#description' => t('Select box element in the pager in which we can change the number of the visible rows'),
        '#type' => 'select',
        '#options' => array(
        '10' => '10, 20, 30',
        '25' => '25, 50, 100',
        '100' => '100, 250, 500',
        ),
        '#default_value' => isset($this->options['rowList']) ? $this->options['rowList'] : '10',
    );
    
    $form['rownumbers'] = array(
      '#type' => 'checkbox',
      '#title' => t('Show row number'),
      '#description' => t('If this option is set to true, a new column at left of the grid is added'),
      '#default_value' => !empty($this->options['rownumbers']),
    );

    $form['viewrecords'] = array(
      '#type' => 'checkbox',
      '#title' => t('View records'),
      '#description' => t('If true, jqGrid displays the beginning and ending record number in the grid, out of the total number of records in the query. This information is shown in the pager bar (bottom right by default)in this format: “View X to Y out of Z”'),
      '#default_value' => !empty($this->options['viewrecords']),
    );
    
    $form['autowidth'] = array(
      '#type' => 'checkbox',
      '#title' => t('Auto width'),
      '#description' => t('When set to true, the grid width is recalculated automatically to the width of the parent element. '),
      '#default_value' => !empty($this->options['autowidth']),
    );

    $form['hiddengrid'] = array(
      '#type' => 'checkbox',
      '#title' => t('Hide grid'),
      '#description' => t('If set to true the grid initially is hidden. The data is not loaded
(no request is made) and only the caption layer is shown. When click to show grid (first time only)
the data is loaded and grid is shown. '),
      '#default_value' => !empty($this->options['hiddengrid']),
    );

    $form['hidegrid'] = array(
      '#type' => 'checkbox',
      '#title' => t('Enable show/hide grid button'),
      '#description' => t('Enables or disables the show/hide grid button, which appears on the right side of the Caption layer. Takes effect only if the caption property is not an empty string.'),
      '#default_value' => !empty($this->options['hidegrid']),
    );

    $form['multiselect'] = array(
      '#type' => 'checkbox',
      '#title' => t('Enable multi select'),
      '#description' => t('If this flag is set to true a multi selection of rows is enabled. A new column at left side is added. Can be used with any datatype option.'),
      '#default_value' => !empty($this->options['multiselect']),
    );

    $form['scroll'] = array(
      '#type' => 'checkbox',
      '#title' => t('Dynamic scrolling grids'),
      '#description' => t('When enabled, the pager elements are disabled and we can use the vertical scrollbar to load data. When set to true the grid will always hold all the items from the start through to the latest point ever visited.'),
      '#default_value' => !empty($this->options['scroll']),
    );
    
    
    
    
    
    $form['#theme'] = 'views_jqgrid_style_plugin_jqgrid';
    $columns = $this->sanitize_columns($this->options['columns']);

    // Create an array of allowed columns from the data we know:
    foreach ($handlers as $field => $handler) {
      if ($label = $handler->label()) {
        $field_names[$field] = $label;
      }
      else {
        $field_names[$field] = $handler->ui_name();
      }
    }

    if (isset($this->options['default'])) {
      $default = $this->options['default'];
      if (!isset($columns[$default])) {
        $default = -1;
      }
    }
    else {
      $default = -1;
    }

    foreach ($columns as $field => $column) {
      $safe = str_replace(array('][', '_', ' '), '-', $field);
      // the $id of the column for dependency checking.
      $id = 'edit-style-options-columns-' . $safe;

      $form['columns'][$field] = array(
        '#type' => 'select',
        '#options' => $field_names,
        '#default_value' => $column,
      );
      if ($handlers[$field]->click_sortable()) {
        $form['info'][$field]['sortable'] = array(
          '#type' => 'checkbox',
          '#default_value' => !empty($this->options['info'][$field]['sortable']),
          '#process' => array('views_process_dependency'),
          '#dependency' => array($id => array($field)),
        );
        // Provide an ID so we can have such things.
        $radio_id = form_clean_id('edit-default-' . $field);
        $form['default'][$field] = array(
          '#type' => 'radio',
          '#return_value' => $field,
          '#parents' => array('style_options', 'default'),
          '#id' => $radio_id,
          // because 'radio' doesn't fully support '#id' =(
          '#attributes' => array('id' => $radio_id),
          '#default_value' => $default,
          '#process' => array('views_process_dependency'),
          '#dependency' => array($id => array($field)),
        );
      }
      $form['info'][$field]['width'] = array(
        '#type' => 'textfield',
        '#size' => 10,
        '#default_value' => isset($this->options['info'][$field]['width']) ? $this->options['info'][$field]['width'] : '',
        '#process' => array('views_process_dependency'),
        '#dependency' => array($id => array($field)),
      );
      $form['info'][$field]['separator'] = array(
        '#type' => 'textfield',
        '#size' => 10,
        '#default_value' => isset($this->options['info'][$field]['separator']) ? $this->options['info'][$field]['separator'] : '',
        '#process' => array('views_process_dependency'),
        '#dependency' => array($id => array($field)),
      );

      // markup for the field name
      $form['info'][$field]['name'] = array(
        '#value' => $field_names[$field],
      );
    }
    
    // Provide a radio for no default sort
    $form['default'][-1] = array(
      '#type' => 'radio',
      '#return_value' => -1,
      '#parents' => array('style_options', 'default'),
      '#id' => 'edit-default-0',
      '#default_value' => $default,
    );
    
  }
}