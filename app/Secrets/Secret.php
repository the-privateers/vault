<?php

namespace Vault\Secrets;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Privateers\Uuid\EloquentUuid;
use Vault\Lockboxes\Lockbox;

class Secret extends Model
{
    use EloquentUuid, PresentableTrait;

    protected $presenter = SecretPresenter::class;

    protected $fillable = ['key', 'value', 'linked_lockbox_id', 'paranoid', 'sort_order'];

    public function linkedLockbox()
    {
        return $this->belongsTo(Lockbox::class, 'linked_lockbox_id');
    }

    public function getKeyAttribute()
    {
        try {
            return unlock($this->attributes['key']);
        } catch (DecryptException $e) {
            //
        }
    }

    public function getValueAttribute()
    {
        try {
            return unlock($this->attributes['value']);
        } catch (DecryptException $e) {
            //
        }
    }

    public function setKeyAttribute($value)
    {
        $this->attributes['key'] = lock($value);
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = lock($value);
    }
}
