<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemMaster extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'item_master';

    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'place',
        'category_id',
        'remarks',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'master_id');
    }
}
