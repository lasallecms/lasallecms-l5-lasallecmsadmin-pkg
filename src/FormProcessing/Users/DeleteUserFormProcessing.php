<?php

namespace Lasallecms\Lasallecmsadmin\FormProcessing\Users;

/**
 *
 * Administrative package for the LaSalle Content Management System, based on the Laravel 5 Framework
 * Copyright (C) 2015 - 2016  The South LaSalle Trading Corporation
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
 * @copyright  (c) 2015 - 2016, The South LaSalle Trading Corporation
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 * @author     The South LaSalle Trading Corporation
 * @email      info@southlasalle.com
 *
 */




///////////////////////////////////////////////////////////////////
//// USER MANAGEMENT AND AUTHENTICATION IS SO BESPOKE THAT     ////
//// IT IS NOT PART OF LASALLE's FORM AUTOMATION. HOWEVER,     ////
//// THE FORM PROCESSING IS STILL BASED ON THE FORM PROCESSING ////
//// INTERFACE, WHICH IS GREAT JUST FOR READABILITY, AND,      ////
//// IT USES THE BASE PROCESSING METHODS UNLESS OVER-RIDDEN.   ////
///////////////////////////////////////////////////////////////////



// LaSalle Software
use Lasallecms\Lasallecmsadmin\FormProcessing\BaseFormProcessing;
use Lasallecms\Lasallecmsapi\Repositories\UserRepository;


/*
 * Process a deletion.
 * Go through the standard process (interface).
 */
class DeleteUserFormProcessing extends BaseFormProcessing
{
    /*
     * Instance of repository
     *
     * @var Lasallecms\Lasallecmsapi\Repositories\UserRepository
     */
    protected $repository;

    /*
     * Inject the model
     *
     * @param  Lasallecms\Lasallecmsapi\Repositories\UserRepository
     */
    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }


    /*
     * The processing steps.
     *
     * @param  The command bus object   $deleteUserCommand
     * @return The custom response array
     */
    public function quarterback($deleteUserCommand) {

        // Get inputs into array
        $data = (array) $deleteUserCommand;


        // Foreign Key check
        // Done this way in order to return the count totals for "created_by" and "updated_by"
        // (i) test
        $fkc_result = $this->isForeignKeyOk($data);

        // (ii) evaluate test
        $fkc_test = true;
        if ($fkc_result['created_by'] > 0) $fkc_test = false;
        if ($fkc_result['updated_by'] > 0) $fkc_test = false;

        if (!$fkc_test)
        {
            $fkc_test_message  = "This user cannot be deleted because this user has created ".$fkc_result['created_by']." post(s) ";
            $fkc_test_message .= "and has updated ".$fkc_result['updated_by']." post(s). To delete this user, they must have not ";
            $fkc_test_message .= "created nor updated any posts.";

            // Prepare the response array, and then return to the index with error messages
            return $this->prepareResponseArray($fkc_test_message, 500, $data);
        }

        // Delete!
        //if (!$this->persist($data))
        if ( !$this->repository->getDestroy($data['id']->id) )
        {
            // Prepare the response array, and then return to the edit form with error messages
            // Laravel's https://github.com/laravel/framework/blob/5.0/src/Illuminate/Database/Eloquent/Model.php
            //  does not prepare a MessageBag object, so we'll whip up an error message in the
            //  originating controller
            return $this->prepareResponseArray('persist_failed', 500, $data);
        }


        // Prepare the response array, and then return to the command
        return $this->prepareResponseArray('create_successful', 200, $data);
    }


    /*
     * Any constraints to check due to foreign keys
     *
     * @param  array  $data
     * @return array
     */
    public function isForeignKeyOk($data) {
        return $this->repository->countAllPostsThatHaveUserId($data['id']->id);
    }
}