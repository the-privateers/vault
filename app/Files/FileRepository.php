<?php

namespace Vault\Files;


use Illuminate\Support\Facades\Storage;
use Vault\Uuid\UuidRepositoryTrait;

class FileRepository
{
    use UuidRepositoryTrait;

    public function destroy($formData)
    {
        $file = $this->get($formData['uuid']);

        // remove the file from filesystem
        Storage::delete($file->file_name);

        // then delete
        $file->delete();

        return;
    }
}