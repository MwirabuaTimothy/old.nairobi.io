<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo('\App\Models\Access\User\User');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function follower()
    {
        return $this->belongsTo('\App\Models\Access\User\User', 'follower');
    }
}
