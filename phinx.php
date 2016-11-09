<?php

require_once __DIR__.'/config/config.php';

return array(
	'paths' => array(
		'migrations'    => '%%PHINX_CONFIG_DIR%%/db/migrations',
		'seeds'         => '%%PHINX_CONFIG_DIR%%/db/seeds',
	),
	'environments' => array(
		'default_database' => 'development',
		'development'  => array(
			'adapter'   => DB_CONNECTOR,
			'host'      => DB_HOST,
			'name'      => DB_NAME,
			'user'      => DB_USER,
			'pass'      => DB_PASSWORD,
			'charset'   => 'utf8',
		),
	),
);
