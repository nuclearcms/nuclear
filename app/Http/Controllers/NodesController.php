<?php


namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Reactor\Http\Controllers\Traits\UsesTranslations;

class NodesController extends ReactorController {

    use UsesTranslations;

    /**
     * Changes the displayed tree locale
     *
     * @param Request $request
     * @return void
     */
    public function changeTreeLocale(Request $request)
    {
        $locale = $this->validateLocale($request);

        session()->set('reactor.tree_locale', $locale);
    }

}