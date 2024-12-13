<?php

namespace App\Enums;

enum PurchaseStatusEnum: int
{
    case EXPIRED = -2;
    case REJECTED = -1;
    case PENDING = 0;
    case ONLINE = 1;

}





