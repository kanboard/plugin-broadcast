<?php

namespace Kanboard\Plugin\Broadcast\Model;

use Kanboard\Core\Base;
use Kanboard\Model\UserModel;

class BroadcastMessageModel extends Base
{
    const TABLE = 'broadcast_message';

    public function save($message, $expireAt)
    {
        $this->clear();
        return $this->db->table(self::TABLE)->insert([
            'message' => $message,
            'expire_at' => $expireAt === '' ? time() : $this->dateParser->getTimestamp($expireAt),
        ]);
    }

    public function clear()
    {
        return $this->db->table(self::TABLE)->remove();
    }

    public function getMessage()
    {
        return $this->db->table(self::TABLE)->findOne();
    }

    public function getUserEmails()
    {
        return $this->db->table(UserModel::TABLE)
            ->eq('is_active', 1)
            ->neq('email', '')
            ->notNull('email')
            ->columns('email', 'username', 'name')
            ->findAll();
    }
}
