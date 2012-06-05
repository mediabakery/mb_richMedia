<?php
if(!defined('TL_ROOT'))
	die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  mediabakery
 * @author     Sebastian Tilch <http://www.mediabakery.de>
 * @package
 * @license    LGPL
 * @filesource
 */

$GLOBALS['TL_CSS'][] = 'system/modules/mb_richMedia/html/css/fixpos.css';
if(version_compare(VERSION, '2.10', '<'))
{
	$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/mb_richMedia/html/js/picker_old.js';
}
else
{
	$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/mb_richMedia/html/js/picker.js';
}
$GLOBALS['TL_DCA']['tl_content']['palettes']['mb_richMedia'] = '{type_legend},type,headline;{mb_richmedia_legend},mb_richmedia;{protected_legend:hide},protected;{expert_legend:hide},guests,invisible,cssID,space';

$GLOBALS['TL_DCA']['tl_content']['fields']['mb_richmedia'] = array(
	'exclude' => true,
	'label' => &$GLOBALS['TL_LANG']['tl_content']['mb_richmedia'],
	'inputType' => 'text',
	'wizard' => array( array(
			'MbRichMedia',
			'getWizard'
		)),
	'eval' => array('tl_class' => 'long wizard fixpos')
);
?>