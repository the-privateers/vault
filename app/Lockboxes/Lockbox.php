<?php

namespace Vault\Lockboxes;

use Illuminate\Database\Eloquent\Model;
use Vault\Secrets\Secret;
use Vault\Uuid\HasUuid;
use Vault\Vaults\Vault;

class Lockbox extends Model
{
    use HasUuid;

    protected $fillable = ['name', 'description'];

    public function vault()
    {
        return $this->belongsTo(Vault::class);
    }

    public function secrets()
    {
        return $this->hasMany(Secret::class);
    }
}
