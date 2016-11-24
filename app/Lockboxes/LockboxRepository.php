<?php

namespace Vault\Lockboxes;


use Vault\Secrets\Secret;
use Vault\Secrets\SecretRepository;
use Vault\Uuid\UuidRepositoryTrait;
use Vault\Vaults\Vault;

class LockboxRepository
{
    use UuidRepositoryTrait;

    protected $getWith = ['secrets'];

    public function getPaginated($vault)
    {
        if( ! is_object($vault)) $vault = Vault::where('uuid', $vault)->firstOrFail();

        return Lockbox::where('vault_id', $vault->id)
            ->where('control', false)
            ->orderBy('name')->paginate();
    }

    //public function getListFor($id)
    //{
    //    return Lockbox::where('vault_id', $id)
    //        ->where('control', false)
    //        ->orderBy('name')->get();
    //}

    public function getListFor($user)
    {
        
        return Lockbox::with('vault')
            ->whereIn('vault_id', $user->vaults->pluck('id')->all())
            ->where('control', false)
            ->orderBy('name')->get();
    }

    public function create($formData, $control = false)
    {
        // Identify the Vault
        $vault = Vault::where('uuid', $formData['vault'])->firstOrFail();

        $lockbox = new Lockbox($formData);

        $lockbox->control = $control;

        $vault->lockboxes()->save($lockbox);

        if(isset($formData['secrets'])) (new SecretRepository)->update($lockbox, $formData['secrets']);

        return $lockbox;
    }

    public function update($formData)
    {
        $lockbox = $this->get($formData['uuid']);

        $lockbox->fill($formData);

        $lockbox->save();

        if(isset($formData['secrets'])) (new SecretRepository)->update($lockbox, $formData['secrets']);

        return $lockbox;
    }

    public function destroy($uuid)
    {
        $lockbox = $this->get($uuid);

        return $lockbox->delete();
    }


}