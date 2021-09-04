<?php
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    class_alias(Illuminate\Database\Capsule\Manager::class, 'DB');
    $db = new DB();
    $db->addConnection([
        'driver'    => self::DRIVER,
        'host'      => isset($_ENV['HOST']) ? $_ENV['HOST'] : 'localhost',
        'database'  => isset($_ENV['DATABASE']) ? $_ENV['DATABASE'] : 'database',
        'username'  => isset($_ENV['USERNAME']) ? $_ENV['USERNAME'] : 'root',
        'password'  => isset($_ENV['PASSWORD']) ? $_ENV['PASSWORD'] : 'root',
        'charset'   => 'utf8',
        'collation' => 'utf8_general_ci',
        'prefix'    => '',
    ]);

    $db->setAsGlobal();
    $db->bootEloquent();