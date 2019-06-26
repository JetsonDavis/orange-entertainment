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

// Print node for output to printer
// print "views-view-table--print-view.tpl.php";

// Build array
	//dsm($rows);
print "<hr align=left noshade size=6 width=140% color='black'>";
foreach ($rows as $count => $row):
	print "<p id='group_head'>";
	$fest_nid = variable_get('film_fest_set',0);
	print "</p>";
	

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
	$certain_regard="";
	foreach ($row as $field => $content):
		//print $fields[$field]." - *".check_plain($content)."*<br/>";
		switch ($fields[$field]) {
			case "title":
				$tle = $content;
				break;
			case "nid":
				$nid = $content;
				break;
			case "field-fest-nid":
				watchdog("strlen",strlen($content));
				watchdog("position of </div>",stripos($content, "</div>")+7);
				watchdog("content",$content);
				$fests = strip_tags(stripos($content, "</div>")+7 < strlen($content) ? str_replace("</a>"," - ",$content) : $content );
				$fests = substr(trim($fests),-1,1) == "-" ? substr(trim($fests),0,-1):$fests;
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
				$fest_prog = ($content);
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
					$jeff['right_title'][] = "Sales Comp:";
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
			case "field-addl-avails-value":
				$addl_avails = $content;
				break;
		}
	endforeach;

// print array
	print "<div id='printbook_title'>".$tle."</div>";
	if ($special != "" && $fest_nid!="All") {print "<br/><div id='special'>".$fest_name." - ".$special."</div>";}
	print "<table class='print_top_box'><colgroup><col width='12%'><col width='35%'><col width='12%'></colgroup>";
	for ($k=0; $k<= max($left, $right); $k++) {
		print  			"<tr><td class='views-field'>".$jeff['left_title'][$k]."</td><td class='views-field'>".$jeff['left'][$k]."</td><td class='views-field'>".$jeff['right_title'][$k]."</td><td class='views-field'>".$jeff['right'][$k]."</td></tr>";
	}
	print "<br/><br/>";
	print "</table><table class='print_middle_box'><colgroup><col width='104px'><col width='600px'></colgroup>";
	print "<tr><td class='views-field'>Screenings:</td><td class='views-field'>".$screenings."</td></tr>";
	print "<tr><td class='views-field'>Log Line:</td><td class='views-field'>".$log_line."</td></tr>";
	print "<tr><td class='views-field'>Notes:</td><td class='views-field'>".$notes."</td></tr>"; 
	print "<tr><td class='views-field'>Avails:</td><td class='views-field'>".$addl_avails."</td></tr>"; 
	print "<tr><td class='views-field'>Festival:</td><td class='views-field'>".$fests."</td></tr>"; 
	print "<tr><td class='views-field'>Program:</td><td class='views-field'>".$fest_prog."</td></tr>"; 
	print "</table>";
	
// Build territory table	
	
	/* $result = db_query("SELECT delta, field_terrexcept_value from {content_field_terrexcept} WHERE nid = %d", $nid);
	while ( $obj = db_fetch_object ($result)) {
		$terr['terr_except'][$obj->delta] = $obj->field_terrexcept_value;} 
		
	$result = db_query("SELECT delta, field_terr_rating_value from {content_field_terr_rating} WHERE nid = %d", $nid);
	while ( $obj = db_fetch_object ($result)) {
		$terr['terr_rating'][$obj->delta] = $obj->field_terr_rating_value;} */
		
	$result = db_query("SELECT delta, field_terr_price_value from {content_field_terr_price} WHERE nid = %d", $nid);
	while ( $obj = db_fetch_object ($result)) {
		$terr['terr_price'][$obj->delta] = $obj->field_terr_price_value;}
		
/*	$result = db_query("SELECT delta, field_terr_sold_to_value from {content_field_terr_sold_to} WHERE nid = %d", $nid);
	while ( $obj = db_fetch_object ($result)) {
		$terr['terr_sold_to'][$obj->delta] = $obj->field_terr_sold_to_value;} */
		
// Print territory table
	if ($terr_count > 0) {
		print "<table class='terr_table'>";
		print "<table class='terr_table'><colgroup><col width='14%'><col width='14%'><col width='14%'><col width='14%'><col width='14%'><col width='14%'><col width='14%'></colgroup>";
		print "<thead><tr><th class='terr_table'>Territory</th><th class='terr_table'>Price</th><th class='terr_table'>Territory</th><th class='terr_table'>Price</th><th class='terr_table'>Territory</th><th class='terr_table'>Price</th></tr></thead><tbody>";
			$x = 0;$output = '';
			//$t_c = 3-($terr_count % 3);
			//print "TC".$t_c."<br/>";
			$t_c = (($terr_count % 3) == 3 ) ? ($terr_count):($terr_count + (3-($terr_count % 3)));
			//print "TC".$t_c."<br/>";
			for ($k=0;$k<$t_c;$k++){
				if ($x == 0) {
					$output .= "<tr>";
					}
				$output .= "<td class='terr_cell'>".$terr['terr_name'][$k]."</td><td class='terr_cell'>".$terr['terr_price'][$k]."</td>";
				//print "k:".$k.check_plain($output)."<br/>";
				$x++;
				if ($x == 3) {
					$output .="</tr>";
					$x = 0;
				}
			}
			$output .=  "</tbody></table>";
			//print check_plain($output)."<br/>";
			print $output;
	}

// Print line
	print "<hr align=left noshade size=5 width=140% color='black'>";



endforeach;
// print "</table>";
