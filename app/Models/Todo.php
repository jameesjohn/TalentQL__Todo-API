<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    /**
     * Check if the Todo has been completed.
     */
    public function isComplete()
    {
        return $this->completed_at !== null;
    }
}
