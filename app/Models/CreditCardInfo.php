<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCardInfo extends Model
{
    use HasFactory;

    protected $table = 'credit_card_info'; // Define the table name as 'credit_card_info'

    protected $fillable = [
        'user_id',
        'card_number',
        'expiration_month',
        'expiration_year',
        'last_four_digits',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
