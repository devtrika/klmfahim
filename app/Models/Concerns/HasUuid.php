<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

/**
 * Public identifier for URLs: every record gets a random "uuid" on create,
 * and route-model binding resolves by it, so numeric ids never show up.
 */
trait HasUuid
{
    protected static function bootHasUuid(): void
    {
        static::creating(function ($model) {
            $model->uuid ??= (string) Str::uuid();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /** Legacy lookups: Model::findByUuid($uuid) or 404. */
    public static function findByUuid(?string $uuid): static
    {
        return static::where('uuid', $uuid)->firstOrFail();
    }
}
