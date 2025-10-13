<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'landlord_id', 'price', 'location', 'status', 'image_path'
    ];

    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    public function rentalRequests()
    {
        return $this->hasMany(RentalRequest::class);
    }
}
