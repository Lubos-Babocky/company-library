<?php

namespace Lb\CompanyLibrary;

use Exception,
    Lb\CompanyLibrary\Exception\MissingConfigurationException,
    Lb\CompanyLibrary\Exception\InvalidIcoException,
    Lb\CompanyLibrary\Service\LoggerService,
    Lb\CompanyLibrary\Validator\IcoValidator,
    Lb\CompanyLibrary\Request\CurlRequest,
    Lb\CompanyLibrary\Renderer\CompanyDataRenderer;

/**
 * Description of CompanyDataLoader
 * Main entry for library, responsible for validating ICO and fetching company data from the API.
 * @see README.md
 * @author Lubos Babocky <babocky@gmail.com>
 */
class CompanyDataLoader {

    protected IcoValidator $icoValidator;
    protected CurlRequest $curlRequest;

    public function __construct() {
        $this->icoValidator = new IcoValidator();
        $this->curlRequest = new CurlRequest();
    }

    /**
     * This function validates received ICO and retrieves data from API
     * @param string $ico The company identification number (ICO), which must be numeric and contain exactly 8 digits.
     * @return CompanyDataRenderer Returns an object used for rendering company data.
     */
    public function findCompany(string $ico): CompanyDataRenderer {
        try {
            $this->icoValidator->validateICO($ico);
            $companyData = $this->curlRequest->fetchCompanyData($ico);
            return new CompanyDataRenderer($companyData);
        } catch (MissingConfigurationException $configException) {
            echo sprintf('Execution failed with message: %s! Check you config file..', $configException->getMessage());
        } catch (InvalidIcoException $icoException) {
            echo sprintf('Input IČO does not meet requirements, reason: %s', $icoException->getMessage());
        } catch (Exception $ex) {
            LoggerService::LogError($ex);
            echo sprintf('oops, something went wrong, check log file for more information');
        }
    }
}
