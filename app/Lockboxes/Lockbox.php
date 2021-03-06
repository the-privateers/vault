<?php

namespace Vault\Lockboxes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Privateers\Uuid\EloquentUuid;
use Vault\Files\File;
use Vault\Secrets\Secret;
use Vault\Users\UserRepository;
use Vault\Vaults\Vault;

class Lockbox extends Model
{
    use EloquentUuid;

    protected $fillable = ['name', 'description', 'notes'];

    public function vault()
    {
        return $this->belongsTo(Vault::class);
    }

    public function secrets()
    {
        return $this->hasMany(Secret::class)->orderBy('sort_order');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function canBeEditedBy($user)
    {
        if ( ! is_object($user)) $user = (new UserRepository)->get($user);

        $relationship = DB::table('user_vault')
            ->where('user_id', $user->id)
            ->where('vault_id', $this->vault_id)
            ->first();

        if( ! empty($relationship))
        {
            return ! ($relationship->read_only);
        }

        return false;

    }
}
