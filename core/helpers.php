<?php
use App\Core\App;

if (! function_exists('view')) {
	/**
	 * Require a view.
	 *
	 * @param  string $name
	 * @param  array  $data
	 */
	function view($name, $data = [])
	{
	    extract($data);
	    $folderPath = str_replace('.', DIRECTORY_SEPARATOR, $name);
	    return require App::get('path.views')."/{$folderPath}.view.php";
	}
}

if (! function_exists('redirect')) {
	/**
	 * Redirect to a new page.
	 *
	 * @param  string $path
	 */
	function redirect($path)
	{
	    header("Location: /{$path}");
	}
}

if (! function_exists('dd')) {
	/**
	 * Die and dump.
	 *
	 * @param  string $path
	 */
	function dd($data)
	{
		echo "<pre>";
	    var_dump($data);
	    echo "</pre>";
	    die(1);
	}
}

if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return value($default);
        }

        return $value;
    }
}