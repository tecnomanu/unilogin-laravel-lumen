<?php

namespace Tecnomanu\UniLogin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Session
 * 
 * Represents the Session table in the database.
 */
class Session extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 
        'token', 
        'session_id', 
        'status'
    ];
    
    // Add other properties or relationships here as necessary.
}
