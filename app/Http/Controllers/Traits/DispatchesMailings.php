<?php


namespace Reactor\Http\Controllers\Traits;


use igaster\laravelTheme\Facades\Theme;
use Illuminate\Support\Facades\Mail;
use Nuclear\Hierarchy\MailingNode;
use Nuclear\Hierarchy\Mailings\MailingList;

trait DispatchesMailings {

    /**
     * Dispatches Mailchimp mailing
     *
     * @param MailingNode $mailing
     * @param MailingList $list
     */
    protected function dispatchMailchimpMailing(MailingNode $mailing, MailingList $list)
    {

    }

    /**
     * Dispatches default mailing
     *
     * @param MailingNode $mailing
     * @param MailingList $list
     */
    protected function dispatchDefaultMailing(MailingNode $mailing, MailingList $list)
    {
        $translation = $mailing->translateOrFirst();
        $_inBrowser = false;

        // Before this we are in the reactor theme by default
        Theme::set(config('themes.active_mailings'));

        $recipients = $list->subscribers->pluck('email')->toArray();

        Mail::send($mailing->getNodeTypeName(),
            compact('mailing', 'translation', '_inBrowser', 'list'),
            function ($message) use ($mailing, $list, $recipients)
            {
                $message
                    ->subject($mailing->getTitle())
                    ->bcc($recipients)
                    ->replyTo($list->reply_to ?: config('mail.from.address'))
                    ->from(config('mail.from.address'), $list->from_name ?: config('mail.from.name'));
            });
    }

}