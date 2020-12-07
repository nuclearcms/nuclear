<?php

namespace App\Http\Controllers;

use Nuclear\Hierarchy\ContentsRepository;
use Nuclear\Hierarchy\SiteContent;

class SiteController extends Controller {

	/**
	 * Shows home
	 *
	 * @param ContentsRepository $contentsRepository
	 * @return view
	 */
	public function home(ContentsRepository $contentsRepository)
	{
		$content = $contentsRepository->getHome();

		return view('home', compact('content'));
	}

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