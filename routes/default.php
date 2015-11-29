<?php

use Reactor\Nodes\NodeRepository;

Route::group(['middleware' => 'locale'], function ()
{

    Route::get('/', ['as' => 'home', 'uses' => function (NodeRepository $nodeRepository)
    {
        $home = $nodeRepository->getHome();

        return view('index', compact('home'));
    }]);

    Route::get('{node}', function (NodeRepository $nodeRepository, $name)
    {
        $home = $nodeRepository->getHome();
        $node = $nodeRepository->getNodeAndSetLocale($name);

        return view('page', compact('home', 'node'));
    });

});