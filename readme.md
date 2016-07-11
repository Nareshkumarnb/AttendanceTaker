AttendanceTaker
===============

**AttendanceTaker** is a web application for take attendance using mobile devices, developed with PHP and AngularJS.

Features
--------

Standard's user can take attendance and check previous attendance lists.
     
Administrator's users can (additionally) manage the list of events, groups, persons and users.

Usage
-----

The application should be able to run in any valid PHP web server, such as Apache (note that  the modules `php_pdo_pgsql` and `php_pgsql` must be enabled).

The application makes uses of a PostgreSQL database, whose parameters must be defined in the file `api.config.php` (located in the folder `source\rest`). Before the first run, the script `database.sql` must be executed in the database.

After installation, two default accounts can be used to login: "admin" and "demo" (whose passwords are respectively "admin" and "demo").

Optionally, you can configure the path in which the log files are going to be created, by editing the file `api.config.php`.

Stack
-----

The back-end was designed as a REST API, developed with:

 * _PHP_ as programming language.
 * _Slim_ as framework.
 * _ActiveRecord_ as library for interact with the database.
 * _KLogger_ as logger library.
 * _PostgreSQL_ as database.

The front-end was designed as a _single page application_ using:

 * _JavaScript_ as programming language.
 * _AngularJS_ as MVC framework.
 * _BootStrap_ as UI framework.

License
-------

This application is free software; you can redistribute it and/or
modify it under the terms of the GNU Affero General Public
License as published by the Free Software Foundation; either
version 3 of the License, or (at your option) any later version.

This application is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public
License along with this application; If not, see <http://www.gnu.org/licenses/>.