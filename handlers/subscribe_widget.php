<?php

echo $tpl->render (
	'newsletter/subscribe_widget',
	array (
		'list_id' => $data['list'],
		'fwd' => $data['fwd'],
		'tags' => $data['tags'],
		'rand' => mt_rand ()
	)
);

?>