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
<?php 
$result = db_query("SELECT title, nid FROM node WHERE nid in (SELECT field_fest_nid FROM content_field_fest INNER JOIN node on node.nid = content_field_fest.nid where content_field_fest.nid=%d) ",$row->nid);
$i = 0;
while ( $obj = db_fetch_object ($result)) {
	print "<div class=".'"'."field-item field-item-".$i.'"><a href="/node/'.$obj->nid.'">'.$obj->title."</a></div>";
	$i++;}
//print $output;
?>
