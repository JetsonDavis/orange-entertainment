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

foreach ($rows as $count => $row):
	print "<hr align=left noshade size=6 width=140% color='black'>";
    print "<tr class=".implode(' ', $row_classes[$count]).">";
	$jeff=array();
	$phones=array();
	$tle="";
	$office_addr = "";
	$contacts = "";
	$no_of_addrs= 0;
	$no_of_phones=0;
    foreach ($row as $field => $content): 
		//print $fields[$field]." - *".check_plain($content)."*<br/>";
		switch ($fields[$field]) {
			case "title":
				$tle = $content;
				break;
			case "field-compstreet-value":
				$office_addr = $content;
				break;	
			case "field-compcontact-value":
				$contacts = $content;
				break;
			// Parse phone #s
			case "field-compphonelabel-value":
				$j = 0;
				$i = -1;
				if (!stripos(check_plain($content), "field-item-", $j) && strlen(check_plain($content)) > 1)
				{
					$no_of_phones = 1;
					print "# of Phones: ".$content."<br/>";
					$phones['label'][] = $content;
				}
				elseif (stripos(check_plain($content), "field-item-", $j))
				{
					while (stripos(check_plain($content), "field-item-", $j)) {
						$first = stripos(check_plain($content), "field-item-", $j);
						$next = (stripos(check_plain($content), "field-item-", $first+1)==0)?(strlen(check_plain($content))+31):(stripos(check_plain($content), "field-item-", $first+1));
						$inc = ($i > 8)?(1):(0);
						$phones['label'][] = substr(check_plain($content), $first + 22+$inc, $next - $first - (65+$inc));
						$j = $first + 1;
						$i++;
				}
				$i++;
				$no_of_phones = $i;
			}
				break;
			case "field-compphone-value":
				if ($no_of_phones == 1) {
					$phones['number'][] = $content; 
				}
				elseif ($no_of_phones > 1) 
				{
					$i = 0;
					for  ($j =1;$j <= $no_of_phones; $j++){
						$first = stripos(check_plain($content), "field-item-", $i);
						$next = (stripos(check_plain($content), "field-item-", $first+1)==0)?(strlen(check_plain($content))+31):(stripos(check_plain($content), "field-item-", $first+1));
						$inc = ($j > 8)?(1):(0);
						$phones['number'][] = substr(check_plain($content), $first + 22+$inc, $next - $first - (65+$inc));
						$i = $first + 1;
					
					}
				}
				break;
			// Parse Fest addresses
			case "field-compcannesaddr-value":
				//while ($i < strlen(check_plain($content))){print $i."-".substr(check_plain($content),$i,1)."<br/>";$i++;}
				$j = 0;
				$i = -1;
				if (!stripos(check_plain($content), "field-item-", $j) && strlen(check_plain($content)) > 1)
				{
					$no_of_addrs = 1;
					$jeff['addr'][] = $content;
				}
				elseif (stripos(check_plain($content), "field-item-", $j))
				{
				while (stripos(check_plain($content), "field-item-", $j)) {
					$first = stripos(check_plain($content), "field-item-", $j);
					$next = (stripos(check_plain($content), "field-item-", $first+1)==0)?(strlen(check_plain($content))+31):(stripos(check_plain($content), "field-item-", $first+1));
					$inc = ($i > 8)?(1):(0);
					$jeff['addr'][] = substr(check_plain($content), $first + 22+$inc, $next - $first - (65+$inc));
					$j = $first + 1;
					$i++;
				}
				$i++;
				$no_of_addrs = $i;}
				break;
			case "field-addrlabel-value":
				if ($no_of_addrs == 1) {
					$jeff['addrlabel'][] = $content; 
				}
				elseif ($no_of_addrs > 1) 
				{
					$i = 0;
					for  ($j =1;$j <= $no_of_addrs; $j++){
						$first = stripos(check_plain($content), "field-item-", $i);
						$next = (stripos(check_plain($content), "field-item-", $first+1)==0)?(strlen(check_plain($content))+31):(stripos(check_plain($content), "field-item-", $first+1));
						$inc = ($j > 8)?(1):(0);
						$jeff['addrlabel'][] = substr(check_plain($content), $first + 22+$inc, $next - $first - (65+$inc));
						$i = $first + 1;
					
					}
				}
				break;
			case "field-printaddr-value":
			if ($no_of_addrs == 1) {
				$jeff['printlabel'][] = $content; 
			}
			elseif ($no_of_addrs > 1) 
			{
				$i = 0;
				for  ($j =1;$j <= $no_of_addrs; $j++){
					$first = stripos(check_plain($content), "field-item-", $i);
					$next = (stripos(check_plain($content), "field-item-", $first+1)==0)?(strlen(check_plain($content))+31):(stripos(check_plain($content), "field-item-", $first+1));
					$inc = ($j > 8)?(1):(0);
					$jeff['printlabel'][] = substr(check_plain($content), $first + 22+$inc, $next - $first - (65+$inc));
					$i = $first + 1;
				
				}
			}
				break;
				
				
	}
         print '<class="views-field views-field-'.$fields[$field].'">';
	endforeach;
	 print "<h2>".$tle."</h2>";
	print "Address:".$office_address."<br/>";
	print "Contact:".($contacts)."<br/>";

        if ($no_of_phones > 0) {print "Contact Number(s):"."<br/>";}
	for ($k=0;$k<$no_of_phones;$k++)
	{
		print $phones['label'][$k]." - ".$phones['number'][$k]."<br/>";
	}
	print "<br/>";
	 if ($no_of_addrs > 0) {print "Festival Address(s):"."<br/>";}
	for ($k=0;$k<$no_of_addrs;$k++)
	{
		if ($jeff['printlabel'][$k] != "Nil") {
		print $jeff['addrlabel'][$k]." - ".$jeff['addr'][$k]."<br/>";}
	}
 endforeach;

