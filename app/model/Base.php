<?php

namespace app\model;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shopwwi\WebmanAuth\Facade\Str;
use support\Model;
use Symfony\Component\Uid\Ulid;

class Base extends Model
{

    use SoftDeletes;


    protected array $hidden = [
        'sort',
        'deleted_at',
    ];


    protected array $guarded = [];


    protected static function boot(): void
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uid = 'LC' . Ulid::generate();
        });
    }


    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value ? date('Y-m-d H:i:s', strtotime($value)) : null,
        );
    }


    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value ? date('Y-m-d H:i:s', strtotime($value)) : null,
        );
    }

}