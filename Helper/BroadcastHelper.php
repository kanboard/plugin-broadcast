<?php

namespace Kanboard\Plugin\Broadcast\Helper;

use Kanboard\Core\Base;
use Kanboard\Plugin\Broadcast\Model\BroadcastMessageModel;

class BroadcastHelper extends Base
{
    public function render()
    {
        $broadcast = BroadcastMessageModel::getInstance($this->container)->getMessage();


        if (! empty($broadcast) && time() < $broadcast['expire_at'] && !$this->userMetadataModel->exists($this->userSession->getId(), 'ignore_broadcast_message')) {
            $html = '<div id="broadcast-message"><div id="broadcast-message-inner">';
            $html .= '<div class="page-header"><h2>'.t('Announcement').'</h2></div>';
            $html .= '<div class="markdown">'.$this->helper->text->markdown($broadcast['message']).'</div>';
            $html .= '<div class="form-actions"><a href="'.$this->helper->url->href('BroadcastController', 'dismiss', array('plugin' => 'Broadcast')).'" class="btn btn-blue">'.t('Close').'</a></div>';
            $html .= '</div></div>';
            return $html;
        }

        return '';
    }
}