<?php

function lang( $phrase ){

    static $lang = array(

        'admin' => 'Home',
        'categories' => 'categories',
        'items' => 'items',
        'members' => 'members',
        'statistics' => 'statistics',
        'Comments' => 'Comments',
        'logs' => 'logs',
        

    );
    return $lang[$phrase];
}