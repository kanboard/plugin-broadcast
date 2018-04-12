<?php

namespace Kanboard\Plugin\Broadcast;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Security\Role;
use Kanboard\Core\Translator;
use Kanboard\Plugin\Broadcast\Helper\BroadcastHelper;

class Plugin extends Base
{
    public function initialize()
    {
        $this->template->hook->attach('template:layout:top', 'Broadcast:message');
        $this->template->hook->attach('template:config:sidebar', 'Broadcast:admin/sidebar');
        $this->hook->on('template:layout:css', array('template' => 'plugins/Broadcast/styles.css'));
        $this->helper->register('broadcast', new BroadcastHelper($this->container));

        $this->applicationAccessMap->add('BroadcastController', array('show', 'save', 'clear'), Role::APP_ADMIN);
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginName()
    {
        return 'Broadcast';
    }

    public function getPluginAuthor()
    {
        return 'Frédéric Guillot';
    }

    public function getPluginVersion()
    {
        return '1.0.1';
    }

    public function getPluginDescription()
    {
        return 'Broadcast messages to users via the application or by email.';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/kanboard/plugin-broadcast';
    }
}
