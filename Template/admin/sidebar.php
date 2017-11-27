<li <?= $this->app->checkMenuSelection('BroadcastController', 'show', 'Broadcast') ?>>
    <?= $this->url->link(t('Broadcast Message'), 'BroadcastController', 'show', array('plugin' => 'Broadcast')) ?>
</li>