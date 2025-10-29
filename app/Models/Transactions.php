<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $primaryKey = 'idtransactions';

    protected $fillable = [
        'date',
        'type',
        'send',
        'note',
        'timestamp',
        'transactionId',
        'userId',
        'senderId',
        'senderCategoryId',
        'senderContactId',
        'receiverUserId',
        'receiverCategoryId',
        'receiverContactId',
        'sharedUserId',
        'sharedCategoryId',
        'status',
        'typeOriginal',
        'receive',
    ];

    protected $casts = [
        'date' => 'date',
        'timestamp' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'senderId');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiverUserId');
    }
    public function contact()
    {
        return $this->belongsTo(Contacts::class, 'contact_id', 'idcontacts');
    }

    public function senderCategory()
    {
        return $this->belongsTo(Categories::class, 'senderCategoryId');
    }

    public function receiverCategory()
    {
        return $this->belongsTo(Categories::class, 'receiverCategoryId');
    }

    public function sharedUser()
    {
        return $this->belongsTo(User::class, 'sharedUserId');
    }

    public function sharedCategory()
    {
        return $this->belongsTo(Categories::class, 'sharedCategoryId');
    }
    public function senderContact()
    {
        return $this->belongsTo(Contacts::class, 'senderContactId', 'idcontacts');
    }

    public function receiverUser()
    {
        return $this->belongsTo(User::class, 'receiverUserId', 'id');
    }

    public function receiverContact()
    {
        return $this->belongsTo(Contacts::class, 'receiverContactId', 'idcontacts');
    }
}
