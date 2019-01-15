<?php

\DB::table('settings')->where('field', '=', '')->update(array('field' => '{"name":"value","label":"Value","type":"text"}'));
\DB::table('settings')->where('key', '=', 'ads_pictures_number')->update(array('lft' => '14', 'rgt' => '15', 'depth' => '1'));
\DB::table('settings')->where('key', '=', 'custom_css')->update(array('lft' => '124', 'rgt' => '125', 'depth' => '1'));
\DB::table('settings')->where('key', '=', 'show_ad_on_googlemap')->update(array('lft' => '22', 'rgt' => '23', 'depth' => '1'));
