<?php

namespace AppName\Domain\Enum;

enum MessageType: string
{
    case NOTICE = 'notice';
    case ALARM = 'alarm';
}