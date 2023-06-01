<?php

namespace Tecnomanu\UniLogin\Repositories;

use Tecnomanu\UniLogin\Contracts\Repositories\SessionRepositoryContract;
use Illuminate\Support\Facades\DB;

/**
 * SessionRepository
 * 
 * Handles database operations for Session.
 */
class SessionRepository implements SessionRepositoryContract
{
    protected $table = 'unilogin_sessions';
    /**
     * Create a new Session.
     *
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $data["token"] = hash('sha256', $data['token']);
        DB::table($this->table)->insert($data);
        return $data;
    }

    /**
     * Find a Session by its token.
     *
     * @param string $token
     * @return array|null
     */
    public function findByToken(string $sessionId, string $token): ?array
    {
        return DB::table($this->table)
                ->where('token', hash('sha256', $token))
                ->where('session_id', $sessionId)
                ->first();
    }

    /**
     * Update the status of a Session.
     *
     * @param string $token
     * @param string $status
     * @return void
     */
    public function updateStatus(string $token, string $status): void
    {
        DB::table($this->table)
            ->where('token', hash('sha256', $token))
            ->update(['status' => $status]);
    }

    /**
     * Remove a Session.
     *
     * @param string $token
     * @param string $status
     * @return void
     */
    public function remove(string $sessionId, string $token): void
    {
        DB::table($this->table)
            ->where('token', hash('sha256', $token))
            ->where('session_id', $sessionId)
            ->delete();
    }
}
