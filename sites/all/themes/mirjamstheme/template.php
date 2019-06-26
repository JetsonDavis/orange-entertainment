<?php 


function mirjamstheme_theme()
{
return array(
	'film_node_form' => array(
	   'arguments' => array('form' => NULL),
		),
	'company_node_form' => array(
		'arguments' => array('form'=>NULL),
		),
	'film_fests_node_form' => array(
		'arguments' => array('form'=>NULL),
		),
    );
}

function mirjamstheme_film_node_form($form) {}

function mirjamstheme_company_node_form($form) {}

function mirjamstheme_film_fests_node_form($form) {}
 
function mirjamstheme_preprocess_page(&$vars) { 
	jquerytools_add('tabs','ul.tabss','div.panes > div.tab_pane');

	if (arg(0)=="node" && arg(1) == "1107" && arg(2) == "edit") {
		$vars['template_files'][] = 'page-editsplash';}
	if (arg(0) =="node" && arg(1) == "1107") {
		//Get global fest form database and put it in variables
		$result = db_query("SELECT field_globalfest_nid FROM {content_type_page_info} WHERE nid=1107");
		$obj = db_fetch_object($result);
		variable_set('global_fest', $obj->field_globalfest_nid);
		}
	if (arg(0)=="node" && arg(1) == "1108" && arg(2) == "edit") {
		$vars['template_files'][] = 'page-editwelcome';}
	if ($vars['node'] && arg(2) == 'edit' && $vars['node']->type =="film") {
		$vars['template_files'][] = 'page-editfilm';}
	if ($vars['node'] && arg(2) == 'edit' && $vars['node']->type =="company") {
		$vars['template_files'][] = 'page-editcomp';}
	if (arg(0)=="printbook") {
		$vars['template_files'][] = 'page-printbook';}
	if (arg(0)=="printbook") {
		$vars['template_files'][] = 'page-printbook';}
	if (arg(0)=="users") {
		$vars['template_files'][] = 'page-users';}
}

function mirjamstheme_views_pre_render(&$view) {

}

