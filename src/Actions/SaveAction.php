<?php namespace DanHarper\InboxActions\Actions;

use DanHarper\InboxActions\Schemas\SaveAction as SaveActionSchema;

class SaveAction extends ConfirmAction {

    protected function getAction()
    {
        return $this->findOrMake($this->getEmailMessage(), 'action', SaveActionSchema::class);
    }

} 