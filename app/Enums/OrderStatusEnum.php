<?php

namespace App\Enums;

enum OrderStatusEnum: int
{
    case PENDING = 1;
    case ACCEPTED = 2;
    case REJECTED = 3;
    case FINISHED = 4;
}
