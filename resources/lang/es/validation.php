<?php 

return [
    'accepted' => ':attribute debe ser aceptado.',
    'active_url' => ':attribute no es una URL válida.',
    'after' => ':attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => ':attribute debe ser una fecha posterior o igual a :date.',
    'alpha' => ':attribute sólo debe contener letras.',
    'alpha_dash' => ':attribute sólo debe contener letras, números y guiones.',
    'alpha_num' => ':attribute sólo debe contener letras y números.',
    'array' => ':attribute debe ser un conjunto.',
    'before' => ':attribute debe ser una fecha anterior a :date.',
    'before_or_equal' => ':attribute debe ser una fecha anterior o igual a :date.',
    'between' => [
        'numeric' => ':attribute tiene que estar entre :min - :max.',
        'file' => ':attribute debe pesar entre :min - :max kilobytes.',
        'string' => ':attribute tiene que tener entre :min - :max caracteres.',
        'array' => ':attribute tiene que tener entre :min - :max ítems.',
    ],
    'boolean' => 'El campo :attribute debe tener un valor verdadero o falso.',
    'confirmed' => 'La confirmación de :attribute no coincide.',
    'date' => ':attribute no es una fecha válida.',
	'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => ':attribute no corresponde al formato :format.',
    'different' => ':attribute y :other deben ser diferentes.',
    'digits' => ':attribute debe tener :digits dígitos.',
    'digits_between' => ':attribute debe tener entre :min y :max dígitos.',
    'dimensions' => 'Las dimensiones de la imagen :attribute no son válidas.',
    'distinct' => 'El campo :attribute contiene un valor duplicado.',
    'email' => ':attribute no es un correo válido',
    'exists' => ':attribute es inválido.',
    'file' => 'El campo :attribute debe ser un archivo.',
    'filled' => 'El campo :attribute es obligatorio.',
    'image' => ':attribute debe ser una imagen.',
    'in' => ':attribute es inválido.',
    'in_array' => 'El campo :attribute no existe en :other.',
    'integer' => ':attribute debe ser un número entero.',
    'ip' => ':attribute debe ser una dirección IP válida.',
    'json' => 'El campo :attribute debe tener una cadena JSON válida.',
    'max' => [
        'numeric' => ':attribute no debe ser mayor a :max.',
        'file' => ':attribute no debe ser mayor que :max kilobytes.',
        'string' => ':attribute no debe ser mayor que :max caracteres.',
        'array' => ':attribute no debe tener más de :max elementos.',
    ],
    'mimes' => ':attribute debe ser un archivo con formato: :values.',
    'mimetypes' => ':attribute debe ser un archivo con formato: :values.',
    'min' => [
        'numeric' => 'El tamaño de :attribute debe ser de al menos :min.',
        'file' => 'El tamaño de :attribute debe ser de al menos :min kilobytes.',
        'string' => ':attribute debe contener al menos :min caracteres.',
        'array' => ':attribute debe tener al menos :min elementos.',
    ],
    'not_in' => ':attribute es inválido.',
    'numeric' => ':attribute debe ser numérico.',
    'present' => 'El campo :attribute debe estar presente.',
    'regex' => 'El formato de :attribute es inválido.',
    'required' => 'El campo :attribute es obligatorio.',
    'required_if' => 'El campo :attribute es obligatorio cuando :other es :value.',
    'required_unless' => 'El campo :attribute es obligatorio a menos que :other esté en :values.',
    'required_with' => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all' => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_without' => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ninguno de :values estén presentes.',
    'same' => ':attribute y :other deben coincidir.',
    'size' => [
        'numeric' => 'El tamaño de :attribute debe ser :size.',
        'file' => 'El tamaño de :attribute debe ser :size kilobytes.',
        'string' => ':attribute debe contener :size caracteres.',
        'array' => ':attribute debe contener :size elementos.',
    ],
	'starts_with' => 'The :attribute must start with one of the following: :values',
    'string' => 'El campo :attribute debe ser una cadena de caracteres.',
    'timezone' => 'El :attribute debe ser una zona válida.',
    'unique' => ':attribute ya ha sido registrado.',
    'uploaded' => 'Subir :attribute ha fallado.',
    'url' => 'El formato :attribute es inválido.',
    'whitelist_email' => 'This email address is blacklisted.',
    'whitelist_domain' => 'The domain of your email address is blacklisted.',
    'whitelist_word' => 'The :attribute contains a banned words or phrases.',
    'whitelist_word_title' => 'The :attribute contains a banned words or phrases.',
    'mb_between' => 'The :attribute must be between :min and :max characters.',
    'recaptcha' => 'The :attribute field is not correct.',
    'phone' => 'The :attribute field contains an invalid number.',
    'dumbpwd' => 'This password is just too common. Please try another!',
    'phone_number' => 'The :attribute must be a valid phone number.',
    'valid_username' => 'The :attribute field must be an alphanumeric string.',
    'allowed_username' => 'The :attribute is not allowed.',
    'custom' => [
        'database_connection' => [
            'required' => 'No se puede conectar al servidor MySQL',
        ],
        'database_not_empty' => [
            'required' => 'La base de datos no está vacía',
        ],
        'promo_code_not_valid' => [
            'required' => 'El código promocional no es válido',
        ],
        'smtp_valid' => [
            'required' => 'No se puede conectar al servidor SMTP',
        ],
        'yaml_parse_error' => [
            'required' => 'No se puede analizar yaml. Compruebe la sintaxis',
        ],
        'file_not_found' => [
            'required' => 'Archivo no encontrado.',
        ],
        'not_zip_archive' => [
            'required' => 'El archivo no es un paquete zip.',
        ],
        'zip_archive_unvalid' => [
            'required' => 'No se puede leer el paquete.',
        ],
        'custom_criteria_empty' => [
            'required' => 'Los criterios personalizados no pueden estar vacíos',
        ],
        'php_bin_path_invalid' => [
            'required' => 'Ejecutable PHP no válido. Por favor revise de nuevo.',
        ],
        'can_not_empty_database' => [
            'required' => 'No puede eliminar determinadas tablas, por favor, limpie su base de datos y vuelva a intentarlo.',
        ],
        'recaptcha_invalid' => [
            'required' => 'Comprobación reCAPTCHA no válida.',
        ],
        'payment_method_not_valid' => [
            'required' => 'Algo salió mal con la configuración del método de pago. Por favor revise de nuevo.',
        ],
    ],
    'attributes' => [
        'gender' => 'género',
        'gender_id' => 'género',
        'name' => 'nombre',
        'first_name' => 'nombre',
        'last_name' => 'last name',
        'user_type' => 'tipo de usuario',
        'user_type_id' => 'tipo de usuario',
        'country' => 'país',
        'country_code' => 'país',
        'phone' => 'teléfono',
        'address' => 'dirección',
        'mobile' => 'móvil',
        'sex' => 'sexo',
        'year' => 'año',
        'month' => 'mes',
        'day' => 'día',
        'hour' => 'hora',
        'minute' => 'minuto',
        'second' => 'segundo',
        'username' => 'usuario',
        'email' => 'correo electrónico',
        'password' => 'contraseña',
        'password_confirmation' => 'confirmación de la contraseña',
        'g-recaptcha-response' => 'captcha',
        'term' => 'terms',
        'category' => 'category',
        'category_id' => 'category',
        'post_type' => 'post type',
        'post_type_id' => 'post type',
        'title' => 'título',
        'body' => 'contenido',
        'description' => 'descripción',
        'excerpt' => 'extracto',
        'date' => 'fecha',
        'time' => 'hora',
        'available' => 'available',
        'size' => 'size',
        'price' => 'price',
        'salary' => 'salary',
        'contact_name' => 'name',
        'location' => 'location',
        'admin_code' => 'location',
        'city' => 'ciudad',
        'city_id' => 'ciudad',
        'package' => 'package',
        'package_id' => 'package',
        'payment_method' => 'payment method',
        'payment_method_id' => 'payment method',
        'sender_name' => 'name',
        'subject' => 'asunto',
        'message' => 'mensaje',
        'report_type' => 'report type',
        'report_type_id' => 'report type',
        'file' => 'file',
        'filename' => 'filename',
        'picture' => 'picture',
        'resume' => 'resume',
        'login' => 'login',
        'code' => 'code',
        'token' => 'token',
        'comment' => 'comment',
        'rating' => 'rating',
    ],
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'not_regex' => 'The :attribute format is invalid.',
    'language_check_locale' => 'The :attribute field is not valid.',
    'country_check_locale' => 'The :attribute field is not valid.',
    'check_currencies' => 'The :attribute field is not valid.',
    'attributes.locale' => 'locale',
    'attributes.currencies' => 'currencies',
];
