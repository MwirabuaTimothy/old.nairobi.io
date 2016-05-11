<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function users() {
        return $this->belongsTo('\App\Models\Access\User\User');
    }
}
