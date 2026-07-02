<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LinkVisit extends Model
{
    protected $fillable = [
        'link_id',
        'ip_address',
        'visited_at',
    ];

    public function shortURL(): BelongsTo
    {
        return $this->belongsTo(Link::class, 'link_id');
    }    
}
