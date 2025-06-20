<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leaves extends Model
{
    protected $fillable = ['user_id', 'start_date', 'end_date', 'reason', 'status'];

    use HasFactory;
}
