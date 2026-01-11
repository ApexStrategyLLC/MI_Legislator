<?php

declare(strict_types=1);

namespace Joomla\Component\Milegislator\Site\View\Lookup;

use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;

class HtmlView extends BaseHtmlView
{
    protected $partyBalance;

    public function display($tpl = null)
    {
        $this->partyBalance = $this->getModel()->getPartyBalance();
        parent::display($tpl);
    }
}
