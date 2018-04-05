<?php

namespace PlanIt;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'type', 'start_time', 'end_time', 'start_date', 'end_date', 'location',
    ];

    public function user()
    {
      return $this->hasMany('PlanIt\User');
    }

    public function notification()
    {
      return $this->hasMany('PlanIt\Notification');
    }
}
