<?php
// $Id: views-view-field.tpl.php,v 1.1 2008/05/16 22:22:32 merlinofchaos Exp $
 /**
  * This template is used to print a single field in a view. It is not
  * actually used in default Views, as this is registered as a theme
  * function which has better performance. For single overrides, the
  * template is perfectly okay.
  *
  * Variables available:
  * - $view: The view object
  * - $field: The field handler object that can process the input
  * - $row: The raw SQL result that can be used
  * - $output: The processed output that will normally be used.
  *
  * When fetching output from the $row, this construct should be used:
  * $data = $row->{$field->field_alias}
  *
  * The above will guarantee that you'll always get the correct data,
  * regardless of any changes in the aliasing that might happen if
  * the view is modified.
  */
?>

<?php $result = db_query("SELECT delta, field_terrexcept_value from {content_field_terrexcept} WHERE nid = %d", $row->nid);

/*while ( $obj = db_fetch_object ($result) ) {
  print $obj->delta." - ".$obj->field_terrexcept_value."<br/>";
}*/

$jeff = array();
$max = 0;
$gate = 0;
while ( $obj = db_fetch_object ($result)) {
$gate = (!$obj->field_terrexcept_value && $max == 0)?(1):(0);
  if ($obj->delta > $max) {$max = $obj->delta;}
  $jeff[$obj->delta] = $obj->field_terrexcept_value;
}

if ($gate==0){
for ($i=0;$i<=$max;$i++)	
{print $jeff[$i]."<br/>";}
}

?>