<?php

echo $tpl->render (
	'newsletter/subscribe_widget',
	array (
		'list_id' => $data['list'],
		'fwd' => $data['fwd'],
		'rand' => mt_rand ()
	)
);

?>