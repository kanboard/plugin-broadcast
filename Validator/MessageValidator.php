<?php

namespace Kanboard\Plugin\Broadcast\Validator;

use Kanboard\Validator\BaseValidator;
use SimpleValidator\Validator;
use SimpleValidator\Validators;

class MessageValidator extends BaseValidator
{
    public function validateMessage(array $values)
    {
        $v = new Validator($values, array(
            new Validators\Required('message', t('This field is required')),
            new Validators\Required('expire_at', t('This field is required')),
        ));

        return array(
            $v->execute(),
            $v->getErrors(),
        );
    }

    public function validateEmail(array $values)
    {
        $v = new Validator($values, array(
            new Validators\Required('subject', t('This field is required')),
            new Validators\Required('message', t('This field is required')),
        ));

        return array(
            $v->execute(),
            $v->getErrors(),
        );
    }
}
