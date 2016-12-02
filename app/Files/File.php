<?php

namespace Vault\Files;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Vault\Lockboxes\Lockbox;
use Vault\Uuid\HasUuid;

class File extends Model
{
    use HasUuid, PresentableTrait;

    protected $presenter = FilePresenter::class;

    public function lockbox()
    {
        return $this->belongsTo(Lockbox::class);
    }
}
