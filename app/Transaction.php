<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function senderUser()
    {
        return $this->belongsTo('App\User', 'sender_id', 'id');
    }

    public function receiverUser()
    {
        return $this->belongsTo('App\User', 'receiver_id', 'id');
    }
}
