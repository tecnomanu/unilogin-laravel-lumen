<?php

namespace Tecnomanu\UniLogin\Repositories;

use Tecnomanu\UniLogin\Contracts\Repositories\MagicLinkRepositoryContract;
use Illuminate\Support\Facades\DB;
/**
 * MagicLinkRepository
 * 
 * Handles database operations for MagicLink.
 */
class MagicLinkRepository implements MagicLinkRepositoryContract
{
    protected $table = 'unilogin_magic_links';
    /**
     * Create a new MagicLink.
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
     * Find a MagicLink by its token.
     *
     * @param string $token
     * @return array|null
     */
    public function findByToken(string $token): ?array
    {
        return DB::table($this->table)
                ->where('token', hash('sha256', $token))
                ->first();
    }

    /**
     * Update the status of a MagicLink.
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
     * Remove a MagicLink.
     *
     * @param string $token
     * @param string $status
     * @return void
     */
    public function remove(string $token): void
    {
        DB::table($this->table)
                ->where('token', hash('sha256', $token))
                ->delete();
    }
}
