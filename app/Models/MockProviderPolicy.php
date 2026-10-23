<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockProviderPolicy extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'sum_insured' => 'integer',
        'premium' => 'decimal:2',
    ];
}
