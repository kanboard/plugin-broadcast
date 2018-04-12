<?php

namespace Kanboard\Plugin\Broadcast\Schema;

use PDO;

const VERSION = 2;

function version_2(PDO $pdo)
{
    $pdo->exec('ALTER TABLE `broadcast_message` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
}

function version_1(PDO $pdo)
{
    $pdo->exec('CREATE TABLE IF NOT EXISTS broadcast_message (
        message TEXT NOT NULL,
        expire_at INT NOT NULL
    ) ENGINE=InnoDB CHARSET=utf8');
}
