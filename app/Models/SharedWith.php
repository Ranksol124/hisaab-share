<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedWith extends Model
{
    use HasFactory;

    protected $table = 'sharedwith'; 
    protected $primaryKey = 'idsharedWith'; 

    public $incrementing = true; 
    protected $keyType = 'int'; 

    protected $fillable = [
        'uid',
        'username',
        'email',
        'imageUrl',
        'mobileNo',
        'receiverContactId',
        'sharedAt',
        'categoryId',
        'contactId',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'categoryId');
    }

    public function contact()
    {
        return $this->belongsTo(Contacts::class, 'contactId');
    }

    public function receiverContact()
    {
        return $this->belongsTo(Contacts::class, 'receiverContactId');
    }
}
