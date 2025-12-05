<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'calendar_id',
        'day_in',
        'day_out',
        'type',
        
    ];
    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
