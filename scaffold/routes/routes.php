<?php

namespace Scaffold\Routes;

public class Routes {

	public static function get($path, $route) {
		Router::extract($route);
		return new $Class();
	}
}