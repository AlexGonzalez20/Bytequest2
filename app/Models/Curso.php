<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    //
    public function lecciones()
    {
        return $this->hasMany(Leccion::class);
    }
}
