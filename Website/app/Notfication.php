<?php

namespace PlanIt;

use Illuminate\Database\Eloquent\Model;

class Notfication extends Model
{
    protected $fillable = [
      'body'
    ];

    public function events()
    {
      return $this->belongsTo('PlanIt\Event');
    }

    public function user()
    {
      return $this->belongsTo('PlanIt\User');
    }
}
