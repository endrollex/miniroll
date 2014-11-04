miniroll
========

PHP

miniroll - small blog Quick-and-dirty

Introduction:
-------------
* miniroll does not need a database, uses a simple framework with filesystem,
  just like a Blog Hello World.
* It may be cumbersome to use. There is no template function here.
  Someone using this blog shall modify many codes to create own blog style manually.
* This project is for reference purpose.
  Generally, WordPress is a better choice, it has complete support and worldwide users.

PHP Environment Require:
------------------------
* Require PHP verion: PHP5
* Require library: GD library, only used in img_ident.php
* Require library: FreeType library, only used in img_ident.php

How to Run:
-----------
Put all files in a PHP server.

Files Explanation:
------------------
You can see the detail in every file.

* **acomment.php**: The guest comment main module
* **comment_w.php**: Echo guest comment form
* **global_var.php**: Global and inital variable
* **htmindex.css**: All in one CSS
* **htmindex.js**: Get browser's screen size
* **img_ident.php**: Create a image, determine whether or not the user is human
* **index.php**: Main producer creates HTML tags, default entrance
* **index_func.php**: Functions for index.php
* **index_top.php**: Top part of index.php
* **index_top2.php**: Top part of index.php
* **manage.php**: Management entrance
* **manage_dir/login.php**: Login function
* **manage_dir/post.php**: Post function
* **manage_dir/post_view.php**: Post edit function
* **manage_dir/upload.php**: Upload function

Folders Explanation:
--------------------
* **az_comment/**: Guest comment store
* **az_comment/log/**: The comment log dir
* **font/**: Font files and misc
* **f_assistant/**: This folder contain third party codes
* **images/**: The website default images
* **journal/**: Blog's all journals store
* **journal/mf_php/**: The journal with PHP function
* **journal_menu/**: Where left menu's protocol, or other link
* **manage_dir/**: Management's dir
* **upload/**: Upload's dir

Mechanism Brief:
----------------
1. miniroll is a simple blog, most functions are minimize.
2. post.php produces journals, the journals store in the filesystem directly.
3. Every normal journal at least has two files, title and content, content's filename is a date('YmdHi', time()),
   title's filename has additional tags what indicates various labels.
4. index.php is a reader to organize these journal files for browse.
5. The markup language minicode (variant of BBCode) is designed for Blog, easy editing HTML.
6. If you write a PHP file (mf_php/*.php) for the journal and specify its label,
   it will be loaded by PHP require() function.
   This feature lets the file run PHP code.

Copyright and License:
----------------------
miniroll - small blog Quick-and-dirty
Copyright 2013 Huang Yiting (http://endrollex.com)
This file is part of miniroll.

miniroll is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.

miniroll is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

3rd Party Plugin Note:
----------------------
miniroll is using JW Player for media player.
The default CSS `.table_cpp02 {border-collapse: collapse;}` will cause JW Player UI incorrect.
To correct this issue, please use additional code:

	<div style="border-collapse:separate;">
	...Embedding Code...
	</div>
