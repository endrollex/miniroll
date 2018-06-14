miniroll
========
PHP  
miniroll small blog  

Introduction:
-------------
* miniroll does not need a database, uses a casual framework with filesystem.
* Dirty, mix HTML and PHP.
* Code design for endrollex.com

PHP Environment Require:
------------------------
* Require PHP verion: PHP5
* Require library: GD library, only used in img_ident.php
* Require library: FreeType library, only used in img_ident.php

How to Run:
-----------
Put all files in a PHP server.

License:
--------
* Copyright 2014 Huang Yiting (http://endrollex.com)
* miniroll is distributed under the terms of the GNU General Public License

3rd Party Plugin Note:
----------------------
miniroll is using JW Player as media player.
The default CSS `.table_cpp02 {border-collapse: collapse;}` will cause JW Player UI incorrect.
To correct this issue, please use additional code:

	<div style="border-collapse:separate;">
	...Embedding Code...
	</div>
