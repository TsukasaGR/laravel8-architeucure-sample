<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Seeder以外でデータが挿入されるケースを想定していないため、あえてfillable, guardedともに記載しない
}
