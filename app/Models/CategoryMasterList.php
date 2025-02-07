<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryMasterList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function masterlist()
    {
        return $this->hasMany(MasterList::class, 'category_master_list_id', 'id');
    }
}
