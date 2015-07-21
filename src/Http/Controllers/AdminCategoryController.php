<?php
namespace Lasallecms\Lasallecmsadmin\Http\Controllers;

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


////////////////////////////////////////////////////////////////////////
//// CATEGORIES IS A LOOKUP TABLE, BUT ACCOMMODATING "PARENT ID"    ////
//// REQUIRES BESPOKE VIEWS, AND A BESPOKE FOREIGN KEY CONSTRAINT   ////
////////////////////////////////////////////////////////////////////////


// LaSalle Software
use Lasallecms\Formhandling\AdminFormhandling\AdminFormBaseController;
use Lasallecms\Lasallecmsapi\Repositories\BaseRepository;
use Lasallecms\Lasallecmsapi\Repositories\CategoryRepository;
use Lasallecms\Helpers\Dates\DatesHelper;
use Lasallecms\Helpers\HTML\HTMLHelper;

use Lasallecms\Formhandling\AdminFormhandling\CreateCommand;
use Lasallecms\Formhandling\AdminFormhandling\UpdateCommand;

// Laravel facades
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

// Laravel classes
use Illuminate\Http\Request;

// Third party classes
use Carbon\Carbon;
use Collective\Html\FormFacade as Form;

///////////////////////////////////////////////////////////////////
///////     MODIFY THE MODEL NAMESPACE & CLASS "as Model"     /////
///////          THIS IS THE ONLY THING YOU HAVE TO           /////
///////              SPECIFY IN THIS CONTROLLER               /////
///////////////////////////////////////////////////////////////////
use Lasallecms\Lasallecmsapi\Models\Category as Model;



/*
 * Resource controller for administration of categories
 */
class AdminCategoryController extends AdminFormBaseController
{

    /*
     * @param  Model, as specified above
     * @param  Lasallecms\Lasallecmsapi\Repositories\BaseRepository
     * @return void
     */
    public function __construct(Model $model, BaseRepository $repository)
    {
        // execute AdminController's construct method first in order to run the middleware
        parent::__construct();

        // Inject the model
        $this->model = $model;

        // Inject repository
        $this->repository = $repository;

        // Inject the relevant model into the repository
        $this->repository->injectModelIntoRepository($this->model->model_namespace."\\".$this->model->model_class);
    }




    /**
     * Display a listing of categories
     * GET /categories/index
     *
     * @return Response
     */
    public function index()
    {
        // If this user has locked records for this table, then unlock 'em
        $this->repository->unlockMyRecords('categories');


        $categories = $this->repository->getAll();

        return view('lasallecmsadmin::'.config('lasallecmsadmin.admin_template_name').'/categories/index',[
            'Form' => Form::class,
            'categories' => $categories,
            'categoryRepository' => $this->repository,
            'HTMLHelper'  => HTMLHelper::class,
        ]);
    }


    /**
     * Form to create a new category
     * GET /categories/create
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->repository->getAll();

        return view('lasallecmsadmin::'.config('lasallecmsadmin.admin_template_name').'/categories/create',[
            'pagetitle'                      => 'Categories',
            'field_list'                     => $this->model->field_list,
            'namespace_formprocessor'        => $this->model->namespace_formprocessor,
            'classname_formprocessor_create' => $this->model->classname_formprocessor_create,
            'DatesHelper'                    => DatesHelper::class,
            'Form'                           => Form::class,
            'HTMLHelper'                     => HTMLHelper::class,
            'categories'                      => $categories,
        ]);
    }


    /**
     * Store a newly created resource in storage
     * POST admin/categories/create
     *
     * @param  Request   $request
     * @return Response
     */
    public function store(Request $request)
    {
        $response = $this->dispatchFrom(CreateCommand::class, $request);

        Session::flash('status_code', $response['status_code'] );

        if ($response['status_text'] == "validation_failed")
        {
            Session::flash('message', $response['errorMessages']->first());

            // Return to the edit form with error messages
            return Redirect::back()
                ->withInput($response['data'])
                ->withErrors($response['errorMessages']);
        }


        if ($response['status_text'] == "persist_failed")
        {
            $message = "Persist failed. It does not happen often, but Laravel's save failed. The database operation is called at Lasallecms\Lasallecmsapi\Categories\CreateCategoryFormProcessing. MySQL probably hiccupped, so probably just try again.";
            Session::flash('message', $message);

            // Return to the edit form with error messages
            return Redirect::back()
                ->withInput($response['data']);
        }

        $title = strtoupper($response['data']['title']);
        $message = 'You successfully created the category "'.$title.'"!';
        Session::flash('message', $message);
        return Redirect::route('admin.categories.index');
    }


    /**
     * Show the form for editing a specific category
     * GET /categories/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        // Is this record locked?
        if ($this->repository->isLocked($id))
        {
            $response = 'This category is not available for editing, as someone else is currently editing this category';
            Session::flash('message', $response);
            Session::flash('status_code', 400 );
            return Redirect::route('admin.categories.index');
        }

        // Lock the record
        $this->repository->populateLockFields($id);

        $categories = $this->repository->getAll();

        return view('lasallecmsadmin::'.config('lasallecmsadmin.admin_template_name').'/categories/create',[
            'pagetitle'                      => 'Categories',
            'field_list'                     => $this->model->field_list,
            'namespace_formprocessor'        => $this->model->namespace_formprocessor,
            'classname_formprocessor_update' => $this->model->classname_formprocessor_update,
            'DatesHelper'                    => DatesHelper::class,
            'DatesHelper'                    => DatesHelper::class,
            'Form'                           => Form::class,
            'HTMLHelper'                     => HTMLHelper::class,
            'category'                       => $this->repository->getFind($id),
            'categories'                     => $categories,
        ]);
    }
}