<?php // $Id: juitter.inc,v 1.1.2.2 2009/08/21 21:32:03 doublethink Exp $

/*
Admin settings menu callback
*/
function juitter_admin($form_state) {
	$form['page'] = array(
		'#type' => 'fieldset',
		'#title' => t('Juitter page settings'),
		'#weight' => -5,
		'#collapsible' => TRUE,
		'#collapsed' => FALSE,
	);
	$form['page']['juitter_page_title'] = array(
		'#type' => 'textfield',
		'#weight' => -1,
		'#title' => t('Juitter page title'),
		'#default_value' => variable_get('juitter_page_title', 'Juitter'),
		'#required' => TRUE,
	);
	$form['page']['juitter_search'] = array(
		'#type' => 'checkbox',
		'#title' => t('Enable juitter search box'),
		'#default_value' => variable_get('juitter_search', 1),
	);
	$form['page']['juitter_search_text'] = array(
		'#type' => 'textfield',
		'#title' => t('Text inside the search box'),
		'#default_value' => variable_get('juitter_search_text', 'Search twitter:'),
	);
	$form['page']['juitter_trends'] = array(
	    '#tree' => FALSE,
	    '#weight' => 0,
	    '#prefix' => '<div class="clear-block" id="juitter-trends-wrapper">',
	    '#suffix' => '</div>',
	);
	$form['page']['juitter_trends']['trends'] = array(
		'#tree' => TRUE,
		'#prefix' => '<div id="juitter-trends">',
		'#suffix' => '</div>',
		'#theme' => 'juitter_admin_form_trends',
	);
	$form['page']['juitter_trends']['trends_more'] = array(
		'#type' => 'submit',
		'#value' => t('Add more trends'),
		'#submit' => array('juitter_more_trends'), // If no javascript action.
		'#ahah' => array(
			'path' => 'juitter/ahah',
			'wrapper' => 'juitter-trends',
			'method' => 'replace',
			'effect' => 'fade',
		),
	);
	$form['submit'] = array(
		'#type' => 'submit',
		'#value' => t('Save'),
	);
	
	$settings = juitter_get_settings();
	if ($settings) {
		foreach ($settings as $delta => $details) {
			$form['page']['juitter_trends']['trends'][$delta] = juitter_trend_form($details);
		}
	}
	return $form;
}

function juitter_ahah_trends() {
	$delta = count($_POST['trends']);
	$details = array('delta' => $delta);
	$form_element = juitter_trend_form($delta);
	drupal_alter('form', $form_element, array(), 'juitter_ahah_trends');
	
	// Build the new form.
	$form_state = array('submitted' => FALSE);
	$form_build_id = $_POST['form_build_id'];
	$form = form_get_cache($form_build_id, $form_state);
	$form['page']['juitter_trends']['trends'][$delta] = $form_element;
	form_set_cache($form_build_id, $form, $form_state);
	$form += array('#post' => $_POST, '#programmed' => FALSE,);
	$form = form_builder('juitter_admin', $form, $form_state);
	
	// Render the new output.
	$trend_form = $form['page']['juitter_trends']['trends'];
	$output = theme('status_messages') . drupal_render($trend_form);
	drupal_json(array('status' => TRUE, 'data' => $output));
}

function theme_juitter_admin_form_trends($form) {
	drupal_add_tabledrag('juitter-trends-table', 'order', 'sibling', 'juitter-trends-weight', null,null,false);
	$rows = array();
	$headers = array( t('Trend title'), t('Trend weight'), t('Edit'), t('Remove'),);
	foreach (element_children($form) as $key) {
		$form[$key]['weight']['#attributes']['class'] = 'juitter-trends-weight';
		$row = array(
			'data' => array(
				array('data' => drupal_render($form[$key]['title'])),
				array('data' => drupal_render($form[$key]['weight'])),
				array('data' => drupal_render($form[$key]['edit'])),
				array('data' => drupal_render($form[$key]['remove'])),
			),
			'class' => 'draggable',
		); $rows[] = $row;
	}
	$output = theme('table', $headers, $rows, array('id' => 'juitter-trends-table'));
	$output .= drupal_render($form);
	return $output;
}

function juitter_trend_form($details) {
	$form['#tree'] = TRUE;
	$form['weight'] = array(
		'#type' => 'weight',
		'#default_value' => $details['weight'],
	);
	$form['trend_id'] = array(
		'#type' => 'hidden',
		'#default_value' => $details['trend_id'],
	);
	$form['title'] = array(
		'#type' => 'textfield',
		'#size' => 20,
		'#default_value' => $details['title'],
	);
	
	if ($details['trend_id']) {
		$form['edit'] = array(
			'#prefix' => '<a href="' . url('admin/settings/juitter/' . $details['trend_id'] . '/edit') . '">',
			'#suffix' => '</a>',
			'#value' => t('Edit'),
		);
		$form['remove'] = array(
			'#prefix' => '<a href="' . url('admin/settings/juitter/' . $details['trend_id'] . '/remove') . '">',
			'#suffix' => '</a>',
			'#value' => t('Remove'),
		);
	}
	return $form;
}

function juitter_trend_settings($form_state, $trend_id) {
	$trend = juitter_get_settings($trend_id);
	drupal_set_title(t('%trend settings', array('%trend' =>$trend['title'])));
	$settings = unserialize($trend['settings']);
	$form['trend'] = array(
		'#type' => 'fieldset',
		'#title' => t('Trend settings'),
		'#weight' => -5,
		'#collapsible' => TRUE,
		'#collapsed' => FALSE,
	);
	$form['trend']['trend_id'] = array(
		'#type' => 'hidden', '#default_value' => $trend['trend_id'],
	);
	$form['trend']['search_type'] = array(
		'#type' => 'select',
		'#title' => t('Choose the default search type'),
		'#default_value' => $settings['searchType'],
		'#options' => array( 'searchWord' => t('Keyword search'), 'fromUser' => t('From specific user'), 
			'toUser' => t('To a specific user'), ),
		'#required' => TRUE,
	);
	$form['trend']['search_object'] = array(
		'#type' => 'textfield',
		'#default_value' => $settings['searchObject'],
		'#title' => t('Type down the keywords to search for'),
		'#description' => t('Use comma separeted keywords for multiple search.'),
		'#required' => TRUE,
	);
	$form['trend']['lang'] = array(
		'#type' => 'textfield',
		'#title' => t('Restricts the search by a given language'),
		'#description' => t('Example: "en" will return only results in english language.'),
		'#default_value' => $settings['lang'],
		'#size' => 10,
		'#maxlength' => 2,
	);
	$form['trend']['live'] = array(
		'#type' => 'textfield',
		'#title' => t('How many seconds to wait before requesting the Twitter API for updates'),
		'#default_value' => $settings['live'],
		'#size' => 10,
		'#maxlength' => 3,
	);
	$form['trend']['load_msg'] = array(
		'#type' => 'textfield',
		'#title' => t('Loading message text'),
		'#default_value' => $settings['loadMSG'],
		'#maxlength' => 20,
	);
	$form['trend']['img_name'] = array(
		'#type' => 'textfield',
		'#title' => t('Or type the location of an image for loading'),
		'#default_value' => $settings['imgName'],
		'#description' => t('This will override the loading message. Must be GIF.<br />Example: http://juitter.com/loading.gif'),
	);
	$form['trend']['total'] = array(
		'#type' => 'textfield',
		'#title' => t('Total number of results'),
		'#default_value' => $settings['total'],
		'#size' => 10, '#maxlength' => 3,
		'#required' => TRUE,
		'#description' => t('Maximum is 100.'),
	);
	$form['trend']['read_more'] = array(
		'#type' => 'textfield',
		'#title' => t('Read more text'),
		'#default_value' => $settings['readMore'],
		'#maxlength' => 120,
		'#required' => TRUE,
	);
	$form['trend']['name_user'] = array(
		'#type' => 'select',
		'#title' => t('Choose whether to show the user image or as text'),
		'#default_value' => $settings['nameUser'],
		'#options' => array( 'image' => t('User image'), 'text' => t('Username as text'), ),
	);
	$form['trend']['external_link'] = array(
		'#type' => 'select',
		'#title' => t('Choose how to open links to external websites'),
		'#default_value' => $settings['openExternalLinks'],
		'#options' => array( 'newWindow' => t('New window'), 'sameWindow' => t('Same window'), ),
	);
    $form['trend']['filter'] = array(
      '#type' => 'textarea',
      '#title' => t('Keywords filters'),
      '#default_value' => $settings['filter'],
      '#description' => t('Insert the words you want to hide from the tweets followed by what you want to show instead example:<br/>"sex->censured" or "porn->BLOCKED WORD" you can define as many as you want, if you don\'t want to replace the word, simply remove it, just add the words you want separated like this "porn,sex"... Be aware that the tweets will still be showed, only the bad words will be removed'),
    );
	$form['submit'] = array(
		'#type' => 'submit',
		'#value' => t('Save'),
	);
    return $form;
}

function juitter_admin_submit($form, &$form_state) {
	foreach ($form_state['values']['trends'] as $trend) {
		if ($trend['title'] != '') {
			if (is_numeric($trend['trend_id'])) {
				db_query("UPDATE {juitter} SET weight = '%s', title = '%s' WHERE trend_id = '%d'", $trend['weight'], $trend['title'], $trend['trend_id']);
			}
			else { db_query("INSERT INTO {juitter} (weight, title) VALUES ('%s', '%s')", $trend['weight'], $trend['title']); }
		}
	}
	if ($form_state['values']['juitter_page_title'] != variable_get('juitter_page_title', 'Juitter'))
		variable_set('juitter_page_title', $form_state['values']['juitter_page_title']);
	if ($form_state['values']['juitter_search'] != variable_get('juitter_search', 1))
		variable_set('juitter_search', $form_state['values']['juitter_search']);
	if ($form_state['values']['juitter_search_text'] != variable_get('juitter_search_text', 'Search twitter:'))
		variable_set('juitter_search_text', $form_state['values']['juitter_search_text']);
	drupal_set_message(t('Your form has been saved.'));
}

function juitter_trend_settings_submit($form, &$form_state) {
	$settings = array(
		'searchType' => $form_state['values']['search_type'], 
		'searchObject' => $form_state['values']['search_object'], 
		'lang' => $form_state['values']['lang'], 
		'live'	=> $form_state['values']['live'],
		'loadMSG'	=> $form_state['values']['load_msg'], 
		'imgName' => $form_state['values']['img_name'],
		'total' => $form_state['values']['total'], 
		'readMore' => $form_state['values']['read_more'], 
		'nameUser' => $form_state['values']['name_user'],
		'openExternalLinks' => $form_state['values']['external_link'], 
		'filter' => $form_state['values']['filter'],
	);
	db_query("UPDATE {juitter} SET settings = '%s' WHERE trend_id = '%d'", serialize($settings), $form_state['values']['trend_id']);
	drupal_set_message(t('The trend has been updated.'));
	cache_clear_all();
	$form_state['redirect'] = 'admin/settings/juitter';
}

function juitter_remove_trend(&$form_state, $trend_id) {
	$form['trend_id'] = array('#type' => 'hidden', '#value' => $trend_id);
	return confirm_form($form, t('This action cannot be undone. All settings related to this trend will be erased.'), 'admin/settings/juitter', '', t('Delete'), t('Cancel'));
}

function juitter_remove_trend_submit($form, &$form_state) {
	db_query('DELETE FROM {juitter} WHERE trend_id = %d', $form_state['values']['trend_id']);
	drupal_set_message(t('The trend has been removed.'));
	cache_clear_all();
	$form_state['redirect'] = 'admin/settings/juitter';
};