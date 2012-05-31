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

class ContentMbRichMedia extends ContentElement
{

	/**
	 *//**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_mb_richmedia';

	 
	 /**
	 * Generate the content element
	 */
	protected function compile()
	{

		$this->Template->richmedia = $this->getRichMediaTemplate();
	}

	private function getRichMediaTemplate()
	{

		$objRichMedia = $this->Database->prepare("SELECT objectname, data FROM tl_mb_richmedia WHERE url=?")->limit(1)->execute(html_entity_decode($this->mb_richmedia));
		if($objRichMedia->numRows == 1)
		{
			$objectname = $objRichMedia->objectname;
			try
			{
				$this->import($objectname);
				$objFETemplate = $this->$objectname->getRichMediaTemplate($objRichMedia);
				return $objFETemplate->parse();
			}
			catch (Exception $e)
			{
				$this->log('Object ' . $objectname . ' is unknown', 'ContentMbRichMedia getRichMediaTemplate', TL_ERROR);
			}
		}
		$this->log('RichMedia Template can not be generated URL:' . $this->mb_richmedia, 'ContentMbRichMedia getRichMediaTemplate', TL_ERROR);

		return '';
	}

}
?>