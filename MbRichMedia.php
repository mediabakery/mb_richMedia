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

class MbRichMedia extends Backend
{
	private $defaultIconTag;

	public function __construct()
	{
		parent::__construct();
		$this->defaultIconTag = $this->generateImage('system/modules/mb_richMedia/html/icons/default.png', $GLOBALS['TL_LANG']['MSC']['mb_richmedia_notfound']);
	}

	/**
	 * checks if the URL matches a RichMedia URL. If a match is found the method inserts the data to the database an returns the iconTag. If not FALSE will returned
	 * @param $strUrl String URL
	 * @return
	 */
	public function checkRichMedia($strUrl)
	{
		$strUrl = trim(html_entity_decode($strUrl));
		if(filter_var($strUrl, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED))
		{
			$objRichMedia = $this->Database->prepare("SELECT objectname FROM tl_mb_richmedia WHERE url=?")->limit(1)->execute($strUrl);
			if($objRichMedia->numRows == 1)
				return $this->getIconTag($objRichMedia->objectname);

			/**
			 * MB_RICHMEDIA
			 */
			if(isset($GLOBALS['MB_RICHMEDIA']) && is_array($GLOBALS['MB_RICHMEDIA']))
			{
				foreach($GLOBALS['MB_RICHMEDIA'] as $richmediaobject)
				{
					$this->import($richmediaobject);
					if($this->$richmediaobject instanceof MbRichMedia_Interface)
					{
						if($this->$richmediaobject->isRichMedia($strUrl))
						{
							$this->insertRichMedia($strUrl, $richmediaobject, $this->$richmediaobject->getData($strUrl));
							return $this->$richmediaobject->getIcon();
						}

					}
					else
					{
						$this->log($this->$richmediaobject . ' is not an instance of the MbRichMedia_Interface', 'MbRichMedia checkRichMedia', TL_ERROR);
					}
				}
			}
			else
			{
				$this->log('No RichMedia objects found', 'MbRichMedia checkRichMedia', TL_ERROR);

			}

		}
		return false;

	}

	public function getWizard($dc)
	{
		if(strlen($dc->activeRecord->mb_richmedia))
		{
			$iconTag = $this->checkRichMedia($dc->activeRecord->mb_richmedia);
			if($iconTag)
				return $iconTag;
		}
		return $this->defaultIconTag;
	}

	private function insertRichMedia($strUrl, $strObjName, $arrData)
	{
		if(is_array($arrData) && count($arrData) > 0)
		{
			$arrSet = array(
				'tstamp' => time(),
				'url' => $strUrl,
				'objectname' => $strObjName,
				'data' => serialize($arrData)
			);
			$this->Database->prepare("INSERT INTO tl_mb_richmedia %s")->set($arrSet)->execute();
		}
	}

	private function getIconTag($objectname)
	{
		try
		{
			$this->import($objectname);
			$iconTag = $this->$objectname->getIcon();
			if($iconTag)
				return $iconTag;
		}
		catch (Exception $e)
		{
			$this->log('Object ' . $objectname . ' is unknown', 'MbRichMedia getIconTag', TL_ERROR);
		}
		return $this->generateImage('system/modules/mb_richMedia/html/icons/default.png', $GLOBALS['TL_LANG']['MSC']['mb_richmedia_notfound']);

	}

	public function cleanTable()
	{
		$objMbRichMediaUrls = $this->Database->query("SELECT mb_richmedia FROM tl_content WHERE type='mb_richMedia'");
		$arrRichMediaUrls = array_unique($objMbRichMediaUrls->fetchAllAssoc());
		$objDel = $this->Database->query("DELETE FROM tl_mb_richmedia WHERE url NOT (" . implode(',', $arrRichMediaUrls) . ")");
		$this->log($objDel->numRows . ' deleted', 'MbRichMedia cleanTable', TL_CRON);
	}

	public function ajaxGetIconTag($strAction)
	{
		if($strAction == 'mbRichMediaGetIconTag')
		{
			$this->import('Input');
			$arrResponse = array();

			$iconTag = $this->checkRichMedia($this->Input->post('url'));
			if(!$iconTag)
				$iconTag = $this->defaultIconTag;

			echo json_encode(array('content' => $iconTag));
			exit ;
		}
	}

}
?>