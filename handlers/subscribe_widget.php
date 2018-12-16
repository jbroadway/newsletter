<?php

echo $tpl->render (
	'newsletter/subscribe_widget',
	array (
		'list_id' => $data['list'],
		'fwd' => $data['fwd'],
		'tags' => $data['tags'],
		'name' => $data['name'],
		'rand' => mt_rand ()
	)
);

?>