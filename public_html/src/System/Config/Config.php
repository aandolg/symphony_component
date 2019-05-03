<?php


namespace App\System\Config;


use App\System\Config\Loader\YamlConfigLoader;
use Symfony\Component\Config\FileLocator;

class Config implements IConfig
{
    private $config = [];
    private $loader;
    private $locator;

    public function __construct($dir)
    {
        $directories = [
            BASEPATH . '/' . $dir
        ];

        $this->setLocator($directories);
        $this->setLoader();
    }

    public function addConfig($file)
    {
        $configValues = $this->loader->load($this->locator->locate($file));
        if ($configValues) {
            foreach ($configValues as $key => $configValue) {
                $this->config[$key] = $configValue;
            }
        }
    }

    //key.value
    public function get($keyValue)
    {
        list($key, $value) = explode('.', $keyValue);
        if ($key && isset($this->config[$key])) {
            if ($value && isset($this->config[$key][$value])) {
                return $this->config[$key][$value];
            }
            return $this->config[$key];
        }
        return null;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    public function setLocator($dir)
    {
        $this->locator = new FileLocator($dir);
    }

    public function setLoader()
    {
        $this->loader = new YamlConfigLoader($this->locator);
    }
}