<?php

return [

    'email' => 'Please enter a valid e-mail address.',
    'slug' => 'Can only contain ASCII characters, dashes(-) and underscores(_).',
    'password' => 'Choose a strong password!',
    'password_confirmation' => 'Confirm your password.',
    'published_at' => 'Has to be in YYYY-MM-DD HH:MM:SS format.',

    'public_url' => 'The public address from which the document can be reached.',
    'documents_alttext' => 'Alternative text for the document.',
    'documents_caption' => 'Caption for the document.',
    'documents_embed' => 'The URL of the embeddable media. Allowed platforms: eBay, Facebook, Flickr, Giphy, GitHub, Google, Pastebin, Soundcloud, Twitter, Vimeo, Wikipedia, Youtube.',

    'mailing_lists_type' => 'The provider that handles mailing.',
    'mailing_lists_options' => 'Additional options for the mailing list. Has to be in JSON format.',
    'mailing_lists_external_id' => 'External identifier for the mailing list. Required when the mailing is handled by an external service like Mailchimp.',
    'mailing_lists_from_name' => 'The name from which the mail is being sent from. Required when undefined in the environment file.',
    'mailing_lists_reply_to' => 'The address to which replies will be sent to. Required when undefined in the environment file.',

    'nodes_parent' => 'The parent which the node is going to be moved under.',

    'nodefields_name' => 'Can only contain lowercase ASCII letters and underscores(_).',
    'nodefields_label' => 'Pretty name for the node field.',
    'nodefields_rules' => 'Validation rules for the node field. Should be rules separated with | or an array definition.',
    'nodefields_default_value' => 'Default value for the node field. Can be a static value as well as a function definition.',
    'nodefields_options' => 'Other options for the node field. Should be a series of array key to value definitions.',

    'nodetype_name' => 'Can only contain lowercase ASCII letters.',
    'nodetype_label' => 'Pretty name for the node type.',

    'permissions_name' => 'Should be in this pattern: (ACCESS|EDIT|SITE|REACTOR)(_([A-Z]+))+',

    'roles_label' => 'Readable name for the role.',
    'roles_name' => 'Should only contain uppercase ASCII letters.',
    'tags_title' => 'Name of the tag.',

];