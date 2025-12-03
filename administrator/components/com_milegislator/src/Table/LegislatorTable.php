<?php

declare(strict_types=1);

namespace Joomla\Component\Milegislator\Administrator\Table;

use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;

class LegislatorTable extends Table
{
    public function __construct(DatabaseDriver $db)
    {
        parent::__construct('#__milegislator_legislators', 'id', $db);
    }
}
