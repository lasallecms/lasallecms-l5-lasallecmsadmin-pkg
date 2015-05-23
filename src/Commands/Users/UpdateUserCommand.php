<?php
namespace Lasallecms\Lasallecmsadmin\Commands\Users;

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
 * @version    1.0.0
 * @link       http://LaSalleCMS.com
 * @copyright  (c) 2015, The South LaSalle Trading Corporation
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 * @author     The South LaSalle Trading Corporation
 * @email      info@southlasalle.com
 *
 */



///////////////////////////////////////////////////////////////////
//// USER MANAGEMENT AND AUTHENTICATION IS SO BESPOKE THAT     ////
////      IT IS NOT PART OF LASALLE's FORM AUTOMATION          ////
///////////////////////////////////////////////////////////////////



// Laravel Software
use Lasallecms\Lasallecmsadmin\Commands\Command;

// Laravel classes
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Lasallecms\Lasallecmsapi\Users\UpdateUserFormProcessing;


class UpdateUserCommand extends Command implements SelfHandling
{
    use DispatchesCommands;

    public $id;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $activated;
    public $enabled;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($id, $name, $email, $password, $password_confirmation, $activated=0, $enabled=0)
    {
        $this->id                    = $id;
        $this->name                  = $name;
        $this->email                 = $email;
        $this->password              = $password;
        $this->password_confirmation = $password_confirmation;
        $this->activated             = $activated;
        $this->enabled               = $enabled;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(UpdateUserFormProcessing $updateUserFormProcessing)
    {
        return $updateUserFormProcessing->quarterback($this);
    }
}