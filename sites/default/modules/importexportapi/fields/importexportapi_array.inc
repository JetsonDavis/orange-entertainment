<?php
// $Id: importexportapi_array.inc,v 1.2 2006/08/29 17:10:19 jaza Exp $

/**
 * @file
 * Callback functions for the 'array' data definition field type.
 */

/**
 * Callback for processing of array field types.
 */
function importexportapi_process_array($field, $data, $format, $op, $source_get) {
  if ($op == 'get') {
    // Remove all fields that are children of array fields, since they have
    // been copied to the '#value' attribute of each copy of each array
    // field.
    foreach (element_children($data) as $child) {
      unset($data[$child]);
    }
  }

  return $data;
}
