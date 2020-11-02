<?php

namespace App\Http\Controllers\Financial\Handlers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LevelsHandler extends Controller
{
    public $levels = [1,1,1,1,1,6];

    static public function CodeGeneration(int $level, int $itemsCount)
    {
        $Handler = new LevelsHandler();
        $digits = $Handler->levels[$level-1];
        $ChildCode = str_pad( ($itemsCount + 1), $digits, "0", STR_PAD_LEFT );

        return $ChildCode;
    }
}
