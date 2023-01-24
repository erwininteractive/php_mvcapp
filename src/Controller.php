<?php

declare(strict_types = 1);

namespace Framework;

use Framework\View;

abstract class Controller
{
	public function view(string $view, array $data = []): View
	{
		return new View($view, $data);
	}
}