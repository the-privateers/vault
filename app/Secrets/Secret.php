<?php

namespace Vault\Secrets;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Vault\Uuid\HasUuid;

class Secret extends Model
{
    use HasUuid, PresentableTrait;

    protected $presenter = SecretPresenter::class;

    protected $fillable = ['key', 'value', 'paranoid'];

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