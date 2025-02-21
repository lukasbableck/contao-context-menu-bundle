<?php

use Contao\CoreBundle\DataContainer\PaletteManipulator;

$GLOBALS['TL_DCA']['tl_user']['fields']['enableContextMenu'] = [
	'inputType' => 'checkbox',
	'eval' => ['tl_class' => 'w50'],
	'default' => true,
	'sql' => "char(1) NOT NULL default '1'",
];
$GLOBALS['TL_DCA']['tl_user']['fields']['alwaysShowOperations'] = [
	'inputType' => 'checkbox',
	'options' => [
		'articles',
		'children',
		'compare',
		'copy',
		'cut',
		'delete',
		'edit',
		'exportTheme',
		'imageSizes',
		'layout',
		'modules',
		'show',
		'source',
		'subpages',
		'undo',
	],
	'reference' => &$GLOBALS['TL_LANG']['tl_user']['contextOperations'],
	'eval' => ['tl_class' => 'w50 clr', 'multiple' => true],
	'sql' => 'blob NULL',
];

PaletteManipulator::create()
	->addLegend('contextmenu_legend', 'backend_legend', PaletteManipulator::POSITION_AFTER)
	->addField('enableContextMenu', 'contextmenu_legend', PaletteManipulator::POSITION_APPEND)
	->addField('alwaysShowOperations', 'contextmenu_legend', PaletteManipulator::POSITION_APPEND)
	->applyToPalette('default', 'tl_user')
	->applyToPalette('admin', 'tl_user')
	->applyToPalette('login', 'tl_user')
;
