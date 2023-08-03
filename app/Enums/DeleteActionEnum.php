<?php

namespace App\Enums;

enum DeleteActionEnum: int
{
    case SOFT_DELETE = 1;
    case RESTORE_DELETE = 2;
    case FORCE_DELETE = 3;
}
