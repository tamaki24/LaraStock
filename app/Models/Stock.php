<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stocks';

    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'master_id',
        'stock',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'date:Y-m-d'
    ];

    protected $dates = [
        'deadline',
    ];

    public function itemMaster()
    {
        return $this->belongsTo(ItemMaster::class, 'master_id');
    }
}
