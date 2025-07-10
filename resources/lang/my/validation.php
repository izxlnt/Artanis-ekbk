<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute mesti diterima.',
    'active_url'           => ':attribute bukan URL yang sah.',
    'after'                => ':attribute mesti tarikh selepas :date.',
    'after_or_equal'       => ':attribute mesti tarikh selepas atau sama dengan :date.',
    'alpha'                => ':attribute hanya boleh mengandungi huruf.',
    'alpha_dash'           => ':attribute hanya boleh mengandungi huruf, angka, dan tanda hubung.',
    'alpha_num'            => ':attribute hanya boleh mengandungi huruf dan angka.',
    'array'                => ':attribute mestilah array.',
    'before'               => ':attribute mesti tarikh sebelum ini :date.',
    'before_or_equal'      => ':attribute mesti tarikh sebelum atau sama dengan :date.',
    'between'              => [
        'numeric' => ':attribute mesti antara :min dan :max.',
        'file'    => ':attribute mesti antara :min dan :max kilobyte.',
        'string'  => 'No. Telefon mestilah sekurang-kurangnya 9 digit dan maksimum 11 digit.',
        'array'   => ':attribute mesti antara :min dan :max item.',
    ],
    'boolean'              => ':attribute mesti betul atau salah.',
    'confirmed'            => ':attribute pengesahan tidak sepadan.',
    'date'                 => ':attribute bukan tarikh yang sah.',
    'date_format'          => ':attribute tidak sesuai dengan format :format.',
    'different'            => ':attribute dan :other mesti berbeza.',
    'digits'               => ':attribute mesti mempunyai :digits digit.',
    'digits_between'       => ':attribute must be between :min dan :max digit.',
    'dimensions'           => ':attribute mempunyai dimensi gambar yang tidak sah.',
    'distinct'             => ':attribute medan mempunyai nilai pendua/sama.',
    'email'                => 'Sila masukkan alamat e-mel yang sah.',
    'exists'               => 'Pilihan :attribute tidak sah.',
    'file'                 => ':attribute mesti fail.',
    'filled'               => ':attribute bidang mesti mempunyai nilai.',
    'image'                => 'Bahagian ini mestilah dalam format imej.',
    'in'                   => 'Pilihan :attribute tidak sah.',
    'in_array'             => ':attribute bidang tidak wujud di :other.',
    'integer'              => ':attribute mestilah dalam format nombor.',
    'ip'                   => ':attribute mestilah alamat IP yang sah.',
    'json'                 => ':attribute mestilah string JSON yang sah.',
    'max'                  => [
        'numeric' => ':attribute mungkin tidak lebih besar daripada :max.',
        'file'    => ':attribute mungkin tidak lebih besar daripada :max kilobyte.',
        'string'  => ':attribute mungkin tidak lebih besar daripada :max huruf.',
        'array'   => ':attribute mungkin tidak mempunyai lebih daripada :max item.',
    ],
    'mimes'                => 'Gambar yang dimuatnaik mestilah jenis fail: :values.',
    'mimetypes'            => ':attribute mestilah jenis fail: :values.',
    'min'                  => [
        'numeric' => ':attribute mesti sekurang-kurangnya :min.',
        'file'    => ':attribute mesti sekurang-kurangnya :min kilobyte.',
        'string'  => 'No. Telefon mestilah sekurang-kurangnya 9 digit dan maksimum 11 digit.',
        'array'   => ':attribute mesti sekurang-kurangnya :min item.',
    ],
    'not_in'               => 'Pilihan :attribute tidak sah.',
    'numeric'              => ':attribute mesti nombor.',
    'present'              => 'Ruangan :attribute mesti wujud.',
    'regex'                => ':attribute format is invalid.',
    'required'             => 'Ruangan ini wajib di isi',
    'required_if'          => ':attribute wajib di isi bila :other adalah :value.',
    'required_unless'      => ':attribute wajib di isi bila melainkan :other adalah :values.',
    'required_with'        => ':attribute wajib di isi bila :values adalah wujud.',
    'required_with_all'    => ':attribute wajib di isi bila :values adalah wujud.',
    'required_without'     => ':attribute wajib di isi bila :values adalah tidak wujud.',
    'required_without_all' => ':attribute wajib di isi bila apabila tiada :values wujud.',
    'same'                 => ':attribute dan :other mesti sama.',
    'size'                 => [
        'numeric' => ':attribute mesti :size.',
        'file'    => ':attribute mesti mempunyai :size kilobyte',
        'string'  => ':attribute mesti mempunyai :size huruf.',
        'array'   => ':attribute mesti mengandungi :size item.',
    ],
    'string'               => ':attribute mesti dalan nilai String.',
    'timezone'             => ':attribute mestilah zon yang sah.',
    'unique'               => 'Maklumat yang diisi telah digunakan.',
    'uploaded'             => ':attribute gagal memuat naik.',
    'url'                  => ':attribute format tidak sah.',

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

    'attributes' => [],

];
