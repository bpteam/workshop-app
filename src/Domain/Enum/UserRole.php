<?php

namespace AppName\Domain\Enum;

enum UserRole: string
{
    case SUPPORT = 'support';
    case MODERATOR = 'moderator';
    case MARKETING = 'marketing';
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case TRANSLATOR = 'translator';
}