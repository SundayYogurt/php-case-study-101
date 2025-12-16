<?php

declare(strict_types=1);

// Database connection settings
return [
    'db' => [
        'driver'   => 'mysql',
        'host'     => '127.0.0.1',
        'name'     => 'devclub_db',   // แก้เป็นชื่อฐานข้อมูลของคุณ
        'username' => 'root',         // แก้เป็นผู้ใช้ของคุณ
        'password' => '',             // แก้เป็นรหัสผ่านของคุณ
        'charset'  => 'utf8mb4',
    ],
];
