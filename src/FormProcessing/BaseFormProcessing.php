<?php
namespace Lasallecms\Lasallecmsadmin\FormProcessing;

/**
 *
 * Internal API package for the LaSalle Content Management System, based on the Laravel 5 Framework
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
 * @package    Internal API package for the LaSalle Content Management System

 * @link       http://LaSalleCMS.com
 * @copyright  (c) 2015 - 2016, The South LaSalle Trading Corporation
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 * @author     The South LaSalle Trading Corporation
 * @email      info@southlasalle.com
 *
 */

// LaSalle Software
use Lasallecms\Formhandling\FormProcessingContract\FormProcessing;

// Laravel facades
use Illuminate\Support\Facades\Validator;

/**
 * Class BaseFormProcessing
 * @package Lasallecms\Lasallecmsapi\FormProcessing
 */
class BaseFormProcessing implements FormProcessing
{
    /*
     * In charge of the form process.
     *
     * Return a status message.
     *
     * @param  mixed  $command
     * @return text
     */
    public function quarterback($command) {}


    /*
     * Any constraints to check due to foreign keys
     *
     * @param  array  $data
     * @return bool
     */
    public function isForeignKeyOk($data) {}


    /*
     * Sanitize and transform the data
     *
     * @param  array  $data
     * @param  text   $type   Either "create" or "update"
     * @return array
     */
    public function sanitize($data, $type) {
        if (strtolower($type) == "create") $rules = $this->repository->getSanitationRulesForCreate();

        if (strtolower($type) == "update") $rules = $this->repository->getSanitationRulesForUpdate();

        $sanitizedData = $this->repository->getSanitize($data, $rules);

        return $sanitizedData;
    }


    /*
     * Validate
     *
     * @param  array  $data
     * @param  text   $type   Are we validating a create or update?
     * @return bool
     */
    public function validate($data, $type) {
        if (strtolower($type) == "create") $rules = $this->repository->getValidationRulesForCreate();

        if (strtolower($type) == "update") $rules = $this->repository->getValidationRulesForUpdate();

        $validator = Validator::make($data,$rules);

        if ($validator->fails()) return $validator->messages();

        return "passed";
    }


    /*
     * Wash data even further.
     *
     * @param  array  $data
     * @return array
     */
    public function wash($data) {
        return $this->repository->washDataForPersist($data);
    }


    /*
     * Persist --> save/update to the database
     *
     * @param  array  $data
     * @param  text   $type   Create (INSERT), update (UPDATE), or destroy (DELETE)
     * @return bool
     */
    public function persist($data, $type) {
        if (strtolower($type) == "create") return $this->repository->createRecord($data);

        if (strtolower($type) == "update") return $this->repository->updateRecord($data);

        if (strtolower($type) == "destroy") return $this->repository->destroyRecord($data);
    }


    /*
     * Unlock the record.
     * "Locked" is defined as the 'locked_by' field being populated; that is,> 0
     *
     * @param  int   $id
     * @return bool
     */
    public function unlock($id) {
        $this->repository->unpopulateLockFields($id);
    }


    /*
     * Prepare the response array.
     * The response array is returned to the originating controller method, to let the
     * originating controller know what happened. The originating controller can then take proper action.
     *
     * @param  string  $status_text    Eg: "validation_failed"
     * @param  int     $status_code    200 = success
     *                                 400 = warning
     *                                 500 = error
     * @param  array   $data           Sanitized data
     * @param  object  $errorMessages  Expect this to be
     *                                 https://github.com/laravel/framework/blob/5.1/src/Illuminate/Support/MessageBag.php
     */
    public function prepareResponseArray($status_text, $status_code, $data = null, $errorMessages = null) {
        $response = [
            'status_text'   => $status_text,
            'status_code'   => $status_code,
            'data'          => $data,
            'errorMessages' => $errorMessages
        ];

        return $response;
    }
}
