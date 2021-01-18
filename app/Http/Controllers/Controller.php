<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Nuclear\Hierarchy\SiteContent;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


	/**
	 * Records a view
	 *
	 * @param SiteContent $content
	 */
	protected function recordView(SiteContent $content)
	{
		views($content)->collection(app()->getLocale())
			->cooldown(now()->addHours(2))->record();
	}
	
}
