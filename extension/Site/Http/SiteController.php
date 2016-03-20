<?php

namespace Extension\Site\Http;


use Reactor\Http\Controllers\Controller;
use Reactor\Nodes\NodeRepository;

class SiteController extends Controller {

    /**
     * Shows the homepage
     *
     * @param NodeRepository $nodeRepository
     * @return View
     */
    public function getHome(NodeRepository $nodeRepository)
    {
        $home = $nodeRepository->getHome();

        return view('index', compact('home'));
    }

    /**
     * Shows a page
     *
     * @param NodeRepository $nodeRepository
     * @param $name
     * @return View
     */
    public function getPage(NodeRepository $nodeRepository, $name)
    {
        $home = $nodeRepository->getHome(false);
        $node = $nodeRepository->getNodeAndSetLocale($name);

        return view('page', compact('home', 'node'));
    }

}