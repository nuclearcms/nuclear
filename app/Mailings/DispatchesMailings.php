<?php

namespace Reactor\Mailings;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use Nuclear\Hierarchy\MailingNode;
use Nuclear\Hierarchy\Mailings\MailingList;

trait DispatchesMailings {

    /**
     * Dispatches default mailing
     *
     * @param MailingNode $mailing
     * @param MailingList $list
     */
    public function dispatchDefaultMailing(MailingNode $mailing, MailingList $list)
    {
        $translation = $mailing->translateOrFirst();
        $_inBrowser = false;

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

    /**
     * Dispatches Mailchimp mailing
     *
     * @param MailingNode $mailing
     * @param MailingList $list
     */
    public function dispatchMailchimpMailing(MailingNode $mailing, MailingList $list)
    {
        $client = $this->getNewMailchimpGuzzleClient();

        if ($mailingId = $mailing->getExternalId($list->getKey()))
        {
            $this->makeUpdateMailchimpCampaignRequest($client, $mailingId, $mailing, $list);
        } else
        {
            $response = $this->makeCreateMailchimpCampaignRequest($client, $mailing, $list);
            $mailingId = $response->json()['id'];

            $mailing->setExternalId($list->getKey(), $mailingId);
        }

        $this->makeUpdateMailchimpCampaignContentRequest($client, $mailingId, $mailing, $list);
    }

    /**
     * Creates a mailchimp campaign
     *
     * @param Client $client
     * @param MailingNode $mailing
     * @param MailingList $list
     * @return string $campaignId
     */
    protected function makeCreateMailchimpCampaignRequest(Client $client, MailingNode $mailing, MailingList $list)
    {
        $data = $this->compileDefaultMailchimpData($mailing, $list);

        return $client->post('campaigns', $data);
    }

    /**
     * Creates a mailchimp campaign
     *
     * @param Client $client
     * @param string $mailingId
     * @param MailingNode $mailing
     * @param MailingList $list
     * @return string $campaignId
     */
    protected function makeUpdateMailchimpCampaignRequest(Client $client, $mailingId, MailingNode $mailing, MailingList $list)
    {
        $data = $this->compileDefaultMailchimpData($mailing, $list);

        $data['headers']['X-HTTP-Method-Override'] = 'PATCH';

        return $client->post('campaigns/' . $mailingId, $data);
    }

    /**
     * Compiles default mailchimp data
     *
     * @param MailingNode $mailing
     * @param MailingList $list
     * @return array
     */
    protected function compileDefaultMailchimpData(MailingNode $mailing, MailingList $list)
    {
        $data = [
            'json' => [
                'type'     => 'regular',
                'settings' => [
                    'subject_line' => $mailing->getTitle(),
                    'title'        => $mailing->getTitle(),
                    'from_name'    => $list->from_name ?: env('MAILCHIMP_FROMNAME'),
                    'reply_to'     => $list->reply_to ?: env('MAILCHIMP_REPLYTO')
                ]
            ]
        ];

        if ($list->external_id)
        {
            $data['json']['recipients']['list_id'] = $list->external_id;
        }

        $additional = (array)json_decode($list->additional, true);
        $data = array_merge_recursive($data, $additional);

        return $data;
    }

    /**
     * Populates a mailchimp campaign content
     *
     * @param Client $client
     * @param string $mailingId
     * @param MailingNode $mailing
     * @param MailingList $list
     * @return string $campaignId
     */
    protected function makeUpdateMailchimpCampaignContentRequest(Client $client, $mailingId, MailingNode $mailing, MailingList $list)
    {
        $translation = $mailing->translateOrFirst();
        $_inBrowser = false;

        $mail = view($mailing->getNodeTypeName(), compact('mailing', 'list', 'translation', '_inBrowser'))->render();

        return $client->post('campaigns/' . $mailingId . '/content', [
            'headers' => [
                'X-HTTP-Method-Override' => 'PUT'
            ],
            'json'    => [
                'html' => $mail,
                'url'  => route('reactor.mailings.preview', $mailing->translateOrFirst()->node_name)
            ]
        ]);
    }

}