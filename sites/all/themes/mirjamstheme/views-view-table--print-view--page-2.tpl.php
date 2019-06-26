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

// View for Print x Terr

// Build array
print "<p id='group_head'>";

$fest_nid = variable_get('film_fest_set',0);

$tr = variable_get('territory_searched',0);
if ($tr =="All")
{
	print "All territories"."<br/><br/><br/>";
	$current_territory = "All";
}
else
{$result = db_query("SELECT title FROM {node} WHERE type = 'allowed_territories' LIMIT 1 OFFSET %d",$tr);
$obj = db_fetch_object($result);
$current_territory = $obj->title;
print "Territory:  ".$current_territory."<br/><br/>";
}

foreach ($rows as $count => $row):

	$jeff = array();
	$tle = '';
	$log_line = '';
	$nid = '';
	$notes = '';
	$screenings = '';
	$left = 0;
	$right = 0;
	$terr = array();
	$terr_count = 0;
	$terr_active = -2;
	$sold_to = "";
	$i=0;
	$certain_regard="";
	foreach ($row as $field => $content):
		//print $fields[$field]." - *".(check_plain($content))."*<br/>";
	if (substr($fields[$field],0,21) == "field-terr-name-value" && $current_territory) {
		
			if ($content && $current_territory!="All") {
				if (stripos(check_plain($content), $current_territory)>=0) {
				// $terr_active = -1 means there is only 1 territory listed, so no markup
				$terr_active = (substr($content,0,1)!="<")?("-1"):
				(
					(substr($content, stripos($content,$current_territory)-4,1)=="-")?
					(substr($content, stripos($content,$current_territory)-3,1)):
					(substr($content, stripos($content,$current_territory)-4,2))
				);
				//print "Terr_active: ".$terr_active."<br/>";
				}
			}
		}
		if (substr($fields[$field],0,24) == "field-terr-sold-to-value" && $content!="" && $terr_active >= -1) {
			$i = 0;
			$j = 0;
			while ($j < $terr_active && $i <= strlen(trim($content)))
			{
					$i = stripos(trim($content),"<br/>", $i)+1;
					$j++;
			}
			if ($j!=0) {$i=$i+4;}
			if (substr(trim($content), $i, 5) == "<br/>") {$sold_to = "";}
			else
			{	
				if (strlen($content) >= $i) 
					{
						$next_one = stripos(trim($content), "<br", $i);
					}
					else
					{
						$next_one = strlen($content);
					}
				$sold_to = substr(trim($content), $i, $next_one);}
}
		switch ($fields[$field]) {
			case "title":
				$tle = $content;
				break;
			case "nid":
				$nid = $content;
				break;
			case "field-fest-nid":
				if (stripos($content,$fest_nid) && $fest_nid!="All") 
				{
					$cr = stripos(check_plain($content),"node/".$fest_nid);
					$gt = stripos(check_plain($content), "&gt;", $cr)+1;
					$lt = stripos(check_plain($content), "&lt;", $cr);
					$fest_name = substr(check_plain($content), $gt+3,$lt - $gt-3 );
					if (substr(check_plain($content), $cr-30,1)=="-"){
						$certain_regard = substr(check_plain($content), $cr-29,1);
					}
					else
					{
						$certain_regard = substr(check_plain($content), $cr-30,2);
					};
				}
				break;
			case "field-festprogram-value":
				$cr = stripos(check_plain($content), "-".$certain_regard."&quot;&gt;");
				$next = stripos(check_plain($content), "&lt;", $cr);
				$special = substr(check_plain($content), $cr+12, $next - $cr -12);
				break;
			case "field-terr-name-value-1":
				$i = 0;
			while (stripos($content, ">", $i)){
				$terr['terr_name'][] = substr($content, stripos($content, ">", $i) + 1, stripos($content, "</div>", $i) - stripos($content, ">", $i)-1 );
				$i = stripos($content, "</div>", $i) + 6;
				$terr_count++;
			}
				break;	
			case "field-screenings-value":
				$screenings = $content;
				break;
			case "field-logline-value":
				$log_line = $content;
				break;
			case "field-notes-value":
				$notes = $content;
				break;
			case "field-salescomp-nid":
					$jeff['right'][] = $content;
					$jeff['right_title'][] = "Sales Co:";
					$right++;
				break;
			case "field-director-value":
				$jeff['left'][] = $content;
				$jeff['left_title'][] = "Director:";
				$left++;
				break;
			case "field-producer-value":
				$jeff['left_title'][] = "Producer:";
				$i = 0;
				$t = "";
				if (!stripos($content,">",0)) {$jeff['left'][] = $content;}
				else
				{while (stripos(($content), ">", $i)){
					$t = $t.substr(($content), stripos(($content), ">", $i)+1, stripos(($content), "</div>", $i) - stripos($content, ">", $i) - 1 ).", ";
					$i = stripos(($content), "</div>", $i) + 6;
				}
				$t = substr(($t),0,strlen($t)-2);
				$jeff['left'][] = $t;
				$left++;}
				break;
			case "field-cast-value":
				$jeff['left_title'][] = "Cast:";
				$i = 0;
				$t = "";
				if (!stripos($content,">",0)) {$jeff['left'][] = $content;}
				else
				{while (stripos($content, ">", $i)){
					$t = $t.substr($content, stripos($content, ">", $i) + 1, stripos($content, "</div>", $i) - stripos($content, ">", $i)-1 ).", ";
					$i = stripos($content, "</div>", $i) + 6;
				}
				$t = substr(($t),0,strlen($t)-2);
				$jeff['left'][] = $t;
				$left++;}
				break;
			case "field-writer-value":
				$jeff['left'][] = $content;
				$jeff['left_title'][] = "Writer:";
				$left++;
				break;
			case "field-genre-value":
				$jeff['right'][] = check_plain($content);
				$jeff['right_title'][] = "Genre:";
				$right++;
				break;
			case "field-language-value":
				$jeff['right'][] = $content;
				$jeff['right_title'][] = "Language:";
				$right++;
				break;
			case "field-status-value":
				$jeff['right'][] = $content;
				$jeff['right_title'][] = "Status:";
				$right++;
				break;
		}
	endforeach;

// print array
	print "<span id='printbook_title'>".$tle."</span>";
	if ($sold_to) {print "<span id='sold_to'>Sold To: ".$sold_to."</span>";}
	if ($special != "" && $fest_nid!="All") {print "<br/><div id='special'>".$fest_name." - ".$special."</div>";}
	print "<table class='print_top_box'><colgroup><col width='10%'><col width='50%'><col width='10%'></colgroup>";
	for ($k=0; $k<= max($left, $right); $k++) {
		print  			"<tr><td class='views-field'>".$jeff['left_title'][$k]."</td><td class='views-field'>".$jeff['left'][$k]."</td><td class='views-field'>".$jeff['right_title'][$k]."</td><td class='views-field'>".$jeff['right'][$k]."</td></tr>";
	}
	print "</table><table class='print_middle_box'><colgroup><col width='10%'><col width='85%'></colgroup>";
	print "<tr><td class='views-field'>Screenings:</td><td class='views-field'>".$screenings."</td></tr>";
	print "<tr><td class='views-field'>Log Line:</td><td class='views-field'>".$log_line."</td></tr>";
	print "<tr><td class='views-field'>Notes:</td><td class='views-field'>".$notes."</td></tr>"; 
	print "</table>";
	


// Print line
	print "<hr align=left noshade size=5 width=140% color='black'>";



endforeach;
// print "</table>";
