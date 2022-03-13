<?php

namespace App\Exception;

use App\View\Renderable;

class ViewNotFoundException implements Renderable
{
    public function render()
    {

    }
}