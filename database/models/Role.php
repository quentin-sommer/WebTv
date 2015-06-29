<?php
namespace Models;


use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'role';

	protected $primaryKey = 'role_id';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['title'];

	public function users()
	{
		return $this->belongsToMany('\Models\User');
	}
}
