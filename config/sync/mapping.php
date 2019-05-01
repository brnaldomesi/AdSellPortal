<?php
return [
    // {Typ nabídky} advert_function you can find this IDs in Ad types page admin/p_types
    "advert_function" => [
         3 => 'rent',
         4 => 'sale',
    ],
    //////////////////////////// custom Fields ////////////////////////////////
    // {Měna} add the options IDs for this field
    "advert_price_currency" => [
        351 => 'kc',
        352 => 'eur',
        353 => 'usd',
    ],
    // {Jednotka} add the options IDs for this field
    "advert_price_unit" => [
        354 => 'real_estate',
        355 => 'per_month',
        356 => 'per_m2',
        357 => 'per_m2_month',
        358 => 'per_m2_year',
        359 => 'per_year',
        360 => 'per_day',
        361 => 'per_hour',
        362 => 'per_m2_day',
        363 => 'per_m2_hour',
    ],
    // {category} add the categories IDs for this field
    "advert_type" => [
        175 => 'apartment',
        177 => 'house',
        179 => 'land',
        181 => 'commercial',
        183 => 'others',
    ],
    // {sub_category} add the categories IDs for this field
    "advert_subtype" => [
        255 => 'apar_atypical', /// ???? Garsonka
        257 => '1_kk',
        259 => '1_1',
        261 => '2_kk',
        263 => '2_1',
        265 => '3_kk',
        267 => '3_1',
        269 => '4_kk',
        271 => '4_1',
        273 => '5_kk',
        275 => '5_1',
        277 => '6_more',
        279 => '6_more',
        281 => '6_more',
        283 => '6_more',
        285 => 'apar_atypical',
        287 => 'apar_atypical', /// ????? other , Jiný
        289 => 'apar_room',
        243 => 'house_family',
        245 => 'house_other', // ?? Činžovní
        247 => 'house_villa',
        249 => 'house_on_key',
        251 => 'house_other', // ?? Dřevostavby
        253 => 'house_other', // ?? Nízkoenergetické
        227 => 'land_commercial',
        229 => 'land_housing',
        231 => 'land_fields',
        233 => 'land_forest',
        235 => 'land_meadows',
        237 => 'land_gardens',
        239 => 'land_other',
        241 => 'land_sets_vineyards',
        209 => 'com_offices',
        211 => 'com_warehouses',
        213 => 'com_manufacturing',
        215 => 'com_business_premises',
        217 => 'com_accommodation',
        219 => 'com_restaurants',
        221 => 'com_agricultural',
        223 => 'com_others',
        225 => 'com_virtual_office',
        185 => 'others_others', // Chaty
        187 => 'others_garage',
        189 => 'others_others', //Historické objekty
        191 => 'others_others',
        193 => 'others_others', // Chalupy
        195 => 'others_others', // Zemědělské usedlosti
        197 => 'others_others', // Objekty obč. vybavenosti
        199 => 'others_others', // Rybníky
        201 => 'others_wine_cellar',
        203 => 'others_ground_space',
        205 => 'others_garage_parking_space',
        207 => 'others_mobile_home',
    ],
    // {Znepřesnění adresy} add the options IDs for this field
    "locality_inaccuracy_level" => [
        366 => 'exact_address',
        367 => 'street_display',
        368 => 'part_of_city',
    ],
    // {Stav ojektu} add the options IDs for this field
    "building_condition" => [
        172 => 'very_good',
        325 => 'good',
        326 => 'bad',
        327 => 'under_construction',
        328 => 'project',
        329 => 'new',
        330 => 'demolish',
        331 => 'before_reconstruction',
        332 => 'after_reconstruction',
    ],
    // {Typ budovy} add the options IDs for this field
    "building_type" => [
        333 => 'wooden',
        334 => 'brick',
        335 => 'kamenn',
        336 => 'assembled',
        337 => 'panel',
        338 => 'wireframe',
        339 => 'mixed',
    ],
    // {Plocha užitná} add the field ID
    "usable_area" => [
        55 => 'usable_area',
    ],
    // {Objekty} add {Garáž} option ID
    "garage" => [
       378 => 'garage',
    ],
    // {Objekty} add {Parkovací stání} option ID
    "parking_lots" => [
       374 => 'parking_lots'
    ],
    // {Objekty} add {Sklep} option ID
    "cellar" => [
        379 => 'cellar'
    ],
    // {Objekty} add {Bazén} option ID
    "basin" => [
        376 => 'basin'
    ],
    // {Objekty} add {Balkón} option ID
    "balcony" => [
        380 => 'balcony'
    ],
    // {Objekty} add {Lodžie} option ID
    "loggia" => [
        377 => 'loggia'
    ],
    // {Objekty} add {Terasa} option ID
    "terrace" => [
        375 => 'terrace'
    ],
    // {Plocha zastavěná} add the field ID
    "estate_area" => [
        71 => "estate_area"
    ],
    // {Typ domu} add the options IDs for this field
    "object_type" => [
        340 => 'ground_floor',
        341 => 'floor',
    ],
    // {Pokoje} add the options IDs for this field
    "advert_room_count" => [
        345 => '1_rooms',
        346 => '2_rooms',
        347 => '3_rooms',
        348 => '4_rooms',
        349 => '5_rooms',
        350 => 'atypical',
    ],
    // {Podlaží umístění} add the field ID
    "floor_number" => [
        115 => 'floor_number',
    ],
    // {Vlastnictví} add the options IDs for this field
    "ownership" => [
        342 => 'personal',
        343 => 'cooperative',
        344 => 'state_municipal',
    ],
    // {DPH} add the options IDs for this field
    "advert_price_vat" => [
        364 => 'with_vat',
        365 => 'without_vat',
    ],
    // {Poznámka k ceně} add the field ID
    "advert_price_text_note" => [
        87 => 'advert_price_text_note',
    ],
    // {Komunikace} add the options IDs for this field
    "road_type" => [
        381 => 'concrete',
        382 => 'paved',
        383 => 'asphalt',
        384 => 'untreated',
    ],
    // {Voda} add the options IDs for this field
    "water" => [
        385 => 'local_source',
        386 => 'remote_supply',
    ],
    // {Plyn} add the options IDs for this field
    "gas" => [
        387 => 'individual',
        388 => 'gas_pipeline',
    ],
    // {Energetická náročnost budovy} add the options IDs for this field
    "energy_efficiency_rating" => [
        389 => 'extremely_economical',
        390 => 'very_economical',
        391 => 'economical',
        392 => 'low_energy',
        393 => 'inefficient',
        394 => 'very_inefficient',
        395 => 'extremely_wasteful',
    ],
    // {Podle vyhlášky} add the options IDs for this field
    "energy_performance_certificate" => [
        396 => '148_2007',
        397 => '78_2013',
    ],
    // {Telekomunikace} add the options IDs for this field
    "telecommunication" => [
        398 => 'telefon',
        399 => 'internet',
        400 => 'satellite',
        401 => 'cable_tv',
        402 => 'cable_dist',
        403 => 'others',
    ],
    // {Doprava} add the options IDs for this field
    "transport" => [
        404 => 'train',
        405 => 'highway',
        406 => 'roads',
        407 => 'mhd',
        408 => 'bus',
    ],
    // {Elektřina} add the options IDs for this field
    "electricity" => [
       369 => '120v',
       370 => '230v',
       371 => '400v',
    ],
    // {Topení} add the options IDs for this field
    "heating" => [
        409 => 'local_gas',
        410 => 'local_solid',
        411 => 'local_electric',
        412 => 'central_gas',
        413 => 'central_solid',
        414 => 'central_electric',
        415 => 'central_remote',
        416 => 'others',
    ],
];