<?php


namespace Reactor\Http\Controllers;


use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;

abstract class ReactorController extends Controller {

    use FormBuilderTrait;

    /**
     * Validates a form
     *
     * @param string
     * @param Request $request
     * @param array $overrideRules
     * @return void|Response
     */
    public function validateForm($form, Request $request, array $overrideRules = [])
    {
        $form = $this->form($form);

        // We set the flash message here because there is nowhere else to do it
        flash()->error(trans('general.error_saving'));

        $this->validate(
            $request,
            $form->getRules($overrideRules)
        );

        // We forget the message back again as the validation passed
        session()->forget('flash_notification');
    }

    /**
     * Flash and chronicle notification
     *
     * @param string $flash
     * @param null|string $activity
     * @param null|Model $subject
     * @param string $type
     */
    public function notify($flash = null, $activity = null, $subject = null, $type = 'success')
    {
        if ( ! is_null($flash))
        {
            flash()->{$type}(trans($flash));
        }

        if ( ! is_null($activity))
        {
            chronicle()->record($subject, $activity);
        }
    }

    /**
     * Compiles view for display
     *
     * @param string $view
     * @param array $parameters
     * @param string $title
     * @return view
     */
    protected function compileView($view, array $parameters = [], $title = null)
    {
        $parameters['pageTitle'] = ($title ?: trans($view));

        return view($view, $parameters);
    }

}