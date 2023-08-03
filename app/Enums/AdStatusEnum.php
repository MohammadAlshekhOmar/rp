<?php

namespace App\Enums;

enum AdStatusEnum: int
{
    case PENDING = 1;
    case ACCEPTED = 2;
    case REJECTED = 3;
}
