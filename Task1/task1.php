<?php
function myArrowFunc (int $x)
{
    $text = str_repeat('<', $x) . str_repeat('>', $x);
    return $text;
}
echo myArrowFunc(5);