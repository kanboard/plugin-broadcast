<?php

namespace Kanboard\Plugin\Broadcast\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Plugin\Broadcast\Model\BroadcastMessageModel;
use Kanboard\Plugin\Broadcast\Validator\MessageValidator;

class BroadcastController extends BaseController
{
    public function show(array $values = [], array $errors = [], array $email = [], array $emailErrors = [])
    {
        $model = BroadcastMessageModel::getInstance($this->container);

        if (empty($values)) {
            $values = $model->getMessage();
        }

        $this->response->html($this->helper->layout->config('Broadcast:admin/message', [
            'title' => t('Settings').' &gt; '.t('Broadcast Message'),
            'values' => $values,
            'errors' => $errors,
            'email' => $email,
            'emailErrors' => $emailErrors,
        ]));
    }

    public function save()
    {
        $values = $this->request->getValues();
        list($valid, $errors) = MessageValidator::getInstance($this->container)->validateMessage($values);

        if ($valid) {
            BroadcastMessageModel::getInstance($this->container)->save($values['message'], $values['expire_at']);

            foreach ($this->userModel->getActiveUsersList() as $userId => $username) {
                $this->userMetadataModel->remove($userId, 'ignore_broadcast_message');
            }

            $this->response->redirect($this->helper->url->to('BroadcastController', 'show', ['plugin' => 'Broadcast']));
            return;
        }

        $this->show($values, $errors);
    }

    public function clear()
    {
        BroadcastMessageModel::getInstance($this->container)->clear();

        foreach ($this->userModel->getActiveUsersList() as $userId => $username) {
            $this->userMetadataModel->remove($userId, 'ignore_broadcast_message');
        }

        $this->response->redirect($this->helper->url->to('BroadcastController', 'show', ['plugin' => 'Broadcast']));
    }

    public function send()
    {
        $values = $this->request->getValues();
        list($valid, $errors) = MessageValidator::getInstance($this->container)->validateEmail($values);

        if ($valid) {
            $body = $this->template->render('Broadcast:email', ['body' => $values['message']]);
            $users = BroadcastMessageModel::getInstance($this->container)->getUserEmails();

            foreach ($users as $user) {
                $this->emailClient->send($user['email'], $user['name'] ?: $user['username'], $values['subject'], $body);
            }
        }

        $this->show([], [], $values, $errors);
    }

    public function dismiss()
    {
        $this->userMetadataModel->save($this->userSession->getId(), array(
            'ignore_broadcast_message' => 1,
        ));

        $this->response->redirect($this->helper->url->to('DashboardController', 'show'));
    }
}
