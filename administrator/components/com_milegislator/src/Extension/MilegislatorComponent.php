<?php

declare(strict_types=1);

namespace Joomla\Component\Milegislator\Administrator\Extension;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Extension\MVCComponent;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Factory\MvcFactoryInterface;
use Joomla\CMS\Router\Route;
use Joomla\Component\Milegislator\Site\Helper\LegislatorHelper;

// Bootstrap class for the component
class MilegislatorComponent extends MVCComponent
{
    public function __construct(MvcFactoryInterface $factory)
    {
        parent::__construct($factory);
    }

    /**
     * Ensure helper autoloads for both site and administrator contexts.
     */
    public function boot(
        MvcFactoryInterface $factory,
        ?\Joomla\CMS\Application\CMSApplicationInterface $application = null
    ): void {
        parent::boot($factory, $application);

        // Preload helper so shared API is available in both contexts
        if (!class_exists(LegislatorHelper::class)) {
            require_once JPATH_SITE . '/components/com_milegislator/src/Helper/LegislatorHelper.php';
        }
    }

    /**
     * Return dashboard message for the administrator screen.
     */
    public function getDashboardTitle(): string
    {
        $balance = LegislatorHelper::getPartyBalance();

        return Text::sprintf(
            'COM_MILEGISLATOR_PARTY_BALANCE_LABEL'
        ) . ' ' .
            sprintf(
                Text::_('COM_MILEGISLATOR_BALANCE_HOUSE'),
                $balance['house']['democratic'],
                $balance['house']['republican'],
                $balance['house']['total']
            ) . ' | ' .
            sprintf(
                Text::_('COM_MILEGISLATOR_BALANCE_SENATE'),
                $balance['senate']['democratic'],
                $balance['senate']['republican'],
                $balance['senate']['total']
            );
    }
}
