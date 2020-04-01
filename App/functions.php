<?php

use App\Debug;

function dd($x)
{
	echo "<p style='background: #f7f7f9;border: 1px solid #e1e1e8;padding: 8px;border-radius: 4px;-moz-border-radius: 4px;-webkit-border radius: 4px;display: block;font-size: 12.05px;white-space: pre-wrap;word-wrap: break-word;color: #d4892d;font-family: Menlo,Monaco,Consolas,'Courier New',monospace;'>" . debug_backtrace()[0]["file"] . " on line " . debug_backtrace()[0]["line"]."</p>";
	array_map(function($x) { Debug::var_dump($x); }, func_get_args()); die;
}
