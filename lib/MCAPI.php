<?php

require_once ('apps/newsletter/lib/mailchimp-api/src/MailChimp.php');
//require_once ('apps/newsletter/lib/mailchimp-api/src/Batch.php');
//require_once ('apps/newsletter/lib/mailchimp-api/src/Webhook.php');

use DrewM\MailChimp\MailChimp;

class MCAPI {
	public $errorCode = false;
	public $errorMessage = '';

	private $mc;

	public function __construct ($apikey) {
		$this->mc = new MailChimp ($apikey);
	}
	
	public function lists () {
		$res = $this->mc->get ('lists');
		
		if (! $this->mc->success ()) {
			list ($this->errorCode, $this->errorMessage) = explode (':', $this->mc->getLastError (), 2);
		}

		return $res;
	}
	
	public function listSubscribe ($id, $email, $merge_fields = [], $tags = [], $extra_params = []) {
		$data = [
			'email_address' => $email,
			'status' => 'subscribed',
			'merge_fields' => (object) $merge_fields,
			'tags' => $tags
		];
		
		$data = $data + $extra_params;

		$res = $this->mc->post ('lists/' . $id . '/members', $data);
		
		if (! $this->mc->success ()) {
			list ($this->errorCode, $this->errorMessage) = explode (':', $this->mc->getLastError (), 2);
		}
		
		return $res;
	}
}
