<?php
// $Id: importexportapi_userreference.inc,v 1.1 2006/08/12 08:00:06 jaza Exp $

/**
 * @file
 * Implements data definitions on behalf of userreference.module.
 */

/**
 * Implementation of hook_content_def_references().
 */
function userreference_content_def_references(&$field_def, $field_info) {
  static $reference_delta = 1;

  if ($field_info['type'] == 'userreference') {
    $field_def['#reference_entity'] = 'user';
    $field_def['#reference_field'] = array('uid');
    $field_def['#reference_delta'] = $reference_delta;

    $reference_delta++;
  }
}
