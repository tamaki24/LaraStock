<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'storage',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function itemMasters()
    {
        return $this->hasMany(ItemMaster::class, 'category_id');
    }
}
