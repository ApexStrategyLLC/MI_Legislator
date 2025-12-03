# MI Legislator

Joomla! 6.0.1 component (`com_milegislator`) for Michigan legislator lookup and party balance insights.

## Features
- Complete database install for 110 House representatives and 38 State senators
- District lookup with city/ZIP prefixes and sensible defaults
- Search by name, party, or district with sortable admin grid
- Party balance statistics helper and frontend widget
- AJAX endpoints for search and address lookup
- ACL-ready administrator menu and language strings for English (en-GB)

## Installation
1. Place `com_milegislator.xml` at the root of your install package alongside the `administrator/components/com_milegislator` and `components/com_milegislator` folders.
2. Zip those three paths together (manifest + admin folder + site folder) and upload the archive in the Extension Manager. Joomla will automatically copy the manifest into the component directory during installation.
3. On install, the SQL script creates `#__milegislator_legislators` and `#__milegislator_citydistricts` with all data preloaded.

## AJAX API
- Search: `index.php?option=com_milegislator&task=ajax.search&format=json&q=searchTerm`
- District lookup: `index.php?option=com_milegislator&task=ajax.lookup&format=json&address=your+address`

## Helper Usage
```php
use Joomla\Component\Milegislator\Site\Helper\LegislatorHelper;

$balance = LegislatorHelper::getPartyBalance();
$matches = LegislatorHelper::searchLegislators('Detroit');
$districts = LegislatorHelper::lookupDistrictByAddress('123 Main St, Detroit, MI 48201');
```
