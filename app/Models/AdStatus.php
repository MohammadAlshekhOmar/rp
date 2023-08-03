<?php

namespace App\Models;

use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdStatus extends Model
{
    use Translatable;
    use HasFactory;
    use CreatedAtTrait, UpdatedAtTrait;

    public $translatedAttributes = ['name'];
    protected $hidden = ['translations'];
    protected $table = 'ad_statuses';

    protected $fillable = [];
}
