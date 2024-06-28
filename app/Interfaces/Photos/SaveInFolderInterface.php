<?php

namespace App\Interfaces\Photos;

interface SaveInFolderInterface{

    public function saveIn($request,string $folderName);
}
