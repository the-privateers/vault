<?php

namespace Vault\Uuid;

use Webpatser\Uuid\Uuid;


/**
 * Class HasUuid
 * @package Elevate\Uuid
 */
trait HasUuid
{
    /**
     *
     */
    protected static function bootHasUuid()
    {
        /**
         * Attach to the 'creating' Model Event to provide a UUID
         * for the `uuid` field
         */
        static::creating(function ($model) {

            $columnName = static::getUuidColumn();

            $model->$columnName = Uuid::generate(4);
        });
    }

    /**
     * @return mixed
     */
    public function getUuidAttribute()
    {
        $columnName = static::getUuidColumn();

        return $this->attributes[$columnName];
    }

    protected static function getUuidColumn()
    {
        if(isset(static::$uuidColumn))
        {
            return static::$uuidColumn;
        }

        return 'uuid';
    }
}