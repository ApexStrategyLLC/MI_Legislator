<?php
/** @var Joomla\CMS\Document\HtmlDocument $this */

declare(strict_types=1);

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

$balance = $this->partyBalance;
?>
<div class="com-milegislator">
    <h1><?php echo Text::_('COM_MILEGISLATOR_LOOKUP_TITLE'); ?></h1>
    <p><?php echo Text::_('COM_MILEGISLATOR_LOOKUP_DESC'); ?></p>

    <form id="milegislator-search" class="mb-3" method="get" action="<?php echo Route::_('index.php?option=com_milegislator&view=lookup'); ?>">
        <div class="mb-2">
            <input type="text" name="q" class="form-control" placeholder="<?php echo Text::_('COM_MILEGISLATOR_FIELD_QUERY'); ?>" />
        </div>
        <div class="mb-2">
            <input type="text" name="address" class="form-control" placeholder="<?php echo Text::_('COM_MILEGISLATOR_ADDRESS_HINT'); ?>" />
        </div>
        <button type="submit" class="btn btn-primary"><?php echo Text::_('COM_MILEGISLATOR_BUTTON_SEARCH'); ?></button>
    </form>

    <div class="alert alert-info">
        <strong><?php echo Text::_('COM_MILEGISLATOR_PARTY_BALANCE'); ?>:</strong>
        <div><?php echo sprintf(Text::_('COM_MILEGISLATOR_BALANCE_HOUSE'), $balance['house']['democratic'], $balance['house']['republican'], $balance['house']['total']); ?></div>
        <div><?php echo sprintf(Text::_('COM_MILEGISLATOR_BALANCE_SENATE'), $balance['senate']['democratic'], $balance['senate']['republican'], $balance['senate']['total']); ?></div>
    </div>

    <p><?php echo Text::_('COM_MILEGISLATOR_AJAX_ENDPOINT'); ?>: index.php?option=com_milegislator&task=ajax.lookup</p>
</div>
