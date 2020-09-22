<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisaConfiguration extends Model {
    protected $guarded = ['id'];
    public function getDateFormat() {
        return 'Y-m-d H:i:s.v';
    }
}
