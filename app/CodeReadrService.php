<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodeReadrService extends Model
{

    protected $table = 'codereadr_services';

    protected $fillable = [
        'service_id', 'database_id', 'event_id'
    ];

    public function ucEvent()
    {
        return $this->belongsTo(UcEvent::class, 'event_id');
    }
}
