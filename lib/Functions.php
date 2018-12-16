<?php

/**
 * Fetch a formatted list of lists for use in the dynamic objects
 * dialog window.
 */
function newsletter_list_names () {
	$lists = newsletter_raw_lists ();

	$retarr[] = (object) array (
		'key' => 0,
		'value' => "-- Please Select List --"
	);

	foreach ($lists as $list) {
		$retarr[] = (object) array (
			'key' => $list['id'],
			'value' => $list['name']
		);
	}

	return $retarr;
}

function newsletter_yes_no () {
	return [['key' => 'no', 'value' => __ ('No')], ['key' => 'yes', 'value' => __ ('Yes')]];
}

/**
 * Return a raw array of list results.
 */
function newsletter_raw_lists ($apikey = null) {
	$apikey = $apikey ? $apikey : Appconf::newsletter ('Newsletter', 'mailchimp_api');
	if ($apikey == '') {
		return [];
	}
	$api = new MCAPI($apikey);
	$retval = $api->lists ();
	return is_array ($retval['lists']) ? $retval['lists'] : array ();
}

?>