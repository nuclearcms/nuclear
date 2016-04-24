<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted'              => ':attribute kabul edilmelidir.',
    'active_url'            => ':attribute geçerli bir URL olmalıdır.',
    'after'                 => ':attribute şundan daha eski bir tarih olmalıdır :date.',
    'alpha'                 => ':attribute sadece harflerden oluşmalıdır.',
    'alpha_dash'            => ':attribute sadece harfler, rakamlar ve tirelerden oluşmalıdır.',
    'alpha_num'             => ':attribute sadece harfler ve rakamlar içermelidir.',
    'array'                 => ':attribute dizi olmalıdır.',
    'before'                => ':attribute şundan daha önceki bir tarih olmalıdır :date.',
    'between'               => [
        'numeric' => ':attribute :min - :max arasında olmalıdır.',
        'file'    => ':attribute :min - :max arasındaki kilobayt değeri olmalıdır.',
        'string'  => ':attribute :min - :max arasında karakterden oluşmalıdır.',
        'array'   => ':attribute :min - :max arasında nesneye sahip olmalıdır.',
    ],
    'boolean'               => ':attribute sadece doğru veya yanlış olmalıdır.',
    'confirmed'             => ':attribute tekrarı eşleşmiyor.',
    'date'                  => ':attribute geçerli bir tarih olmalıdır.',
    'date_format'           => ':attribute :format biçimi ile eşleşmiyor.',
    'different'             => ':attribute ile :other birbirinden farklı olmalıdır.',
    'digits'                => ':attribute :digits rakam olmalıdır.',
    'digits_between'        => ':attribute :min ile :max arasında rakam olmalıdır.',
    'email'                 => ':attribute biçimi geçersiz.',
    'exists'                => 'Seçili :attribute geçersiz.',
    'filled'                => ':attribute alanı gereklidir.',
    'image'                 => ':attribute alanı resim dosyası olmalıdır.',
    'in'                    => ':attribute değeri geçersiz.',
    'integer'               => ':attribute tamsayı olmalıdır.',
    'ip'                    => ':attribute geçerli bir IP adresi olmalıdır.',
    'json'                  => 'The :attribute must be a valid JSON string.',
    'max'                   => [
        'numeric' => ':attribute değeri :max değerinden küçük olmalıdır.',
        'file'    => ':attribute değeri :max kilobayt değerinden küçük olmalıdır.',
        'string'  => ':attribute değeri :max karakter değerinden küçük olmalıdır.',
        'array'   => ':attribute değeri :max adedinden az nesneye sahip olmalıdır.',
    ],
    'mimes'                 => ':attribute dosya biçimi :values olmalıdır.',
    'min'                   => [
        'numeric' => ':attribute değeri :min değerinden büyük olmalıdır.',
        'file'    => ':attribute değeri :min kilobayt değerinden büyük olmalıdır.',
        'string'  => ':attribute değeri :min karakter değerinden büyük olmalıdır.',
        'array'   => ':attribute en az :min nesneye sahip olmalıdır.',
    ],
    'not_in'                => 'Seçili :attribute geçersiz.',
    'numeric'               => ':attribute sayı olmalıdır.',
    'regex'                 => ':attribute biçimi geçersiz.',
    'required'              => ':attribute alanı gereklidir.',
    'required_if'           => ':attribute alanı, :other :value değerine sahip olduğunda zorunludur.',
    'required_with'         => ':attribute alanı :values varken zorunludur.',
    'required_with_all'     => ':attribute alanı herhangi bir :values değeri varken zorunludur.',
    'required_without'      => ':attribute alanı :values yokken zorunludur.',
    'required_without_all'  => ':attribute alanı :values değerlerinden herhangi biri yokken zorunludur.',
    'same'                  => ':attribute ile :other eşleşmelidir.',
    'size'                  => [
        'numeric' => ':attribute :size olmalıdır.',
        'file'    => ':attribute :size kilobyte olmalıdır.',
        'string'  => ':attribute :size karakter olmalıdır.',
        'array'   => ':attribute :size nesneye sahip olmalıdır.',
    ],
    'string'                => 'The :attribute must be a string.',
    'timezone'              => ':attribute geçerli bir saat dilimi olmalıdır.',
    'unique'                => ':attribute daha önceden kayıt edilmiş.',
    'url'                   => ':attribute biçimi geçersiz.',

    // Custom rule translations
    'unique_setting' => 'Bu ayar anahtarı daha önceden kayıt edilmiş.',
    'unique_setting_group' => 'Bu ayar grubu anahtarı daha önceden kayıt edilmiş.',
    'date_mysql' => 'Geçersiz tarih-zaman formatı.',
    'not_reserved_field' => 'Bu alan ismi Nuclear için ayrılmıştır.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'title' => 'Başlık',
        'node_name' => 'Düğüm İsmi',
        'email' => 'E-posta',
        'url' => 'URL',
        'text' => 'Metin',
        'source' => 'Kaynak',
        'alt' => 'Alternatif Metin',
        'password' => 'Şifre',
        'password_confirmation' => 'Şifre Onayı',
        'keywords' => 'Anahtar Kelimeler',
        'first_name' => 'Ad',
        'last_name' => 'Soyad',
        'name' => 'İsim',
        'label' => 'Etiket',
        'type' => 'Tip',
        'key' => 'Anahtar',
        'group' => 'Grup',
        'role' => 'Rol',
        'user' => 'Kullanıcı',
        'public_url' => 'Görünür URL',
        'absolute_path' => 'Tam Dosya Yolu',
        'description' => 'Açıklama',
        'visible' => 'Görünür',
        'hides_children' => 'Çocuk Düğümleri Saklar',
        'color' => 'Renk',
        'sterile' => 'Çocuk Düğümleri Engelle',
        'home' => 'Anasayfa Düğümü',
        'locked' => 'Kilitli',
        'status' => 'Durum',
        'position' => 'Pozisyon',
        'rules' => 'Kurallar',
        'options' => 'Seçenekler',
        'content' => 'İçerik',
        'default_value' => 'Öntanımlı Değer',
        'published_at' => 'Yayınlanma Tarihi',
        'created_at' => 'Oluşturulma Tarihi',
        'updated_at' => 'Güncellenme Tarihi',
        'priority' => 'Öncelik',
        'children_order' => 'Çocuk Düğüm Sırası',
        'children_order_direction' => 'Çocuk Düğüm Sırası Yönü',
        'children_display_mode' => 'Çocuk Düğüm Görüntülenme Modu',
        'meta_title' => 'Meta Başlık',
        'meta_keywords' => 'Meta Anahtar Kelimeler',
        'meta_description' => 'Meta Açıklama',
        'meta_author' => 'Meta Yazar',
        'meta_image' => 'Meta Görüntü',
        'locale' => 'Dil',
        'caption' => 'Manşet',
        'taggable' => 'Etiketlenebilir',
        'preview_template' => 'Önizleme Şablonu',
        'tags' => 'Etiketler',
        'image' => 'Görsel',
        'link' => 'Link',
        'cover' => 'Kapak',

        // Settings specific
        'analytics' => 'Google Analytics Anahtarı',
        'site-title' => 'Site Başlığı',
        'site-description' => 'Site Tanımı',
        'site-author' => 'Site Yazarı',
        'social-facebook-url' => 'Facebook URL',
        'social-twitter-username' => 'Twitter Kullanıcı Adı',
        'social-twitter-url' => 'Twitter URL',
        'social-instagram-url' => 'Instagram URL',
        'social-youtube-url' => 'Youtube URL',
    ],

];