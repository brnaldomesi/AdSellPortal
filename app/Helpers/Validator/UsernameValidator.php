<?php
/**
 * LaraClassified - Geo Classified Ads Software
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Helpers\Validator;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\Router;
use Illuminate\Config\Repository;

class UsernameValidator
{
    /**
     * The router instance used to check the username against application routes.
     *
     * @var \Illuminate\Routing\Router
     */
    private $router;

    /**
     * The filesystem class used to retrieve public files and directories.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $files;

    /**
     * The config repository used to retrieve reserved usernames.
     *
     * @var \Illuminate\Config\Repository
     */
    private $config;

    /**
     * Create a new allowed username validator instance.
     *
     * @param \Illuminate\Routing\Router $router
     * @param \Illuminate\Filesystem\Filesystem $files
     * @param \Illuminate\Config\Repository $config
     */
    public function __construct(Router $router, Filesystem $files, Repository $config)
    {
        $this->config = $config;
        $this->router = $router;
        $this->files = $files;
    }

    /**
     * Validate whether the given username is valid.
     *
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 * @param $validator
	 * @return bool
	 */
    public function isValid($attribute, $value, $parameters, $validator)
    {
        $value = trim(strtolower($value));

        if ($this->hasInvalidCharacter($value)) {
            return false;
        }

        return true;
    }

    /**
     * Validate whether the given username is allowed.
     *
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 * @param $validator
	 * @return bool
	 */
    public function isAllowed($attribute, $value, $parameters, $validator)
    {
        $value = trim(strtolower($value));

        if ($this->isReservedUsername($value)) {
            return false;
        }

        if ($this->matchesRoute($value)) {
            return false;
        }

        if ($this->matchesPublicFileOrDirectory($value)) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the given username contains a non-alphanumeric character
	 * or only numeric characters (to prevent a phone number field).
     *
     * @param $value
     * @return bool
     */
    private function hasInvalidCharacter($value)
    {
		if (!ctype_alnum($value) || is_numeric($value)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the given username is in the reserved usernames list.
     *
     * @param  string  $value
     * @return bool
     */
    private function isReservedUsername($value)
    {
        return in_array($value, $this->config->get('larapen.core.reservedUsernames'));
    }

    /**
     * Determine whether the given username matches an application route.
     *
     * @param  string  $value
     * @return bool
     */
    private function matchesRoute($value)
    {
        foreach ($this->router->getRoutes() as $route) {
            if (strtolower($route->uri) === $value) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the given username matches a public file or directory.
     *
     * @param  string  $value
     * @return bool
     */
    private function matchesPublicFileOrDirectory($value)
    {
        foreach ($this->files->glob(public_path() . '/*') as $path) {
            if (strtolower(basename($path)) === $value) {
                return true;
            }
        }

        return false;
    }
}
