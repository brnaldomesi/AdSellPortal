<?php
return [
    'active' => (function_exists('env')) ? env('SREALITY_ACTIVE', true) : true,
    'api' => [
        'url' => (function_exists('env')) ? env('SREALITY_API_URL', 'import.sreality.cz') : 'import.sreality.cz',
        'path' => (function_exists('env')) ? env('SREALITY_API_PATH', '/RPC2') : '/RPC2',
        'port' => (function_exists('env')) ? env('SREALITY_API_PORT', '80') : '80',
        // Default Values are the Test Account Value , change it hire or better by .env file
        'clientId' => (function_exists('env')) ? env('SREALITY_API_CLIENTID', '20227') : '20227',
        // md5 hash password
        'password' => (function_exists('env')) ? env('SREALITY_API_PASSWORD', '7e8c6cfb361a72698ac16c16a9056c08') : '7e8c6cfb361a72698ac16c16a9056c08',
        'key' => (function_exists('env')) ? env('SREALITY_API_KEY', 'sreality-test') : 'sreality-test',
        'seller_email' => (function_exists('env')) ? env('SREALITY_SELLER_EMAIL', 'xyz@sreality.cz') : 'xyz@sreality.cz',
        'seller_name' => (function_exists('env')) ? env('SREALITY_SELLER_NAME', 'Tutty') : 'Tutty',
        'seller_mobile' => (function_exists('env')) ? env('SREALITY_SELLER_Mobile', '+420556453345') : '+420556453345',
        'seller_contact_email' => (function_exists('env')) ? env('SREALITY_SELLER_CONTACT_EMAIL', 'seznam@xlabs.systems') : 'seznam@xlabs.systems',
    ],
    'mapping' => [
        "advert_function" => [
            'map' => [
                'sale' => 1,
                'rent' => 2,
            ],
            'options' => [
                'required' => true,
            ],
        ],
        "advert_price_currency" => [
            'map' => [
                'kc' => 1,
                'usd' => 2,
                'eur' => 3,
            ],
            'options' => [
                'required' => true,
            ],
        ],
        "advert_price_unit" => [
            'map' => [
                'real_estate'   => 1,
                'per_month'     => 2,
                'per_m2'        => 3,
                'per_m2_month'  => 4,
                'per_m2_year'   => 5,
                'per_year'      => 6,
                'per_day'       => 7,
                'per_hour'      => 8,
                'per_m2_day'    => 9,
                'per_m2_hour'   => 10,
            ],
            'options' => [
                'required' => true,
            ],
        ],
        "advert_type" => [
            'map' => [
                'apartment'     => 1,
                'house'         => 2,
                'land'          => 3,
                'commercial'    => 4,
                'others'        => 5,
            ],
            'options' => [
                'required' => true,
            ],
        ],
        "locality_inaccuracy_level" => [
            'map' => [
                'exact_address'     => 1,
                'street_display'    => 2,
                'part_of_city'      => 3,
            ],
            'options' => [
                'required' => true,
            ],
        ],
        "building_condition" => [
            'map' => [
                'very_good'             => 1,
                'good'                  => 2,
                'bad'                   => 3,
                'under_construction'    => 4,
                'project'               => 5,
                'new'                   => 6,
                'demolish'              => 7,
                'before_reconstruction' => 8,
                'after_reconstruction'  => 9,
            ],
            'options' => [
                'default' => 0,
                'required_if' => [
                    'advert_type' => [1,2,4,5],
                ],
            ],
        ],
        "building_type" => [
            'map' => [
                'wooden'    => 1,
                'brick'     => 2,
                'kamenn'    => 3,
                'assembled' => 4,
                'panel'     => 5,
                'wireframe' => 6,
                'mixed'     => 7,
            ],
            'options' => [
                'default' => 0,
                'required_if' => [
                    'advert_type' => [1,2,4,5],
                ],
            ],
        ],
        "usable_area" => [
            'options' => [
                'text' => true,
                'default' => '',
                'required_if' => [
                    'advert_type' => [1,2,4,5],
                ],
            ],
        ],
        "garage" => [
            'map' => [
                'garage'    => true,
            ],
            'options' => [
                'default' => false,
                'required_if' => [
                    'advert_type' => [1,2,4],
                ],
            ],
        ],
        "parking_lots" => [
            'map' => [
                'parking_lots'    => true,
            ],
            'options' => [
                'default' => false,
                'required_if' => [
                    'advert_type' => [1,2,4],
                ],
            ],
        ],
        "cellar" => [
            'map' => [
                'cellar'    => true,
            ],
            'options' => [
                'default' => false,
                'required_if' => [
                    'advert_type' => [1,2],
                ],
            ],
        ],
        "basin" => [
            'map' => [
                'basin'    => true,
            ],
            'options' => [
                'default' => false,
                'required_if' => [
                    'advert_type' => [2],
                ],
            ],
        ],
        "balcony" => [
            'map' => [
                'balcony'    => true,
            ],
            'options' => [
                'default' => false,
                'required_if' => [
                    'advert_type' => [1],
                ],
            ],
        ],
        "loggia" => [
            'map' => [
                'loggia'    => true,
            ],
            'options' => [
                'default' => false,
                'required_if' => [
                    'advert_type' => [1],
                ],
            ],
        ],
        "terrace" => [
            'map' => [
                'terrace'    => true,
            ],
            'options' => [
                'default' => false,
                'required_if' => [
                    'advert_type' => [1],
                ],
            ],
        ],
        "estate_area" => [
            'options' => [
                'text' => true,
                'default' => '',
                'required_if' => [
                    'advert_type' => [2,3],
                ],
            ],
        ],
        "object_type" => [
            'map' => [
                'ground_floor'  => 1,
                'floor'         => 2,
            ],
            'options' => [
                'default' => 0,
                'required_if' => [
                    'advert_type' => [2,4],
                ],
            ],
        ],
        "advert_room_count" => [
            'map' => [
                '1_rooms'   => 1,
                '2_rooms'   => 2,
                '3_rooms'   => 3,
                '4_rooms'   => 4,
                '5_rooms'   => 5,
                'atypical'  => 6,
            ],
            'options' => [
                'default' => 0,
                'required_if' => [
                    'advert_type' => [2],
                ],
            ],
        ],
        "floor_number" => [
            'options' => [
                'text' => true,
                'default' => 0,
                'required_if' => [
                    'advert_type' => [1],
                ],
            ],
        ],
        "ownership" => [
            'map' => [
                'personal'          => 1,
                'cooperative'       => 2,
                'state_municipal'   => 3,
            ],
            'options' => [
                'default' => 0,
                'required_if' => [
                    'advert_type' => [1],
                ],
            ],
        ],
        "advert_price_vat" => [
            'map' => [
                'with_vat'          => 1,
                'without_vat'       => 2,
            ],
        ],
        "advert_price_text_note" => [
            'options' => [
                'text' => true,
            ],
        ],
        "road_type" => [
            'map' => [
                'concrete'  => 1,
                'paved'     => 2,
                'asphalt'   => 3,
                'untreated' => 4,
            ],
            'options' => [
                'multi' => true,
            ],
        ],
        "water" => [
            'map' => [
                'local_source'  => 1,
                'remote_supply' => 2,
            ],
            'options' => [
                'multi' => true,
            ],
        ],
        "gas" => [
            'map' => [
                'individual'    => 1,
                'gas_pipeline'  => 2,
            ],
            'options' => [
                'multi' => true,
            ],
        ],
        "energy_efficiency_rating" => [
            'map' => [
                'extremely_economical'  => 1,
                'very_economical'       => 2,
                'economical'            => 3,
                'low_energy'            => 4,
                'inefficient'           => 5,
                'very_inefficient'      => 6,
                'extremely_wasteful'    => 7,
            ],
        ],
        "energy_performance_certificate" => [
            'map' => [
                '148_2007'  => 1,
                '78_2013'   => 2,
            ],
        ],
        "telecommunication" => [
            'map' => [
                'telefon'       => 1,
                'internet'      => 2,
                'satellite'     => 3,
                'cable_tv'      => 4,
                'cable_dist'    => 5,
                'others'        => 6,
            ],
            'options' => [
                'multi' => true,
            ],
        ],
        "transport" => [
            'map' => [
                'train'     => 1,
                'highway'   => 2,
                'roads'     => 3,
                'mhd'       => 4,
                'bus'       => 5,
            ],
            'options' => [
                'multi' => true,
            ],
        ],
        "electricity" => [
            'map' => [
                '120v'  => 1,
                '230v'  => 2,
                '400v'  => 4,

            ],
            'options' => [
                'multi' => true,
            ],
        ],
        "heating" => [
            'map' => [
                'local_gas'         => 1,
                'local_solid'       => 2,
                'local_electric'    => 3,
                'central_gas'       => 4,
                'central_solid'     => 5,
                'central_electric'  => 6,
                'central_remote'    => 7,
                'others'            => 8,
            ],
            'options' => [
                'multi' => true,
            ],
        ],
        "advert_subtype" => [
            'map' => [
                '1_kk' => 2,
                '1_1' => 3,
                '2_kk' => 4,
                '2_1' => 5,
                '3_kk' => 6,
                '3_1' => 7,
                '4_kk' => 8,
                '4_1' => 9,
                '5_kk' => 10,
                '5_1' => 11,
                '6_more' => 12,
                'apar_atypical' => 16,
                'apar_room' => 47,
                'house_family' => 37,
                'house_other' => 35,
                'house_villa' => 39,
                'house_on_key' => 40,
                'land_commercial' => 18,
                'land_housing' => 19,
                'land_fields' => 20,
                'land_forest' => 21,
                'land_meadows' => 22,
                'land_gardens' => 23,
                'land_other' => 24,
                'land_sets_vineyards' => 48,
                'com_offices' => 25,
                'com_warehouses' => 26,
                'com_manufacturing' => 27,
                'com_business_premises' => 28,
                'com_accommodation' => 29,
                'com_restaurants' => 30,
                'com_agricultural' => 31,
                'com_others' => 32,
                'com_virtual_office' => 49,
                'others_garage' => 34,
                'others_others' => 36,
                'others_wine_cellar' => 50,
                'others_ground_space' => 51,
                'others_garage_parking_space' => 52,
                'others_mobile_home' => 53,
            ],
        ],
    ]
];
