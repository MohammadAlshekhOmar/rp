<?php

namespace App\Models;

use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use Translatable;
    use HasFactory;
    use CreatedAtTrait, UpdatedAtTrait;
    use SoftDeletes;

    public $translatedAttributes = ['name'];
    protected $hidden = ['translations'];
    protected $table = 'regions';
    protected $fillable = ['name'];
}
