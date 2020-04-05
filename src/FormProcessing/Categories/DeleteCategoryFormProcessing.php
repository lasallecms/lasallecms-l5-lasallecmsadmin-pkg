<?php

namespace Lasallecms\Lasallecmsadmin\FormProcessing\Categories;

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
///            THIS IS A COMMAND HANDLER                        ///
///////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////
//// CATEGORIES IS A LOOKUP TABLE, BUT ACCOMMODATING "PARENT ID"    ////
//// REQUIRES BESPOKE VIEWS, AND A BESPOKE FOREIGN KEY CONSTRAINT   ////
////////////////////////////////////////////////////////////////////////


// LaSalle Software
use Lasallecms\Lasallecmsapi\Repositories\CategoryRepository;
use Lasallecms\Lasallecmsadmin\FormProcessing\BaseFormProcessing;

/*
 * Process a deletion.
 *
 * FYI: BaseFormProcessing implements the FormProcessing interface.
 */
class DeleteCategoryFormProcessing extends BaseFormProcessing
{
    /*
     * Instance of repository
     *
     * @var Lasallecms\Lasallecmsapi\Repositories\BaseRepository
     */
    protected $repository;


    ///////////////////////////////////////////////////////////////////
    /// SPECIFY THE TYPE OF PERSIST THAT IS GOING ON HERE:          ///
    ///  * "create"  for INSERT                                     ///
    ///  * "update   for UPDATE                                     ///
    ///  * "destroy" for DELETE                                     ///
    ///////////////////////////////////////////////////////////////////
    /*
     * Type of persist
     *
     * @var string
     */
    protected $type = "destroy";

    ///////////////////////////////////////////////////////////////////
    /// SPECIFY THE FULL NAMESPACE AND CLASS NAME OF THE MODEL      ///
    ///////////////////////////////////////////////////////////////////
    /*
     * Namespace and class name of the model
     *
     * @var string
     */
    protected $namespaceClassnameModel = "Lasallecms\Lasallecmsapi\Models\Category";


    ///////////////////////////////////////////////////////////////////
    ///   USUALLY THERE IS NOTHING ELSE TO MODIFY FROM HERE ON IN   ///
    ///////////////////////////////////////////////////////////////////


    /*
     * Inject the model
     *
     * @param  Lasallecms\Lasallecmsapi\Repositories\BaseRepository
     */
    public function __construct(CategoryRepository $repository) {
        $this->repository = $repository;

        //$this->repository->injectModelIntoRepository($this->namespaceClassnameModel);
    }


    /*
     * The processing steps.
     *
     * @param  The command bus object   $deletePostCommand
     * @return The custom response array
     */
    public function quarterback($id) {

        // Foreign Key check
        // foreignKeyConstraintTest() returns "true" or "false"
        if (!$this->repository->foreignKeyConstraintTest($id))
        {
            // Prepare the response array, and then return to the index with error messages
            return $this->prepareResponseArray("foreign_key_check_failed", 500, $id);
        }

        // DELETE record
        //if (!$this->persist($id, $this->type))
        if (!$this->repository->getDestroy($id))
        {
            // Prepare the response array, and then return to the edit form with error messages
            // Laravel's https://github.com/laravel/framework/blob/5.0/src/Illuminate/Database/Eloquent/Model.php
            //  does not prepare a MessageBag object, so we'll whip up an error message in the
            //  originating controller
            return $this->prepareResponseArray('persist_failed', 500, $id);
        }

        // Prepare the response array, and then return to the command
        return $this->prepareResponseArray('create_successful', 200, $id);
    }
}