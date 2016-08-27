<?php


namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Nuclear\Hierarchy\Tags\Tag;
use Reactor\Http\Controllers\Traits\BasicResource;
use Reactor\Http\Controllers\Traits\UsesTagForms;
use Reactor\Http\Controllers\Traits\UsesTranslations;

class TagsController extends ReactorController {

    use BasicResource, UsesTagForms, UsesTranslations
    {
        edit as _edit;
        update as _update;
    }

    /**
     * Names for the BasicResource trait
     *
     * @var string
     */
    protected $modelPath = Tag::class;
    protected $resourceMultiple = 'tags';
    protected $resourceSingular = 'tag';
    protected $permissionKey = 'TAGS';
    protected $translatable = true;

    /**
     * Show the form for editing the specified resources translation.
     *
     * @param  int $id
     * @param  int $translation
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $translation)
    {
        return $this->editTranslated($id, $translation);
    }

    /**
     * Update the specified resources translation in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @param  int $translation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $translation)
    {
        return $this->updateTranslated($request, $id, $translation);
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
        $this->authorize('EDIT_TAGS');

        $tag = Tag::findOrFail($id);

        list($locale, $translation) = $this->determineLocaleAndTranslation($translation, $tag);

        if (count($locales = $this->getAvailableLocales($tag)) === 0)
        {
            flash()->error(trans('general.no_available_locales'));

            return redirect()->back();
        }

        $form = $this->getCreateTranslationForm($tag, $locales);

        return $this->compileView('tags.translate', compact('form', 'tag', 'translation'), trans('general.add_translation'));
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
        $this->authorize('EDIT_TAGS');

        $tag = Tag::findOrFail($id);

        $this->validateCreateTranslationForm($request);

        $locale = $this->validateLocale($request);

        $tag->update([
            $locale => $request->all()
        ]);

        $this->notify('general.added_translation');

        return redirect()->route('reactor.tags.edit', [
            $tag->getKey(),
            $tag->translate($locale)->getKey()
        ]);
    }

    /**
     * Determines the current editing locale
     *
     * @param int $translation
     * @param Tag $tag
     * @return string
     */
    protected function determineLocaleAndTranslation($translation, Tag $tag)
    {
        $translation = $tag->translations->find($translation);

        if (is_null($translation))
        {
            abort(404);
        }

        return [$translation->locale, $translation];
    }

}