<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait UuidModel
{
    /**
     * Boot function from Laravel.
     */
    protected static function boot(): void
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
        
        static::replicating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }
    
    /**
     * Get a user by its UUID.
     *
     * @param $uuid
     *
     * @return Model|null
     */
    protected static function findByUuid($uuid): ?Model
    {
        return static::where('uuid', $uuid)->first();
    }
    
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}