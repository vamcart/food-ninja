<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Link extends Model
{
    protected $fillable = ['url','short_url', 'short_url_hash'];

    protected static function booted() {
        static::creating(function($model) {
            $model->user_id = Auth::user()->id;
        });
    }

    public function visits(): HasMany
    {
        return $this->hasMany(LinkVisit::class, 'link_id');
    }    
}
