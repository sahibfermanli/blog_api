<?php

namespace App\Models;

use App\Traits\ActionBy;
use App\Traits\CreatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiToken extends Model
{
    use SoftDeletes, ActionBy, CreatedBy;
}
