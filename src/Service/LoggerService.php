<?php

namespace Lb\CompanyLibrary\Service;

use Lb\CompanyLibrary\Service\ConfigurationService;

/**
 * Description of LoggerService
 * Ensures base error logging into file error.log in root folder
 *
 * @author Lubos Babocky <babocky@gmail.com>
 */
class LoggerService {

    const DefaultLogFile = 'error.log';

    /**
     * Saves exception message and trace into ./error.log
     * @param \Exception $ex The exception to be logged
     * @return void
     */
    public static function LogError(\Exception $ex): void {
        try {
            $errorLog = fopen(sprintf('%s/%s', rtrim(ConfigurationService::GetPluginRootPath(), static::DefaultLogFile)), 'a');
            fwrite($errorLog, sprintf("[%s] %s\n%s", date('Y-m-d H:i:s'), $ex->getMessage(), $ex->getTraceAsString()));
        } finally {
            fclose($errorLog);
        }
    }
}
