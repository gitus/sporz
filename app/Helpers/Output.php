<?php

namespace App\Helpers;

class Output
{
	public static function json($data)
	{
		ob_end_clean();
		header('Content-Type: application/json');
		echo json_encode(['result' => $data]);
		die();
	}
}

