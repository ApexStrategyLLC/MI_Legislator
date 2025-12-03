<?php

declare(strict_types=1);

namespace Joomla\Component\Milegislator\Site\Model;

use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\Component\Milegislator\Site\Helper\LegislatorHelper;

class LookupModel extends BaseDatabaseModel
{
    public function getPartyBalance(): array
    {
        return LegislatorHelper::getPartyBalance();
    }

    public function search(string $term): array
    {
        return LegislatorHelper::searchLegislators($term);
    }

    public function lookup(string $address): array
    {
        $districts = LegislatorHelper::lookupDistrictByAddress($address);

        if (!$districts) {
            return [];
        }

        return LegislatorHelper::findLegislatorsByDistrict($districts['house'], $districts['senate']);
    }
}
