<?php

namespace newsletter;

class API extends \Restful {
	public function post_subscribe () {
		$apikey = \Appconf::newsletter ('Newsletter', 'mailchimp_api');
		$api = new \MCAPI($apikey);
		
		if (! isset ($_POST['list_id'])) {
			$_POST['list_id'] = \Appconf::newsletter ('Newsletter', 'default_list');
		}
		
		$merge_fields = [];
		if ($_POST['first'] != '') {
			$merge_fields['FNAME'] = $_POST['first'];
		}
		if ($_POST['last'] != '') {
			$merge_fields['LNAME'] = $_POST['last'];
		}

		$tags = preg_split ('/\s?,\s?/', trim ($_POST['tags']));
		if (! is_array ($tags)) {
			$tags = [];
		}

		$retval = $api->listSubscribe (
			$_POST['list_id'],
			$_POST['email'],
			$merge_fields,
			$tags
		);

		if ($api->errorCode == 400) {
			if (strpos ($api->errorMessage, 'permanently deleted') !== false) {
				error_log ('[newsletter/api/subscribe] ' . $api->errorCode . ' ' . $api->errorMessage);
				return $this->error (__ ('Your email was previously deleted from our system. Please contact us for help.'));
			} else {
				error_log ('[newsletter/api/subscribe] ' . $api->errorCode . ' ' . $api->errorMessage);
				return $this->error (__ ('It looks like you\'re already subscribed. Thank you!'));
			}
		} elseif ($api->errorCode) {
			error_log ('[newsletter/api/subscribe] ' . $api->errorCode . ' ' . $api->errorMessage);
			return $this->error (__ ('Unable to subscribe. Please try again later.'));
		}
		
		return __ ('Thank you for subscribing. Check your inbox for an email to confirm your subscription.');
	}
}
