<?php
/**
 * Created by PhpStorm.
 * User: anikulchin
 * Date: 6/18/15
 * Time: 6:14 PM
 */
return array(
    'native' => array(
        'name' => 'session_name',
        'lifetime' => 600,
    ),
    'cookie' => array(
        'name' => 'cookie_name',
        'encrypted' => TRUE,
        'lifetime' => 43200,
    ),
    'database' => array(
        'name' => 'cookie_name',
        'encrypted' => TRUE,
        'lifetime' => 43200,
        'group' => 'default',
        'table' => 'table_name',
        'columns' => array(
            'session_id'  => 'session_id',
            'last_active' => 'last_active',
            'contents'    => 'contents'
        ),
        'gc' => 500,
    ),
);