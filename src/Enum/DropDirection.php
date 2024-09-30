<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Enum;

enum DropDirection: string
{
    case Down = 'dropdown';
    case Up = 'dropup';
    case Left = 'dropleft';
    case Right = 'dropright';
    case DownCenter = 'dropdown-center';
    case UpCenter = 'dropup-center dropup';
    case End = 'dropend';
    case Start = 'dropstart';
}
