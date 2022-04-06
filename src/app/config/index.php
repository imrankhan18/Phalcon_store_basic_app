<?php

use Phalcon\Config;

return [
   'app'=> [
       'name'=>'My App',
       'version'=>'2.o',

    ],
   'db'=> [
        'host'     => 'mysql-server',
        'username' => 'root',
        'password' => 'secret',
        'dbname'   => 'test',
    ]
];

// return [
//    'app' => [
//         'name'     => 'My crazy App',
//         'version' => '2.o',
//         'time' => time()
//    ],
// ];
