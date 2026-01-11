<?php

declare(strict_types=1);

namespace Joomla\Component\Milegislator\Administrator\View\Legislators;

use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

class HtmlView extends BaseHtmlView
{
    protected $items;
    protected $pagination;
    protected $state;

    public function display($tpl = null)
    {
        $this->items      = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state      = $this->get('State');

        $this->addToolbar();

        parent::display($tpl);
    }

    protected function addToolbar(): void
    {
        ToolbarHelper::title(Text::_('COM_MILEGISLATOR_LEGISLATORS_TITLE'), 'users');
    }
}
