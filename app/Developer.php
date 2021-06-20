<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
  public $incrementing = false;
  protected $table = 'developers';
}
