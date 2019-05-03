<?php


namespace App\System\Config\Loader;


use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

class YamlConfigLoader extends FileLoader
{

    /**
     * Loads a resource.
     *
     * @param mixed $resource The resource
     * @param string|null $type The resource type or null if unknown
     *
     * @return mixed
     * @throws \Exception If something went wrong
     */
    public function load($resource, $type = null)
    {
        return Yaml::parse(file_get_contents($resource));
    }

    /**
     * Returns whether this class supports the given resource.
     *
     * @param mixed $resource A resource
     * @param string|null $type The resource type or null if unknown
     *
     * @return bool True if this class supports the given resource, false otherwise
     */
    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'yaml' == pathinfo($resource, PATHINFO_EXTENSION);
    }
}