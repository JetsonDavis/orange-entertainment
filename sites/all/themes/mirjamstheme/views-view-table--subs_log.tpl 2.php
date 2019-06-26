<?php
// $Id: views-view-table.tpl.php,v 1.8 2009/01/28 00:43:43 merlinofchaos Exp $
/**
 * @file views-view-table.tpl.php
 * Template to display a view as a table.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $class: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: An array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 * @ingroup views_templates
 */
?>

<table class="<?php print $class; ?>">
  <?php if (!empty($title)) : ?>
    <caption><?php print $title; ?></caption>
  <?php endif; ?>

  <thead>
    <tr>
      <?php foreach ($header as $field => $label):
		if (($fields[$field] == "field-tracking-value" && !user_access('delete any film content')) ||  
		$fields[$field] == "field-allpass-value" || $fields[$field] == "field-filmlist-value" || $fields[$field] == "field-scriptlog-value")
		{ 
		}
		else
		{
        	print '<th class="views-field views-field-'. $fields[$field].'">'.$label ."</th>"; }
      endforeach; 
?>
    </tr>
  </thead>
  <tbody>
	<!-- -->
    <?php foreach ($rows as $count => $row): ?>
      <tr class="<?php print implode(' ', $row_classes[$count]). '">';
        	$output="";
		foreach ($row as $field => $content): 
			if (($fields[$field] == "field-tracking-value" && !user_access('delete any film content')) ||  
			    $fields[$field] == "field-allpass-value" || $fields[$field] == "field-filmlist-value" || 				    $fields[$field] == "field-scriptlog-value")
			{
				if ($fields[$field] == "field-allpass-value" && $content == "All Pass") {$output .= "<span style='color:green'>All Pass</span><br/>";}
				if ($fields[$field] == "field-filmlist-value" && $content == "Film List") {$output .= "<span style='color:blue'>Film List</span><br/>";}
				if ($fields[$field] == "field-scriptlog-value" && $content == "Script Log") {$output .= "<span style='color:orange'>Script Log</span><br/>";}
			}
		else	
		{
print "<td class='views-field views-field-". $fields[$field] ."'>";

if ($fields[$field]=="field-logline-value") {$jeff = substr($content,0, strlen($content));}
if ($fields[$field]=="field-tracking-value")
	{
	if ($content!="Tracking") {print $output;}
	else {print $output."Tracking";}
	$output = "";
	}
if ($fields[$field]!="field-tracking-value"){
print "hi".(user_access('edit any film content'))?("TRUE"):("FALSE");
print (stripos($content,"a href=")==1 && user_access('edit any film content') && ($fields[$field] =="title" || $fields[$field] =="title active")) 
? (substr($content,0,stripos($content,">") -1)."/edit".substr($content,stripos($content,">")-1,strlen($content) - stripos($content,">")+1)).'&nbsp&nbsp<a href="javascript:;"  class="tooltip"><strong id="ques">Log Line</strong><span>'.$jeff.'</span></a>'
:($content);}

          echo '</td>';
}  endforeach; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>