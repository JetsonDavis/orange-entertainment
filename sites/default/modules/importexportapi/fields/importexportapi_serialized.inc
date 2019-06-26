<?php
// $Id: importexportapi_serialized.inc,v 1.2 2006/08/29 17:10:19 jaza Exp $

/**
 * @file
 * Callback functions for the 'serialized' data definition field type.
 */

/**
 * Callback for processing of serialized field types.
 */
function importexportapi_process_serialized($field_id, $field, $format, $op, $source_get) {
  if ($format == 'xml' && $op == 'put') {
    if (!empty($field['#value'])) {
      $field['#value'] = unserialize($field['#value']);
    }
  }
  elseif ($source_get == 'xml' && $format == 'db') {
    $field['#value'] = serialize($field['#value']);
  }

  return $field;
}
