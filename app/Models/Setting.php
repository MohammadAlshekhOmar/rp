<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;

class Setting extends Model
{
    use Translatable;
    use HasFactory;
    use CreatedAtTrait, UpdatedAtTrait;

    public $translatedAttributes = ['value'];
    protected $hidden = ['translations'];

    protected $table = 'settings';
    protected $fillable = ['type'];
}
