<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Facade as Avatar;
use RahulHaque\Filepond\Facades\Filepond;

class AvatarService
{
    public static function make(): AvatarService
    {
        return new self();
    }

    public function avatarFromName(string $name): string
    {
        $avatar = 'avatar_'.strtotime('now').'.png';

        Avatar::create($name)->save(Storage::disk('public')->path(User::AVATAR_STORAGE_PATH.'/'.$avatar));

        return $avatar;
    }

    public function avatarFromFilepond(string $fileHash): string
    {
        $avatar = 'avatar_'.strtotime('now');

        $info = Filepond::field($fileHash)->moveTo(User::AVATAR_STORAGE_PATH.'/'.$avatar);

        return $info['basename'];
    }

    public function getAvatarPath(string $name)
    {
        return Storage::disk('public')->url(User::AVATAR_STORAGE_PATH.'/'.$name);
    }
}
