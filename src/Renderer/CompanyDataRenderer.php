<?php

namespace Lb\CompanyLibrary\Renderer;

use Lb\CompanyLibrary\Utility\GeneralUtility;

/**
 * Description of CompanyDataRenderer
 * class is responsible for rendering data, e.g ->renderHtmlTable()
 *
 * @author Lubos Babocky <babocky@gmail.com>
 */
class CompanyDataRenderer {

    protected array $companyData;

    /**
     * @param array $companyData Company data retireved from CurlRequest class
     */
    public function __construct(array $companyData) {
        $this->companyData = $companyData;
    }

    /**
     * Renders html table
     * @return void
     */
    public function renderHtmlTable(): void {
        $data = $this->companyData;

        $getArrayVal = function (string $keys) use ($data) {
            return GeneralUtility::GetMultiArrayValue($data, $keys, 'N/A');
        };

        echo <<<COMPANYDATATABLE
        <table>
            <tr>
                <td>IČO</td>
                <td>{$getArrayVal('ico')}</td>
            </tr>
            <tr>
                <td>Obchodný názov</td>
                <td>{$getArrayVal('obchodniJmeno')}</td>
            </tr>
            <tr>
                <td>Právna forma</td>
                <td>{$getArrayVal('pravniForma')}</td>
            </tr>
            <tr>
                <td>Sídlo</td>
                <td>
                    {$getArrayVal('sidlo.nazevUlice')} {$getArrayVal('sidlo.cisloDomovni')}/{$getArrayVal('sidlo.cisloOrientacni')}, {$getArrayVal('sidlo.nazevCastiObce')}, {$getArrayVal('sidlo.psc')} {$getArrayVal('sidlo.nazevObce')}
                </td>
            </tr>
        </table>
COMPANYDATATABLE;
    }
}
