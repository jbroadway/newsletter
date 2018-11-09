<?php

$page->id = 'newsletter';
$page->title = Appconf::newsletter ('Newsletter', 'title');
$page->layout = Appconf::newsletter ('Newsletter', 'layout');

$default_list = Appconf::newsletter ('Newsletter', 'default_list');

if (empty ($default_list)) {
	printf ('<p>%s</p>', __ ('The default newsletter has not yet been configured.'));
	return;
}

$form = new Form ('post', $this);

echo $form->handle (function ($form) use ($default_list) {
	$apikey = Appconf::newsletter ('Newsletter', 'mailchimp_api');
	$api = new MCAPI ($apikey);
	
	$retval = $api->listSubscribe (
		$default_list,
		$_POST['email'],
		(object) array (
			'FNAME' => $_POST['first_name'],
			'LNAME' => $_POST['last_name']
		)
	);
	
	if ($api->errorCode == 400) {
		printf ('<p>%s</p>', __ ('It looks like you\'re already subscribed. Thank you!'));
		error_log ('[newsletter/index] ' . $api->errorCode . ' ' . $api->errorMessage);
		return;
	} elseif ($api->errorCode) {
		printf ('<p>%s</p>', __ ('Unable to load lists from MailChimp at this time.'));
		error_log ('[newsletter/index] ' . $api->errorCode . ' ' . $api->errorMessage);
		return;
	}

	$fwd = Appconf::newsletter ('Newsletter', 'forward_on_success');
	if ($fwd != '') {
		$form->controller->redirect ($fwd);
	} else {
		printf ('<p>%s</p>', __ ('Thank you for signing up to receive our newsletter. Check your inbox for an email to confirm your subscription.'));
	}
});

?>