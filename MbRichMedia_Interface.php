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

interface MbRichMedia_Interface
{
	
	/**
	 * returns TRUE if the url matches this Richmedia object
	 * @param $strUrl String URL
	 * @return bool
	 */
	public function isRichMedia($strUrl);
	
	/**
	 * returns the Icon HTML Tag for this RichMedia
	 * @return String htmlTag
	 */
	public function getIcon();
	
	/**
	 * returns the data of the richMedia object
	 * @param $strUrl String URL
	 * @return arr Data of the richMedia object if detected, else FALSE
	 */
	public function getData($strUrl);
	
	/**
	 * returns the FrontendTemplate of the richMedia object
	 * @param $dc DataContainer
	 * @return FrontendTemplate
	 */
	public function getRichMediaTemplate(DB_Mysql_Result $dc);

}
?>