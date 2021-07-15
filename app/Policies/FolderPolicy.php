<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Folder;

class FolderPolicy
{
    /**
     * Create a new policy instance.
     * @param User $user
     * @param Folder $folder
     * @return bool
     */
    public function view(User $user, Folder $folder)
    {
        return $user->id === $folder->user_id;
    }
}
