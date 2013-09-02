miniroll
========

PHP

miniroll - small blog Quick-and-dirty

Introduction:
-------------
miniroll do not need database, using a very simple framework with file system,
just like a Blog Hello World. But it may be cumbersome to use.
You shall modify some codes to create own blog style. For reference.

How to Run:
-----------
Put all files in a PHP server.

Files Explanation:
------------------
You can see the detail in every files.

* comment.php: The guest comment main module
* comment_w.php: Echo guest comment form
* global_var.php: Global and inital variable
* htmindex.css: All in one CSS
* htmindex.js: Get browser's screen size
* img_ident.php: Create a image, determine whether or not the user is human
* index.php: Main producer creates XHTML tags, default entrance
* index_func.php: Functions for index.php
* index_top.php: Top part of index.php
* index_top2.php: Top part of index.php
* manage.php: Management entrance

Folders Explanation:
-------------------
* az_comment: Guest comment store
* font: Font files and misc
* f_assistant: This folder contain thrid party codes
* images: The website default images
* journal: Blog's all journal store
* journal/mf_php: The journal with PHP function
* journal_menu: Where left menu's protocol, or other link
* manage_dir: Management's dir
* upload: Upload's dir

PHP Environment Require:
-------------------
* Require PHP verion: PHP5
* Require library: GD library, for img_ident.php

Copyright and License:
-------------------
Copyright 2013 Huang Yiting (http://endrollex.com)

miniroll is distributed under the terms of the GNU General Public License

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
