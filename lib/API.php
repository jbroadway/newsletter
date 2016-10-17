<?php

namespace newsletter;

class API extends \Restful {
	public function post_subscribe () {
		$apikey = \Appconf::newsletter ('Newsletter', 'mailchimp_api');
		$api = new \MCAPI($apikey);

		$retval = $api->listSubscribe (
			$_POST['list_id'],
			$_POST['email']
		);

		if ($api->errorCode == 214) {
			return $this->error (__ ('It looks like you\'re already subscribed. Thank you!'));
		} elseif ($api->errorCode) {
			error_log ('Newsletter error #' . $api->errorCode . ': ' . $api->errorMessage);
			return $this->error (__ ('Unable to subscribe. Please try again later.'));
		}
		
		return __ ('Thank you for subscribing. Check your inbox for an email to confirm your subscription.');
	}
}

?>
