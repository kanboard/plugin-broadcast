<div class="page-header">
    <h2><?= t('Broadcast Message') ?></h2>
</div>
<form method="post" action="<?= $this->url->href('BroadcastController', 'save', array('plugin' => 'Broadcast')) ?>" autocomplete="off">
    <?= $this->form->csrf() ?>

    <?= $this->form->textEditor('message', $values, $errors) ?>
    <?= $this->form->date(t('Expiration Date'), 'expire_at', $values, $errors) ?>

    <div class="form-actions">
        <a href="<?= $this->url->href('BroadcastController', 'clear', array('plugin' => 'Broadcast')) ?>" class="btn btn-red"><?= t('Clear message') ?></a>
        <button type="submit" class="btn btn-blue"><?= t('Publish') ?></button>
    </div>
</form>
<br>
<div class="page-header">
    <h2><?= t('Broadcast Message by Email') ?></h2>
</div>
<form method="post" action="<?= $this->url->href('BroadcastController', 'send', array('plugin' => 'Broadcast')) ?>" autocomplete="off">
    <?= $this->form->csrf() ?>

    <?= $this->form->label(t('Subject'), 'subject') ?>
    <?= $this->form->text('subject', $email, $emailErrors) ?>

    <?= $this->form->textEditor('message', $email, $emailErrors) ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-blue"><?= t('Send to everyone') ?></button>
    </div>
</form>
