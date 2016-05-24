<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Star extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function blog()
    {
        return $this->belongsTo('\App\Blog');
    }
}
