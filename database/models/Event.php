<?php
namespace Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';

    protected $primaryKey = 'event_id';

    protected $fillable = ['event_id','title', 'start', 'end', 'allDay'];
}
