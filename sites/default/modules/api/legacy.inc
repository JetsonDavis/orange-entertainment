<?php

function api_file_redirect() {
  $args = func_get_args();
  $branches = api_get_branches();
  $suffix = '';
  $file = new StdClass();
  $file->object_type = 'file';
  $file->branch_name = variable_get('api_default_branch', NULL);

  $end = count($args) - 1;
  if (in_array($args[$end], array('source', 'documentation'))) {
    $suffix = '/' . $args[$end];
    $end -= 1;
  }
  if (isset($branches[$args[$end]])) {
    $file->branch_name = $branches[$args[$end]]->branch_name;
    $end -= 1;
  }
  $file->object_name = implode('/', array_slice($args, 0, $end - 0 + 1));

  drupal_goto(api_url($file) . $suffix);
}
