<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Link extends Model
{
    protected $fillable = ['url','short_url', 'short_url_hash'];

    public function visits(): HasMany
    {
        return $this->hasMany(LinkVisit::class, 'link_id');
    }    
}
