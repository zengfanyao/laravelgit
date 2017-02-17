<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PageClass extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'page';
	}
}
?>