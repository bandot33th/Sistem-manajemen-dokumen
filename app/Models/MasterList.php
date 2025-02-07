<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterList extends Model
{
    use HasFactory;

    protected $fillable = [
        'drawing_number',
        'address_of_drawing',
        'name_of_machine',
        'drawing_file_contents',
        'remarks',
        'slug',
        'category_master_list_id'
    ];

    public function category()
    {
        return $this->belongsTo(CategoryMasterList::class, 'category_master_list_id', 'id');
    }
}
