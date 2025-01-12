<?php

namespace App\Helpers;

class MessageHelper
{
    public static function flashSuccess($message)
    {
        flash()
            ->option('position', 'bottom-right')
            ->title('Sucesso')
            ->success($message);
    }

    public static function flashError($message)
    {
        flash()
            ->option('position', 'bottom-right')
            ->title('Erro')
            ->error($message);
    }

    public static function flashWarning($message)
    {
        flash()
            ->option('position', 'bottom-right')
            ->title('Aviso')
            ->warning($message);
    }

    public static function flashInfo($message)
    {
        flash()
            ->option('position', 'bottom-right')
            ->title('Info')
            ->info($message);
    }
}
