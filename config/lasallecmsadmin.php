<?php

/**
 *
 * Administrative package for the LaSalle Content Management System, based on the Laravel 5 Framework
 * Copyright (C) 2015  The South LaSalle Trading Corporation
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * @package    Administrative package for the LaSalle Content Management System
 * @link       http://LaSalleCMS.com
 * @copyright  (c) 2015, The South LaSalle Trading Corporation
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 * @author     The South LaSalle Trading Corporation
 * @email      info@southlasalle.com
 *
 */



return [

    /*
    |--------------------------------------------------------------------------
    | Admin Template
    |--------------------------------------------------------------------------
    |
    | What is the name of your admin template?
    |
    | Your lasallecmsadmin views are located at:
    |
    | resources/views/vendor/lasallecmsadmin/admin_template_name/
    |
    */
    // The "bob1" template is based on the FOSS AdminLTE template.
    'admin_template_name' => 'bob1',


    /*
    |--------------------------------------------------------------------------
    | Use dashboard route
    |--------------------------------------------------------------------------
    |
    | Use the built-in dashboard route, or use your own in your app's route file.
    |
    | true  = use the built-in dashboard route
    |
    | false = use your own dashboard route in your app's route file
    |
    */
    'admin_route_dashboard' => 'true',


];
