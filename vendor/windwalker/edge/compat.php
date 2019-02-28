<?php
/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2016 LYRASOFT. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

// Simple fix for Blade escape
if (!function_exists('e'))
{
	function e($string)
	{
		return htmlspecialchars((string) $string, ENT_COMPAT, 'UTF-8');
	}
}
