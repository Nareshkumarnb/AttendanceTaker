AttendanceTaker
===============

**AttendanceTaker** is a web application for take attendance using mobile devices, developed with PHP and AngularJS.

Features
--------

Standard's user can:

 * ...
     
Administrator's users can (additionally)...

Usage
-----

The application should be able to run in any valid PHP web server, such as Apache.

The application makes uses of a PostgreSQL database, whose parameters must be defined in the file `.....` (located in the folder `......`). Before the first run, the script `......` must be executed in the database.

After installation, two default accounts can be used to login: "admin" and "demo" (whose passwords are respectively "admin" and "demo").

Optionally, you can configure the path in which the log files are going to be created. In order to do it, you must edit the file `.....` located in the folder `........`).

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