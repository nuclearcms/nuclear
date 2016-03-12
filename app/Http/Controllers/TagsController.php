<?php

namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Reactor\Http\Controllers\Traits\ModifiesTranslations;
use Reactor\Http\Requests;
use Reactor\Tags\Tag;

class TagsController extends ReactorController {

    use ModifiesTranslations;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::sortable()->paginate();

        return view('tags.index', compact('tags'));
    }

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $tags = Tag::search($request->input('q'))->get();

        return view('tags.search', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('ACCESS_TAGS_WRITE');

        $form = $this->getCreateTagForm();

        return view('tags.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('ACCESS_TAGS_WRITE');

        $this->validateForm('Reactor\Http\Forms\Tags\CreateEditForm', $request);

        $tag = Tag::create($request->all());

        $this->notify('tags.created');

        return redirect()->route('reactor.tags.edit', [$tag->getKey(), $tag->translate()->getKey()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param int|null $translation
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $translation)
    {
        $this->authorize('ACCESS_TAGS_WRITE');

        $tag = Tag::findOrFail($id);

        list($locale, $translation) = $this->determineLocaleAndTranslation($translation, $tag);

        $form = $this->getEditTagForm($id, $translation);

        return view('tags.edit', compact('form', 'tag', 'translation', 'locale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @param int $translation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $translation)
    {
        $this->authorize('ACCESS_TAGS_WRITE');

        $tag = Tag::findOrFail($id);

        list($locale, $translation) = $this->determineLocaleAndTranslation($translation, $tag);

        $this->validateUpdateTag($request, $translation);

        $tag->update([
            $locale => $request->all()
        ]);

        $this->notify('tags.edited');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('ACCESS_TAGS_WRITE');

        $tag = Tag::findOrFail($id);

        $tag->delete();

        $this->notify('tags.deleted');

        return redirect()->route('reactor.tags.index');
    }

    /**
     * Adds a translation to the resource
     *
     * @param  int $id
     * @param int|null $translation
     * @return \Illuminate\Http\Response
     */
    public function createTranslation($id, $translation)
    {
        $this->authorize('ACCESS_TAGS_WRITE');

        $tag = Tag::findOrFail($id);

        list($locale, $translation) = $this->determineLocaleAndTranslation($translation, $tag);

        if (count($locales = $this->getAvailableLocales($tag)) === 0)
        {
            flash()->error(trans('tags.no_available_locale'));

            return redirect()->back();
        }

        $form = $this->getCreateTagTranslationForm($tag, $locales);

        return view('tags.translate', compact('form', 'tag', 'translation'));
    }

    /**
     * Stores a translation in the resource
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function storeTranslation(Request $request, $id)
    {
        $this->authorize('ACCESS_TAGS_WRITE');

        $tag = Tag::findOrFail($id);

        $locale = $this->validateLocale($request);

        $tag->update([
            $locale => $request->all()
        ]);

        $this->notify('tags.added_translation');

        return redirect()->route('reactor.tags.edit', [
            $tag->getKey(),
            $tag->translate($locale)->getKey()
        ]);
    }

    /**
     * List the specified resource fields.
     *
     * @param int $id
     * @param int $translation
     * @return Response
     */
    public function nodes($id, $translation)
    {
        $this->authorize('ACCESS_CONTENTS');

        $tag = Tag::findOrFail($id);

        list($locale, $translation) = $this->determineLocaleAndTranslation($translation, $tag);

        $nodes = $tag->nodes()->sortable()->paginate();

        return view('tags.nodes', compact('tag', 'translation', 'nodes'));
    }

    /**
     * Determines the current editing locale
     *
     * @param $translation
     * @param $node
     * @return string
     */
    protected function determineLocaleAndTranslation($translation, $node)
    {
        $translation = $node->translations->find($translation);

        if (is_null($translation))
        {
            abort(404);
        }

        return [$translation->locale, $translation];
    }

    /**
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateTagForm()
    {
        return $this->form('Reactor\Http\Forms\Tags\CreateEditForm', [
            'method' => 'POST',
            'url'    => route('reactor.tags.store')
        ]);
    }

    /**
     * @param $id
     * @param $translation
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getEditTagForm($id, $translation)
    {
        return $this->form('Reactor\Http\Forms\Tags\CreateEditForm', [
            'method' => 'PUT',
            'url'    => route('reactor.tags.update', [$id, $translation->getKey()]),
            'model'  => $translation
        ]);
    }

    /**
     * @param Request $request
     * @param $translation
     */
    protected function validateUpdateTag($request, $translation)
    {
        $this->validateForm('Reactor\Http\Forms\Tags\CreateEditForm', $request, [
            'name' => ['required', 'max:255',
                'unique:tag_translations,name,' . $translation->getKey()]
        ]);
    }

    /**
     * @param $tag
     * @param array $locales
     * @return \Kris\LaravelFormBuilder\Form
     */
    protected function getCreateTagTranslationForm($tag, array $locales)
    {
        $form = $this->form('Reactor\Http\Forms\Tags\CreateEditForm', [
            'method' => 'POST',
            'url'    => route('reactor.tags.translation.store', [$tag->getKey()])
        ]);

        $form->addBefore('name', 'locale', 'select', [
            'choices' => $locales
        ]);

        return $form;
    }

}
