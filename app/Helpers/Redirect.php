<?php

namespace App\Helpers;

class Redirect
{
	public static function to($url)
	{
		header(sprintf('Location: %s', $url));
		die();
	}
}

