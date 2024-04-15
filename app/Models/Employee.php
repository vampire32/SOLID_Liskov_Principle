<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable=[
        'firstname',
        'lastname',
        'department_id',
        "role",
        "salary"
    ];

    public function department():BelongsTo{
        return $this->belongsTo(department::class);
    }
}
