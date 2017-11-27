<?php

namespace Kanboard\Plugin\Broadcast\Schema;

const VERSION = 1;

function version_1($pdo)
{
    $pdo->exec('CREATE TABLE IF NOT EXISTS broadcast_message (
        message TEXT NOT NULL,
        expire_at INT NOT NULL
    )');
}
