<?php


namespace Reactor\Html\Forms\Nodes;


use Kris\LaravelFormBuilder\Form;

class EditSEOForm extends Form {

    public function buildForm()
    {
        $this->add('meta_title', 'text', [
            'rules' => 'max:255',
            'fullWidth' => true,
            'attr' => ['autocomplete' => 'off']
        ]);
        $this->add('meta_keywords', 'text', [
            'rules' => 'max:255',
            'fullWidth' => true,
            'attr' => ['autocomplete' => 'off']
        ]);
        $this->add('meta_description', 'textarea', [
            'fullWidth' => true,
            'attr' => ['autocomplete' => 'off']
        ]);
        $this->add('meta_author', 'text', [
            'fullWidth' => true,
            'attr' => ['autocomplete' => 'off']
        ]);
        $this->add('meta_image', 'document', [
            'fullWidth' => true,
            'filter' => 'image'
        ]);
    }

}