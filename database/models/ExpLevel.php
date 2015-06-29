<?php
namespace Models;

use Illuminate\Database\Eloquent\Model;

class ExpLevel extends Model
{
    protected $table = 'exp_level';

    protected $primaryKey = 'exp_level_id';

    protected $fillable = ['level', 'experience'];
}
