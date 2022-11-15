<?php

declare(strict_types=1);

namespace Eskimo;

class HomePage
{
    public  function handler($param)
    {
        echo $param;
        echo "hi world";
    }
}