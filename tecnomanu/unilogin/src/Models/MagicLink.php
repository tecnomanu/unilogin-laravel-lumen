<?php

namespace Tecnomanu\UniLogin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * MagicLink
 * 
 * Represents the MagicLink table in the database.
 */
class MagicLink extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'token', 'expireAt'];
    
    // Add other properties or relationships here as necessary.
}
