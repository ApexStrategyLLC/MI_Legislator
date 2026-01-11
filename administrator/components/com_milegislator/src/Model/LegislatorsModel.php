<?php

declare(strict_types=1);

namespace Joomla\Component\Milegislator\Administrator\Model;

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\Database\ParameterType;

class LegislatorsModel extends ListModel
{
    protected function populateState($ordering = null, $direction = null)
    {
        $app = $this->getApplication();
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $party = $app->getUserStateFromRequest($this->context . '.filter.party', 'filter_party');
        $type  = $app->getUserStateFromRequest($this->context . '.filter.type', 'filter_type');

        $this->setState('filter.search', $search);
        $this->setState('filter.party', $party);
        $this->setState('filter.type', $type);

        parent::populateState($ordering ?? 'l.name', $direction ?? 'ASC');
    }

    protected function getListQuery()
    {
        $db    = $this->getDatabase();
        $query = $db->getQuery(true)
            ->select('l.*')
            ->from($db->quoteName('#__milegislator_legislators', 'l'));

        if ($search = $this->getState('filter.search')) {
            $like = '%' . $db->escape($search, true) . '%';
            $query->where('l.name LIKE ' . $db->quote($like));
        }

        if ($party = $this->getState('filter.party')) {
            $query->where('l.party = :party')
                ->bind(':party', $party, ParameterType::STRING);
        }

        if ($type = $this->getState('filter.type')) {
            $query->where('l.type = :type')
                ->bind(':type', $type, ParameterType::STRING);
        }

        $orderCol  = $this->state->get('list.ordering', 'l.name');
        $orderDirn = $this->state->get('list.direction', 'ASC');
        $query->order($db->escape($orderCol . ' ' . $orderDirn));

        return $query;
    }
}
