<?php
/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */

declare(strict_types=1);

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

$wa = $this->document->getWebAssetManager();
$wa->usePreset('tabler')
    ->useStyle('com_milegislator.admin');

$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
?>
<form action="<?php echo Route::_('index.php?option=com_milegislator&view=legislators'); ?>" method="post" name="adminForm" id="adminForm">
    <div class="row mb-3">
        <div class="col-6">
            <input type="text" name="filter_search" placeholder="<?php echo Text::_('COM_MILEGISLATOR_FILTER_SEARCH_LABEL'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" class="form-control" />
        </div>
        <div class="col-3">
            <?php echo HTMLHelper::_('select.genericlist', [
                ['value' => '', 'text' => Text::_('JALL')],
                ['value' => 'Democratic', 'text' => Text::_('COM_MILEGISLATOR_PARTY_DEM')],
                ['value' => 'Republican', 'text' => Text::_('COM_MILEGISLATOR_PARTY_REP')],
            ], 'filter_party', 'class="form-select"', 'value', 'text', $this->state->get('filter.party')); ?>
        </div>
        <div class="col-3">
            <?php echo HTMLHelper::_('select.genericlist', [
                ['value' => '', 'text' => Text::_('JALL')],
                ['value' => 'house', 'text' => Text::_('COM_MILEGISLATOR_TYPE_HOUSE')],
                ['value' => 'senate', 'text' => Text::_('COM_MILEGISLATOR_TYPE_SENATE')],
            ], 'filter_type', 'class="form-select"', 'value', 'text', $this->state->get('filter.type')); ?>
        </div>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th><?php echo HTMLHelper::_('searchtools.sort', Text::_('COM_MILEGISLATOR_FIELD_NAME'), 'l.name', $listDirn, $listOrder); ?></th>
                <th><?php echo Text::_('COM_MILEGISLATOR_FIELD_DISTRICT'); ?></th>
                <th><?php echo Text::_('COM_MILEGISLATOR_FIELD_TYPE'); ?></th>
                <th><?php echo Text::_('COM_MILEGISLATOR_FIELD_PARTY'); ?></th>
                <th><?php echo Text::_('COM_MILEGISLATOR_FIELD_EMAIL'); ?></th>
                <th><?php echo Text::_('COM_MILEGISLATOR_FIELD_PHONE'); ?></th>
                <th><?php echo Text::_('COM_MILEGISLATOR_FIELD_OFFICE'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($this->items)) : ?>
                <?php foreach ($this->items as $item) : ?>
                    <tr>
                        <td><?php echo $this->escape($item->name); ?></td>
                        <td><?php echo $this->escape($item->district); ?></td>
                        <td><?php echo $item->type === 'house' ? Text::_('COM_MILEGISLATOR_TYPE_HOUSE') : Text::_('COM_MILEGISLATOR_TYPE_SENATE'); ?></td>
                        <td><?php echo $this->escape($item->party); ?></td>
                        <td><a href="mailto:<?php echo $this->escape($item->email); ?>"><?php echo $this->escape($item->email); ?></a></td>
                        <td><?php echo $this->escape($item->phone); ?></td>
                        <td><?php echo $this->escape($item->office ?? ''); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7" class="text-center"><?php echo Text::_('COM_MILEGISLATOR_MESSAGE_NOT_FOUND'); ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-between">
        <div>
            <?php echo $this->pagination->getListFooter(); ?>
        </div>
    </div>

    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
    <?php echo HTMLHelper::_('form.token'); ?>
</form>
