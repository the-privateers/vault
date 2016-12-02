<?php

namespace Vault\Vaults;

use Illuminate\Database\Eloquent\Model;
use Vault\Files\File;
use Vault\Lockboxes\Lockbox;
use Vault\Users\User;
use Vault\Uuid\HasUuid;

class Vault extends Model
{
    use HasUuid;

    protected $fillable = ['name', 'description', 'use_passkey', 'passkey_reminder'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('read_only');
    }

    public function lockboxes()
    {
        return $this->hasMany(Lockbox::class);
    }

    public function files()
    {
        return $this->hasManyThrough(File::class, Lockbox::class);
    }
}
