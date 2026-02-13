<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductExport extends Model
{
    use HasFactory;
	protected $guarded = [];

	protected $fillable = ['file_path'];
}
