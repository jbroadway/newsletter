<?php

echo $tpl->render (
	'newsletter/subscribe_widget',
	array (
		'list_id' => $data['list'],
		'rand' => mt_rand ()
	)
);

?>