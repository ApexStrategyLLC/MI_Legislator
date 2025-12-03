<?php

declare(strict_types=1);

namespace Joomla\Component\Milegislator\Site\Helper;

use Joomla\CMS\Factory;
use Joomla\Database\DatabaseInterface;

class LegislatorHelper
{
    public static function getDb(): DatabaseInterface
    {
        return Factory::getContainer()->get(DatabaseInterface::class);
    }

    public static function getPartyBalance(): array
    {
        $db = self::getDb();
        $query = $db->getQuery(true)
            ->select('type, party, COUNT(*) as count')
            ->from($db->quoteName('#__milegislator_legislators'))
            ->group('type, party');
        $rows = $db->setQuery($query)->loadObjectList();

        $balance = [
            'house' => ['democratic' => 0, 'republican' => 0, 'total' => 0],
            'senate' => ['democratic' => 0, 'republican' => 0, 'total' => 0],
        ];

        foreach ($rows as $row) {
            $chamber = $row->type;
            $partyKey = strtolower($row->party) === 'democratic' ? 'democratic' : 'republican';
            $balance[$chamber][$partyKey] = (int) $row->count;
            $balance[$chamber]['total'] += (int) $row->count;
        }

        return $balance;
    }

    public static function lookupDistrictByAddress(string $address): ?array
    {
        $db = self::getDb();
        $lowerAddress = strtolower($address);

        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__milegislator_citydistricts'));
        $records = $db->setQuery($query)->loadObjectList();

        foreach ($records as $record) {
            if (str_contains($lowerAddress, strtolower($record->city))) {
                return ['house' => $record->house_district, 'senate' => $record->senate_district];
            }
        }

        if (preg_match('/\b\d{5}\b/', $address, $matches)) {
            $zip = $matches[0];
            foreach ($records as $record) {
                if ($record->zip_prefix && str_starts_with($zip, $record->zip_prefix)) {
                    return ['house' => $record->house_district, 'senate' => $record->senate_district];
                }
            }
        }

        return null;
    }

    public static function findLegislatorsByDistrict(string $houseDistrict, string $senateDistrict): array
    {
        $db = self::getDb();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__milegislator_legislators'))
            ->where('district IN (:house, :senate)')
            ->bind(':house', $houseDistrict)
            ->bind(':senate', $senateDistrict);

        return $db->setQuery($query)->loadObjectList();
    }

    public static function searchLegislators(string $term): array
    {
        $db = self::getDb();
        $like = '%' . $db->escape($term, true) . '%';
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__milegislator_legislators'))
            ->where('name LIKE ' . $db->quote($like), 'OR')
            ->where('district LIKE ' . $db->quote($like), 'OR')
            ->where('party LIKE ' . $db->quote($like));

        return $db->setQuery($query)->loadObjectList();
    }
}
