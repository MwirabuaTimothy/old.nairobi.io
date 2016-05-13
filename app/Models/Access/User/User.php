<?php

namespace App\Models\Access\User;

use App\Models\Access\User\Traits\Attribute\UserAttribute;
use App\Models\Access\User\Traits\Relationship\UserRelationship;
use App\Models\Access\User\Traits\UserAccess;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App\Models\Access\User
 */
class User extends Authenticatable implements SluggableInterface {

	use SoftDeletes, UserAccess, UserAttribute, UserRelationship, SluggableTrait;

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */

	protected $sluggable = [
		// 'first_name' => 'name',
		//       'last_name' => 'name',
		'build_from' => ['first_name', 'last_name'],
		'save_to' => 'username',
	];
	protected $guarded = ['id'];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * @var array
	 */
	protected $dates = ['deleted_at'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
	 */
	public function languages() {
		return $this->belongsToMany('\App\Language', 'user_languages');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function tours() {
		return $this->hasMany('\App\Tour');
	}
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function messages() {
		return $this->hasMany('\App\Message');
	}
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\hasMany
	 */
	public function reviews() {
		return $this->hasMany('\App\Review');
	}
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\hasOne
	 */
	public function apikey() {
		return $this->hasOne('Chrisbjr\ApiGuard\Models\ApiKey');
	}

}
