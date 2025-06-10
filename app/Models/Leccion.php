<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leccion extends Model
{
    //
    public function curso() {
    return $this->belongsTo(Curso::class);
}

}
