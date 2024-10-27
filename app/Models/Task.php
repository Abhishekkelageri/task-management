<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'descrption',
        'status',
        'assigned_to',
        'created_by,',
        'priority',
    ];

     public function assignedUser()
     {
         return $this->belongsTo(User::class, 'assigned_to');
     }
 
     public function creator()
     {
         return $this->belongsTo(User::class, 'created_by');
     }
}
