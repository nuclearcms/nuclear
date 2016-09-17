<?php


namespace Extension\Site\Http;


use Illuminate\Http\Request;
use Nuclear\Hierarchy\NodeRepository;
use Nuclear\Hierarchy\Tags\Tag;
use Reactor\Http\Controllers\Controller;

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
        $node = $nodeRepository->getNodeAndSetLocale($name);

        return view('page', compact('node'));
    }

    /**
     * Shows the search page
     *
     * @param string $search
     * @param NodeRepository $nodeRepository
     * @param Request $request
     * @return View
     */
    public function getSearch($search, NodeRepository $nodeRepository, Request $request)
    {
        set_app_locale_with('search', $search);

        $results = $nodeRepository->searchNodes($request->input('q'));

        return view('search', compact('results'));
    }

    /**
     * Shows the tag page
     *
     * @param string $tags
     * @param string $name
     * @return View
     */
    public function getTag($tags, $name)
    {
        set_app_locale_with('tags', $tags);

        $tag = Tag::withName($name)->firstOrFail();

        return view('tag', compact('tag'));
    }

}