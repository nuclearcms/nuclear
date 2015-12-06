<?php

return [
    /*
	|--------------------------------------------------------------------------
	| Default Processors for Synthesizer
	|--------------------------------------------------------------------------
	|
	| Here are the default processors that are registered by the service provider.
    | You may add, modify or remove processors here. The processors are lazy
    | loaded if you register them with the class namespaces. This means that they
    | are not instantiated until they are called.
	|
	*/
    'processors' => [
        'markdown'          => 'Kenarkose\Synthesizer\Processor\MarkdownProcessor',
        'markdownExtra'     => 'Kenarkose\Synthesizer\Processor\MarkdownExtraProcessor',
        'markdownGithub'    => 'Kenarkose\Synthesizer\Processor\GithubMarkdownProcessor',
        'markdownParagraph' => 'Kenarkose\Synthesizer\Processor\MarkdownParagraphProcessor',
        'htmlspecialchars'  => 'Kenarkose\Synthesizer\Processor\HTMLSpecialCharsProcessor',
        'striptags'         => 'Kenarkose\Synthesizer\Processor\StripTagsProcessor',

        /* Reactor only */
        'readAll'           => 'Reactor\Synthesizer\ReadAllProcessor',
        'readBefore'        => 'Reactor\Synthesizer\ReadBeforeProcessor',
        'readRest'          => 'Reactor\Synthesizer\ReadRestProcessor',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Macros for Synthesizer
    |--------------------------------------------------------------------------
    |
    | Here are the default macros that are registered by the service provider.
    | You may remove any or add further macros here.
    |
    */
    'macros'     => [
        'markdown'           => ['htmlspecialchars', 'markdown'],
        'markdownExtra'      => ['htmlspecialchars', 'markdownExtra'],
        'markdownInline'     => ['htmlspecialchars', 'markdownParagraph'],
        'markdownGithub'     => ['htmlspecialchars', 'markdownGithub'],
        'textOnlyMarkdown'   => ['markdownExtra', 'striptags', 'htmlspecialchars'],

        /* Reactor only */
        'HTMLmarkdown'       => ['readAll', 'markdownGithub'],
        'HTMLmarkdownBefore' => ['readBefore', 'markdownGithub'],
        'HTMLmarkdownRest'   => ['readRest', 'markdownGithub'],
    ]

];