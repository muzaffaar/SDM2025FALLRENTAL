<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_id', 'student_id', 'status', 'message'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }
}
