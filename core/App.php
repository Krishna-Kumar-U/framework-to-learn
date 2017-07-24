<?php

namespace App\Core;

use Exception;
use Symfony\Component\Dotenv\Dotenv;

class App
{
    /**
     * All registered keys.
     *
     * @var array
     */
    protected static $registry = [];

    protected $basePath;

    /**
     * Set the base path for the application.
     *
     * @param  string  $basePath
     * @return $this
     */
    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '\/');

        $this->bindPathsInContainer();

        return $this;
    }

      /**
     * Bind all of the application paths in the container.
     *
     * @return void
     */
    protected function bindPathsInContainer()
    {
        Self::bind('path.App', $this->path());
        Self::bind('path.root', $this->basePath());
        Self::bind('path.config', $this->configPath());
        Self::bind('path.public', $this->publicPath());
        Self::bind('path.views', $this->viewsPath());
    }

    /**
     * initiate the app
     * @param  string $basepath [path to root directory]
     */
    public function init($basePath)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }else{
            $this->setBasePath(realpath(__DIR__.'/../'));
        }

        (new Dotenv())->load($this->basePath().'/.env');

        $this->loadConfigs();
    }

    /**
     * Load the config values
     *
     * @return string
     */
    protected function loadConfigs()
    {
        $fileSystemIterator = new \FilesystemIterator($this->configPath());
        foreach ($fileSystemIterator as $fileInfo){
            Self::bind(pathinfo($fileInfo->getFilename(), PATHINFO_FILENAME), require $this->configPath().DIRECTORY_SEPARATOR.$fileInfo->getFilename());
        }
    }

    /**
     * Get the path to the application "app" directory.
     *
     * @return string
     */
    public function path()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'app';
    }

    /**
     * Get the base path of the Laravel installation.
     *
     * @return string
     */
    public function basePath()
    {
        return $this->basePath;
    }

    /**
     * Get the path to the application configuration files.
     *
     * @return string
     */
    public function configPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'config';
    }

    /**
     * Get the path to the public / web directory.
     *
     * @return string
     */
    public function publicPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'public';
    }

     /**
     * Get the path to the public / web directory.
     *
     * @return string
     */
    public function viewsPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'views';
    }


    /**
     * Bind a new key/value into the container.
     *
     * @param  string $key
     * @param  mixed  $value
     */
    public static function bind($key, $value)
    {
        static::$registry[$key] = $value;
    }

    /**
     * Retrieve a value from the registry.
     *
     * @param  string $key
     */
    public static function get($key)
    {
        if (! array_key_exists($key, static::$registry)) {
            throw new Exception("No {$key} is bound in the container.");
        }

        return static::$registry[$key];
    }
}
