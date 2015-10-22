<?php

namespace Reactor\Http\Forms\Documents;


use Kris\LaravelFormBuilder\Form;

class EmbedForm extends Form {

    public function buildForm()
    {
        $this->add('name', 'text', [
            'rules' => 'required|max:255'
        ]);
        $this->add('mimetype', 'select', [
            'choices' => [
                'video/youtube' => 'Youtube',
                'video/vimeo' => 'Vimeo',
                'audio/soundcloud' => 'Soundcloud'
            ],
            'label' => 'documents.embed_service'
        ]);
        $this->add('path', 'text', [
            'rules' => ['required', 'url', 'regex:#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i'],
            'label' => 'documents.embed_identifier'
        ]);
    }

}
