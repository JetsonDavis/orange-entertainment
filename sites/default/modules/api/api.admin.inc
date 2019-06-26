<?php
// $Id:

function api_page_admin_form() {
  $branches = api_get_branches();
  $form = array();

  if (count($branches) > 0) {
    $form['branches'] = array(
      '#theme' => 'api_branch_table',
    );
    foreach ($branches as $branch) {
      $form['branches'][$branch->branch_name]['default_branch'] = array(
        '#type' => 'radio',
        '#default_value' => variable_get('api_default_branch', NULL),
        '#return_value' => $branch->branch_name,
      );
      $form['branches'][$branch->branch_name]['title'] = array(
        '#value' => l($branch->title, 'admin/settings/api/branches/'. $branch->branch_name),
      );
      $form['branches'][$branch->branch_name]['branch_name'] = array(
        '#value' => $branch->branch_name,
      );
      $form['branches'][$branch->branch_name]['directories'] = array(
        '#value' => str_replace("\n", '<br />', check_plain($branch->directories)),
      );
    }
  }
  else {
    $form['branches'] = array(
      '#value' => '<p><em>'. t('There are no branches yet. You can <a href="@url">add a branch</a>.', array('@url' => url('admin/settings/api/branches/new'))) .'</em></p>',
    );
  }

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save changes'),
  );

  return $form;
}

function theme_api_branch_table($element) {
  $header = array(
    t('Default'),
    t('Page label'),
    t('URL label'),
    t('Directories'),
  );
  $rows = array();
  foreach (element_children($element) as $key) {
    $row = array();
    foreach (element_children($element[$key]) as $child) {
      $row[] = drupal_render($element[$key][$child]);
    }
    $rows[] = $row;
  }
  return theme('table', $header, $rows);
}

function api_page_admin_form_submit($form, &$form_state) {
  if (!empty($form_state['values']['default_branch'])) {
    variable_set('api_default_branch', $form_state['values']['default_branch']);
  }

  // We may have menu changes, so clear the menu cache for all users.
  cache_clear_all('*', 'cache_menu', TRUE);

  drupal_set_message(t('Changes saved.'));
}

function api_branch_edit_form($form_state, $branch_name = NULL) {
  $branches = api_get_branches();
  if (is_null($branch_name)) {
    $branch->branch_name = '';
    $branch->title = '';
    $branch->directories = '';
    $branch->excluded_directories = '';
  }
  else {
    $branch = $branches[$branch_name];
  }
  $form = array();

  $form['branch_name'] = array(
    '#title' => t('URL label'),
    '#type' => 'textfield',
    '#default_value' => $branch->branch_name,
    '#required' => TRUE,
  );
  $form['title'] = array(
    '#title' => t('Page label'),
    '#type' => 'textfield',
    '#default_value' => $branch->title,
    '#required' => TRUE,
  );
  $form['directories'] = array(
    '#title' => t('Directories'),
    '#type' => 'textarea',
    '#default_value' => $branch->directories,
    '#rows' => 3,
    '#description' => t('Absolute paths to index, one per line.'),
    '#required' => TRUE,
    '#element_validate' => array('api_check_directories'),
  );
  $form['excluded_directories'] = array(
    '#title' => t('Excluded directories'),
    '#type' => 'textarea',
    '#default_value' => $branch->excluded_directories,
    '#rows' => 3,
    '#description' => t('Absolute paths to exclude from the index, one per line.'),
    '#element_validate' => array('api_check_directories'),
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save branch'),
  );
  if (!is_null($branch_name)) {
    $form[] = array(
      '#value' => l(t('Delete'), 'admin/settings/api/branches/'. $branch->branch_name .'/delete'),
    );
  }

  return $form;
}

function api_branch_edit_form_validate($form, &$form_state) {
  // Check for bad characters in branch names.
  if (preg_match('/[^A-Za-z0-9-_.]/', $form_state['values']['branch_name'])) {
    form_set_error('branch_name', t("Only letters, numbers, '.', '-' and '_' are allowed in the URL label."));
  }

  // Check for duplicate branch names.
  $branches = api_get_branches();
  if (!empty($form['branch_name']['#default_value'])) {
    unset($branches[$form['branch_name']['#default_value']]);
  }
  if (isset($branches[$form_state['values']['branch_name']])) {
    form_set_error('branch_name', t('%branch_name is already used by another branch.', array('%branch_name' => $form_state['values']['branch_name'])));
  }
}

function api_check_directories($element, &$form_state) {
  // Check for valid directories.
  foreach (explode("\n", $form_state['values'][$element['#name']]) as $directory) {
    $directory = trim($directory);
    if (!empty($directory)) {
      if (!is_dir($directory)) {
        form_set_error($element['#name'], t('%directory is not a directory.', array('%directory' => $directory)));
      }
      elseif (!is_readable($directory)) {
        form_set_error($element['#name'], t('%directory is not readable by PHP.', array('%directory' => $directory)));
      }
    }
  }
}

function api_branch_edit_form_submit($form, &$form_state) {
  $branch->branch_name = $form_state['values']['branch_name'];
  $branch->title = $form_state['values']['title'];
  $branch->directories = api_clean_directory_list($form_state['values']['directories']);
  $branch->excluded_directories = api_clean_directory_list($form_state['values']['excluded_directories']);

  api_save_branch($branch, $form['branch_name']['#default_value']);

  drupal_set_message(t('Saved %branch_name.', array('%branch_name' => $branch->branch_name)));
  $form_state['redirect'] = 'admin/settings/api';
}

/**
 * Trim whitespace, trailing directory separators, and remove blank lines.
 */
function api_clean_directory_list($list) {
  $array = explode("\n", $list);
  foreach ($array as $key => $directory) {
    $array[$key] = rtrim(trim($directory), DIRECTORY_SEPARATOR);
    if (empty($array[$key])) {
      unset($array[$key]);
    }
  }
  return implode("\n", $array);
}

function api_branch_delete_form($form_state, $branch_name) {
  $form = array();
  $form['branch_name'] = array(
    '#type' => 'value',
    '#value' => $branch_name,
  );
  return confirm_form($form, t('Are you sure you want to delete %branch_name?', array('%branch_name' => $branch_name)), 'admin/settings/api', NULL, t('Delete'));
}

function api_branch_delete_form_submit($form, &$form_state) {
  $result = db_query("SELECT did FROM {api_documentation} WHERE branch_name = '%s'", $form['branch_name']['#value']);
  $dids = array();
  while($did = db_fetch_object($result)) {
    $dids[] = $did->did;
  }
  $placeholders = db_placeholders($dids);

  db_query("DELETE FROM {api_file} WHERE did IN (". $placeholders .")", $dids);
  db_query("DELETE FROM {api_function} WHERE did IN (". $placeholders .")", $dids);
  db_query("DELETE FROM {api_reference_storage} WHERE from_did IN (". $placeholders .") OR to_did IN (". $placeholders .")", array_merge($dids, $dids));
  db_query("DELETE FROM {api_documentation} WHERE did IN (". $placeholders .")", $dids);
  db_query("DELETE FROM {api_branch} WHERE branch_name = '%s'", $form['branch_name']['#value']);

  if (variable_get('api_default_branch', NULL) == $form['branch_name']['#value']) {
    variable_set('api_default_branch', NULL);
  }

  menu_rebuild();
  $form_state['redirect'] = 'admin/settings/api';
}

function api_php_manual_index_form() {
  $form = array();
  $form['api_php_funcsummary'] = array(
    '#type' => 'textfield',
    '#default_value' => variable_get('api_php_funcsummary', 'http://cvs.php.net/viewvc.cgi/phpdoc/funcsummary.txt?view=co'),
    '#description' => t('The URL of the PHP function summary document.'),
  );
  $form['api_php_funcpath'] = array(
    '#type' => 'textfield',
    '#default_value' => variable_get('api_php_funcpath', 'http://php.net/!function'),
    '#description' => t('The URL format used to build the link to php functions.  Use the variable <em>!function</em> in place of the function name.'),
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Index PHP manual pages'),
  );
  return $form;
}

function api_php_manual_index_form_submit($form, &$form_state) {
  include_once(drupal_get_path('module', 'api') .'/parser.inc');
  variable_set('api_php_funcsummary', $form_state['values']['api_php_funcsummary']);
  variable_set('api_php_funcpath', $form_state['values']['api_php_funcpath']);
  db_query("DELETE FROM {api_documentation} WHERE branch_name = 'php'");
  api_parse_php_manual($form_state['values']['api_php_funcsummary']);
  drupal_set_message(t('Manual pages scanned.'));
}

function api_comments_settings_form(&$form_state) {
  $type = new stdClass();
  $type->type = 'api';
  $form = array(
    '#node_type' => $type,
    'identity' => array(
      'type' => array(
        '#type' => 'value',
        '#value' => 'api',
      ),
    ),
  );
  comment_form_alter($form, $form_state, 'node_type_form');
  unset($form['comment']['#type']);
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save comment settings'),
  );

  return $form;
}

function api_comments_settings_form_submit($form, &$form_state) {
  foreach ($form_state['values'] as $key => $value) {
    if (strpos($key, 'comment') === 0) {
      variable_set($key . '_api', $value);
    }
  }
  drupal_set_message(t('Saved API comment settings.'));
}
