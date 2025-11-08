<?php

namespace App\Storage;


class StorageFactory
{
    public function make(StorageType $type): StorageInterface
    {
        switch ($type) {
            case StorageType::IN_MEMORY:
                return new InMemoryStorage;
                break;

            case StorageType::MARIADB:
                return new MariadbStorage;
                break;

            default:
                return new MariadbStorage;
                break;
        }
    }
}
