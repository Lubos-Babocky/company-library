# CompanyLibrary

CompanyLibrary je knižnica na získavanie údajov o českých spoločnostiach pomocou IČO (Identifikačné číslo osoby).

## Požiadavky
- PHP 7.4+
- cURL (musí byť povolené v PHP konfigurácii)

## Inštalácia
1. Stiahni alebo naklonuj projekt z repozitára.
2. Spusti príkaz `composer install` na nainštalovanie všetkých potrebných závislostí.
3. Uisti sa, že súbor `configuration.ini` je správne nakonfigurovaný.

## Použitie
### Príklad:
```php
require_once 'vendor/autoload.php';

use Lb\CompanyLibrary\CompanyDataLoader;

$loader = new CompanyDataLoader();
$loader->findCompany('01569651')->renderCompanyData();
