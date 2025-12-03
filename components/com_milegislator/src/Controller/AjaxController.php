<?php

declare(strict_types=1);

namespace Joomla\Component\Milegislator\Site\Controller;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Response\JsonResponse;
use Joomla\Component\Milegislator\Site\Helper\LegislatorHelper;

class AjaxController extends BaseController
{
    public function search(): void
    {
        $app = Factory::getApplication();
        $term = $app->input->getString('q', '');
        $results = LegislatorHelper::searchLegislators($term);
        echo new JsonResponse($results);
    }

    public function lookup(): void
    {
        $app = Factory::getApplication();
        $address = $app->input->getString('address', '');
        $districts = LegislatorHelper::lookupDistrictByAddress($address);

        if (!$districts) {
            echo new JsonResponse(['message' => Text::_('COM_MILEGISLATOR_MESSAGE_NOT_FOUND')], true);
            return;
        }

        $legislators = LegislatorHelper::findLegislatorsByDistrict($districts['house'], $districts['senate']);
        echo new JsonResponse(['districts' => $districts, 'legislators' => $legislators]);
    }
}
