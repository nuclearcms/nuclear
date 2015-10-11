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

}
