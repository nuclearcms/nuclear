<?php


namespace Reactor\Http\Controllers\Traits;


use Illuminate\Http\Request;
use Nuclear\Hierarchy\MailingNode;

trait UsesMailingHelpers {

    /**
     * @param Request $request
     * @return static
     */
    protected function createMailing(Request $request)
    {
        $mailing = new MailingNode;

        $mailing->setNodeTypeByKey($request->input('type'));

        $locale = $this->validateLocale($request, true);

        $mailing->fill([
            $locale => $request->all()
        ]);

        $mailing->makeRoot();

        $mailing->save();

        return $mailing;
    }

}