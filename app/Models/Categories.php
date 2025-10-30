<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categories extends Model
{

    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'categorytID';

    protected $fillable = [
        'color',
        'created_at',
        'icon',
        'user_id',
        'iconFontFamily',
        'iconFontPackage',
        'name',
        'title',
        'position',
        'isDefault',
    ];




    public function contacts()
    {
        return $this->hasMany(Contacts::class, 'categoryId');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'senderCategoryId');
    }
}
