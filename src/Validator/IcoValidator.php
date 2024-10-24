<?php

declare (strict_types=1);

namespace Lb\CompanyLibrary\Validator;

/**
 * Description of IcoValidator
 * Class for testing Company identification number (ICO) validity, it must be numeric and contain exactly 8 digits
 * 
 * @author Lubos Babocky <babocky@gmail.com>
 */
class IcoValidator {

    /**
     * @param string $ico Company identification number
     * @return void method either throws an exception or completes without errors.
     * @throws InvalidIcoException when received $ico is not valid
     */
    public function validateICO(string $ico): void {
        if (!is_numeric($ico)) {
            throw new InvalidIcoException('IČO smie obsahovať len čísla');
        }
        if (strlen($ico) !== 8) {
            throw new InvalidIcoException('IČO musí obsahovať presne 8 čísel');
        }
    }
}
