<?php 

namespace App\Storage;

enum StorageType {
    case IN_MEMORY;
    case MARIADB;
    case POSTGRES;
    case JSON_FILE;
}