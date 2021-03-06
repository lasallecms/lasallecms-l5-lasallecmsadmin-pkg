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
use Lasallecms\Lasallecmsadmin\FormProcessing\Users\ExtraUserValidation;


/**
 * Class CreateUserFormProcessing
 * @package Lasallecms\Lasallecmsapi\Users
 */
class CreateUserFormProcessing extends BaseFormProcessing
{
    /**
     * Instance of repository
     *
     * @var Lasallecms\Lasallecmsapi\Repositories\UserRepository
     */
    protected $repository;

    /**
     * @var Lasallecms\Lasallecmsadmin\FormProcessing\Users\ExtraUserValidation
     */
    protected $extraUserValidation;


    /**
     * Inject the model
     *
     * @param  Lasallecms\Lasallecmsapi\Repositories\UserRepository
     * @param  Lasallecms\Lasallecmsadmin\FormProcessing\Users\ExtraUserValidation
     */
    public function __construct(UserRepository $repository, ExtraUserValidation $extraUserValidation) {
        $this->repository          = $repository;
        $this->extraUserValidation = $extraUserValidation;
    }


    /**
     * The processing steps.
     *
     * @param  The command bus object   $createUserCommand
     * @return The custom response array
     */
    public function quarterback($createUserCommand) {

        // Get inputs into array
        $data = (array) $createUserCommand;


        // Sanitize
        $data = $this->sanitize($data, "create");

        // Wash the phone number
        if (isset($data['phone_number'])) {
            $data['phone_number'] = $this->repository->washPhoneNumber($data['phone_number']);
        }


        // Validate
        if ($this->validate($data, "create") != "passed") {
            // Prepare the response array, and then return to the edit form with error messages
            return $this->prepareResponseArray('validation_failed', 500, $data, $this->validate($data, "create"));
        }

        // Extra user validation
        $extraUserValidation = $this->extraUserValidation->extraValidation($data, false);

        if ($extraUserValidation['status_text'] != "extra_validation_successful") {
            // Prepare the response array, and then return to the edit form with error messages
            return $this->prepareResponseArray('validation_failed', 500, $data, $extraUserValidation['errorMessages']);
        }

        // Create
        if ( !$this->repository->createUser($data) ) {
            // Prepare the response array, and then return to the edit form with error messages
            // Laravel's https://github.com/laravel/framework/blob/5.0/src/Illuminate/Database/Eloquent/Model.php
            //  does not prepare a MessageBag object, so we'll whip up an error message in the
            //  originating controller
            return $this->prepareResponseArray('persist_failed', 500, $data);
        }

        // Prepare the response array, and then return to the command
        return $this->prepareResponseArray('create_successful', 200, $data);
    }


    /**
     * The processing steps.
     *
     * @param  The command bus object   $createUserCommand
     * @return The custom response array
     */
    public function quarterback2fa($createUserCommand) {

        // Get inputs into array
        $data = (array) $createUserCommand;


        // Sanitize
        $data = $this->sanitize($data, "create");

        // Wash the phone number
        $data['phone_number'] = $this->repository->washPhoneNumber($data['phone_number']);


        // Validate
        if ($this->validate($data, "create") != "passed") {
            // Prepare the response array, and then return to the edit form with error messages
            return $this->prepareResponseArray('validation_failed', 500, $data, $this->validate($data, "create"));
        }

        // Extra user validation
        $extraUserValidation = $this->extraUserValidation->extraValidation($data);
        if ($extraUserValidation['status_text'] != "extra_validation_successful") {
            // Prepare the response array, and then return to the edit form with error messages
            return $this->prepareResponseArray('validation_failed', 500, $data, $extraUserValidation['errorMessages']);
        }


        // We're here just to validate the data, not to create a database record.
        // So, no persist!

        // Prepare the response array, and then return to the command
        return $this->prepareResponseArray('validation_successful', 200, $data);
    }
}