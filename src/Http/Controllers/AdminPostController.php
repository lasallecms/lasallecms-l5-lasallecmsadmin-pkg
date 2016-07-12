<?php

namespace Lasallecms\Lasallecmsadmin\Http\Controllers;

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

// LaSalle Software
use Lasallecms\Formhandling\AdminFormhandling\AdminFormBaseController;
use Lasallecms\Lasallecmsapi\Repositories\BaseRepository;
use Lasallecms\Lasallecmsapi\Events\PublishThePost;

// Laravel facades
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

// Laravel classes
use Illuminate\Http\Request;



///////////////////////////////////////////////////////////////////
///////     MODIFY THE MODEL NAMESPACE & CLASS "as Model"     /////
///////          THIS IS THE ONLY THING YOU HAVE TO           /////
///////              SPECIFY IN THIS CONTROLLER               /////
///////////////////////////////////////////////////////////////////
use Lasallecms\Lasallecmsapi\Models\Post as Model;


/**
 * Class AdminPostController
 * @package Lasallecms\Lasallecmsadmin\Http\Controllers
 */
class AdminPostController extends AdminFormBaseController
{
    /*
     * @param  Model, as specified above
     * @param  Lasallecms\Lasallecmsapi\Repositories\BaseRepository
     * @return void
     */
    public function __construct(Model $model, BaseRepository $repository) {
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
     * Fire the SendPostToLaSalleCRMemailList event.
     *
     * This method is called from the confirmation view in the LaSalle List Management package.
     *
     * @param   Request $request
     * @return  mixed
     */
    public function publishPostEvent(Request $request) {

        // Laravel's Mail::send second "data" param must be an array, not an object.
        $post                     = $this->model->FindOrFail($request->input('postID'))->toArray();
        $post['listID']           = $request->input('listID');
        $post['eventDescription'] = $request->input('eventDescription');

        event(new PublishThePost($post));

        $message =  "You successfully ".$post['eventDescription']."!";
        Session::flash('message', $message);
        Session::flash('status_code', 200 );

        return Redirect::route('admin.'.$this->model->resource_route_name.'.index');
    }
}