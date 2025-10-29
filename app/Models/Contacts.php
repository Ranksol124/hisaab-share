<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;

    protected $table = 'contacts';
    protected $primaryKey = 'idcontacts';

    protected $fillable = [
        'name',
        'amount',
        'mobileNo',
        'email',
        'address',
        'isSharedView',
        'sharedUserId',
        'sharedCategoryId',
        'originalContactId',
        'category',
        'allowReceiverToAddTransactions',
        'sharedBy_name',
        'sharedBy_email',
        'sharedBy_mobileNo',
        'sharedBy_imageUrl',
    ];

    protected $casts = [
        'isSharedView' => 'boolean',
        'allowReceiverToAddTransactions' => 'boolean',
    ];

    // Relationships
    public function sharedUser()
    {
        return $this->belongsTo(User::class, 'sharedUserId');
    }

    public function sharedCategory()
    {
        return $this->belongsTo(Categories::class, 'sharedCategoryId');
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'senderContactId');
    }
}
