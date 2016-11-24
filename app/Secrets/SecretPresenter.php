<?php

namespace Vault\Secrets;


use Laracasts\Presenter\Presenter;

class SecretPresenter extends Presenter
{

    public function value()
    {
        if( ! $this->entity->paranoid) return $this->entity->value;

        $characters = (strlen($this->entity->value) > 16) ? 16 : strlen($this->entity->value);

        return str_repeat('&bull;', $characters);
    }
}