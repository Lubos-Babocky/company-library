<?php

namespace Lb\CompanyLibrary\Service;

use Lb\CompanyLibrary\Exception\MissingConfigurationException;

/**
 * Description of ConfigurationService
 * Singleton which is loading configuration from ./configuration.ini
 * Contains functions for retrieving configuration data, such as getConfigArray
 * for the entire configuration or getParamValue to get a specific value.
 *
 * @author Lubos Babocky <babocky@gmail.com>
 */
class ConfigurationService {

    const PATH_TO_CONFIG_FILE = '../../configuration.ini';

    private array $config;
    private static ?ConfigurationService $instance = null;

    private function __construct() {
        $this->initConfig();
    }

    /**
     * Checks if configuration file is availabe and loads it into $config
     * @return void
     * @throws \Exception when ./configuration.ini doesn't exist or is not readable
     */
    private function initConfig(): void {
        if (!file_exists($configFilePath = realpath(sprintf('%s/%s', __DIR__, static::PATH_TO_CONFIG_FILE)))) {
            throw new \Exception(sprintf('File [%s] not found!', $configFilePath));
        }
        if (!is_readable($configFilePath)) {
            throw new \Exception(sprintf('File [%s] is not readable!', $configFilePath));
        }
        $this->config = parse_ini_file($configFilePath);
    }

    private function __clone() {
        throw new \Exception("Cannot clone a singleton.");
    }

    public final function __sleep() {
        throw new \Exception("Cannot serialize a singleton.");
    }

    public final function __wakeup() {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function GetInstance(): ConfigurationService {
        if (self::$instance === null) {
            self::$instance = new ConfigurationService();
        }
        return self::$instance;
    }

    /**
     * @return array Contains whole configuration from <b>./configuration.ini</b>
     */
    public function getConfigArray(): array {
        return $this->config;
    }

    /**
     * @param string $paramName Parameter name, e.g API_URL
     * @return string 
     * @throws MissingConfigurationException when the parameter name does not exist or is empty
     */
    public function getParamValue(string $paramName): string {
        if (!array_key_exists($paramName, $this->config) || empty($this->config[$paramName])) {
            throw new MissingConfigurationException(sprintf('Param name [%s] not configured', $paramName));
        }
        return $this->config[$paramName];
    }

    /**
     * @return string path to library root folder
     */
    public static function GetPluginRootPath(): string {
        return realpath(sprintf('%s/../../', rtrim(__DIR__)));
    }
}
