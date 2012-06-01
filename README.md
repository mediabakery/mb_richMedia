About
-----

mb_richMedia extends Contao with a richMedia ContentElement. With that element you can easily add rich media like YouTube, Vimeo or Soundcloud to an article without overcomplicating things for the editor.
It is possible to extend mb_richMedia with other richMedia elements (see example below). The templates for basic richMedia elements (YouTube, Vimeo, Soundcloud) can be adjusted as well.

The implementations for embedded richMedia elements are kept very simple. If you need more sophisticated implementations, e.g. for the YouTube object, you can add your own versions. But keep in mind that the goal is to make the addition of rich media elements as easy as possible!

Screenshots
-----------

![Content Element](http://img6.imagebanana.com/img/x8zbehkm/mbrichmedia_youtube.png)


System requirements
-------------------

* Contao 2.9.x or higher


Installation & Configuration
----------------------------

* Unpack the archive on your server.
* Open the installation directory in your web browser.
* Update the database.


Extend mb_richMedia
---------------------------------


add an object witch implements the MbRichMedia_Interface.

in the config.php extend the $GLOBALS['MB_RICHMEDIA'] array:
```php
$GLOBALS['MB_RICHMEDIA']['www.youtube.com'] = 'MbRichMedia_Youtube';
```
The key should be the HOST and the value is the object name.

Troubleshooting
---------------

If you are having problems using the mb_richMedia Extension, please visit the issue tracker at https://github.com/mediabakery/mb_richMedia/issues