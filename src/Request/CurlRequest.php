<?php

namespace Lb\CompanyLibrary\Request;

use Exception,
    Lb\CompanyLibrary\Service\ConfigurationService;

/**
 * Description of CurlRequest
 * This class manages communication with remote api via cURL and for correct<br>
 * functionality requires properly configured <b>API_URL</b> in ./configuration.ini
 *
 * @author Lubos Babocky <babocky@gmail.com>
 */
class CurlRequest {

    protected ConfigurationService $configurationService;

    public function __construct() {
        $this->configurationService = ConfigurationService::GetInstance();
    }

    /**
     * @param string $ico Company ICO
     * @return array Company data from API
     * @throws Exception when json error
     */
    public function fetchCompanyData(string $ico): array {
        $url = sprintf('%s/%s', rtrim($this->configurationService->getParamValue('API_URL'), '/'), $ico);

        $data = json_decode($this->executeRequest($url), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Failed to parse JSON response: ' . json_last_error_msg());
        }

        return $data;
    }

    /**
     * @param string $url Full api url for request
     * @return string Raw response from API
     * @throws Exception
     */
    private function executeRequest(string $url): string {
        try {
            $request = curl_init();

            curl_setopt_array($request, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => ['Accept: application/json']
            ]);

            $response = curl_exec($request);
            $httpCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
            $curlError = curl_error($request);
        } finally {
            curl_close($request);
        }

        if ($curlError) {
            throw new Exception('cURL error: ' . $curlError);
        }

        if ($httpCode !== 200) {
            throw new Exception('API request failed with status code ' . $httpCode);
        }

        return $response;
    }
}
