<?php

namespace App\Storage;

use stdClass;

class InMemoryStorage implements StorageInterface
{
    public function getConnection(): object
    {
        return new stdClass;
    }
}
