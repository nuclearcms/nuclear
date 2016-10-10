<?php

namespace Reactor\Mailings;


use GuzzleHttp\Client;
use Nuclear\Hierarchy\Mailings\MailingList;
use Nuclear\Hierarchy\Mailings\Subscriber;

class MailingService {

    use DispatchesMailings;

    /**
     * Creates a new Guzzle client to communicate with mailchimp
     *
     * @return Client
     */
    protected function getNewMailchimpGuzzleClient()
    {
        return new Client([
            'base_url' => env('MAILCHIMP_API_URL'),
            'defaults' => [
                'auth' => ['anystring', env('MAILCHIMP_API_KEY')]
            ]
        ]);
    }

    /**
     * Subscribes an email to a list
     * (depending on the list type)
     *
     * @param string email
     * @param string $list
     */
    public function subscribeMemberTo($email, $list)
    {
        $subscriber = Subscriber::firstOrCreate(compact('email'));
        $list = MailingList::findOrFail($list);

        if ($this->isMemberSubscribedTo($subscriber, $list))
        {
            return;
        }

        $list->subscribers()->attach($subscriber);

        if ($list->type === 'mailchimp')
        {
            $this->subscribeToMailchimpList($subscriber, $list);
        }
    }

    /**
     * Subscribes a member to a mailchimp list
     *
     * @param Subscriber $subscriber
     * @param MailingList $list
     */
    protected function subscribeToMailchimpList(Subscriber $subscriber, MailingList $list)
    {
        $client = $this->getNewMailchimpGuzzleClient();

        $client->post('lists/' . $list->external_id . '/members', [
            'json'    => [
                'email_address' => $subscriber->email,
                'status' => 'subscribed'
            ]
        ]);
    }

    /**
     * Checks if a member is subscribed to a list
     *
     * @param Subscriber $subscriber
     * @param MailingList $list
     */
    protected function isMemberSubscribedTo(Subscriber $subscriber, MailingList $list)
    {
        return $subscriber->lists->contains($list->getKey());
    }

}