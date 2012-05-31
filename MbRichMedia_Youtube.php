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

class MbRichMedia_Youtube extends Backend implements MbRichMedia_Interface
{
	private $strHost;

	public function __construct()
	{
		parent::__construct();
		$this->strHost = 'www.youtube.com';
	}

	public function isRichMedia($strUrl)
	{
		$arrUrl = parse_url($strUrl);
		if($arrUrl['host'] == $this->strHost)
		{
			parse_str($arrUrl['query'], $arrQuery);
			return strlen($arrQuery['v']) > 0 ? TRUE : FALSE;
		};
	}

	public function getIcon()
	{
		return $this->generateImage('system/modules/mb_richMedia/html/icons/youtube.png', 'YouTube');
	}

	public function getData($strUrl)
	{
		$arrResultData = array();
		$arrUrl = parse_url($strUrl);
		if($arrUrl && $arrUrl['host'] == $this->strHost)
		{
			parse_str($arrUrl['query'], $arrQuery);
			if($arrQuery['v'])
			{
				$objRequest = new Request();
				$objRequest->send('http://www.youtube.com/oembed?url=http%3A//www.youtube.com/watch?v%3D' . $arrQuery['v'] . '&format=json');
				if($objRequest->hasError())
				{
					$this->log('Error while requesting YouTube: ' . $objRequest->error, 'MbRichMedia_Youtube, getData', TL_ERROR);
					return FALSE;
				}
				$arrResponse = json_decode($objRequest->response, TRUE);
				if(is_null($arrResponse))
				{
					$this->log('Error while decoding json data (' . $objRequest->response . ')', 'MbRichMedia_Youtube, getData', TL_ERROR);
					return FALSE;
				}
				return array_merge(array('video_id' => $arrQuery['v']), $arrResponse);
			}
		}
		return FALSE;
	}

	public function getRichMediaTemplate(DB_Mysql_Result $dc)
	{
		$objTemplate = new FrontendTemplate('mb_richmedia_youtube');
		$objTemplate->setData(deserialize($dc->data)); 
		return $objTemplate;
	}

}
?>