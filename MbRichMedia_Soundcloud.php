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

class MbRichMedia_Soundcloud extends Backend implements MbRichMedia_Interface
{
	private $strHost;

	public function __construct()
	{
		parent::__construct();
		$this->strHost = 'soundcloud.com';
	}

	public function isRichMedia($strUrl)
	{
		$arrUrl = parse_url($strUrl);
		return ($arrUrl['host'] == $this->strHost);
	}

	public function getIcon()
	{
		return $this->generateImage('system/modules/mb_richMedia/html/icons/soundcloud.png', 'Soundcloud');
	}

	public function getData($strUrl)
	{
		$arrResultData = array();

		$objRequest = new Request();
		$objRequest->send('http://soundcloud.com/oembed?iframe=true&format=json&url=' . urlencode($strUrl));
		if($objRequest->hasError())
		{
			$this->log('Error while requesting Soundcloud: ' . $objRequest->error, 'MbRichMedia_Soundcloud, getData', TL_ERROR);
			return FALSE;
		}
		$arrResponse = json_decode($objRequest->response, TRUE);
		if(is_null($arrResponse))
		{
			$this->log('Error while decoding json data (' . $objRequest->response . ')', 'MbRichMedia_Soundcloud, getData', TL_ERROR);
			return FALSE;
		}
		return $arrResponse;

	}

	public function getRichMediaTemplate(DB_Mysql_Result $dc)
	{
		$objTemplate = new FrontendTemplate('mb_richmedia_soundcloud');
		$objTemplate->setData(deserialize($dc->data));
		return $objTemplate;
	}

}
?>