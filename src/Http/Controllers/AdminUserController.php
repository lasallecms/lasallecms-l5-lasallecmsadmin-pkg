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



// LaSalle Software
use Lasallecms\Formhandling\AdminFormhandling\AdminFormBaseController;
use Lasallecms\Lasallecmsapi\Repositories\UserRepository;

use Lasallecms\Lasallecmsadmin\Commands\Users\CreateUserCommand;
use Lasallecms\Lasallecmsadmin\Commands\Users\DeleteUserCommand;
use Lasallecms\Lasallecmsadmin\Commands\Users\UpdateUserCommand;

use Lasallecms\Helpers\Dates\DatesHelper;
use Lasallecms\Helpers\HTML\HTMLHelper;

// Laravel facades
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Form;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

// Laravel classes
use Illuminate\Http\Request;

// Third party classes
use Carbon\Carbon;


/*
 * Resource controller for administration of users
 */
class AdminUserController extends AdminFormBaseController
{
    /*
     * Repository
     *
     * @var  Lasallecms\Lasallecmsapi\Contracts\UserRepository
     */
    protected $repository;



    /*
     * Create a new repository instance
     *
     * @param  Lasallecms\Lasallecmsapi\Contracts\UserRepository $UserRepository
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        // execute AdminController's construct method first in order to run the middleware
        parent::__construct() ;

        $this->repository = $repository;
    }




    /**
     * Display a listing of users
     * GET /users/index
     *
     * @return Response
     */
    public function index()
    {
        // If this user has locked records for this table, then unlock 'em
        $this->repository->unlockMyRecords('users');

        if (! $this->repository->isFirstAmongEqualsUserInDatabase())
        {
            Session::flash('status_code', 400 );

            $message = 'The user you specified as the "First Amongst Equals" in the auth config is not in the database (the Users table). Please ensure that you specify such user in the auth config (in my User Management package); and, that this user is set up.';

            Session::flash('message',$message);
        }


        $users = $this->repository->getAll();

        return view('lasallecmsadmin::'.config('lasallecmsadmin.admin_template_name').'/users/index',[
            'Form' => Form::class,
            'pagetitle' => 'Users',
            'users' => $users,
            'config' => Config::class,
            'auth' => Auth::class,
            'HTMLHelper'  => HTMLHelper::class,
        ]);
    }


    /**
     * Form to create a new user
     * GET /users/create
     *
     * @return Response
     */
    public function create()
    {
        return view('lasallecmsadmin::'.config('lasallecmsadmin.admin_template_name').'/users/create',[
            'pagetitle'   => 'Users',
            'DatesHelper' => DatesHelper::class,
            'Form'        => Form::class,
            'HTMLHelper'  => HTMLHelper::class,
        ]);
    }


    /**
     * Store a newly created resource in storage
     * POST admin/users/create
     *
     * @param  Request   $request
     * @return Response
     */
    public function store(Request $request)
    {
        $response = $this->dispatchFrom(CreateUserCommand::class, $request);

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
            $message = "Persist failed. It does not happen often, but Laravel's save failed. The database operation is called at Lasallecms\Lasallecmsapi\Users\CreateUserFormProcessing. MySQL probably hiccupped, so probably just try again.";
            Session::flash('message', $message);

            // Return to the edit form with error messages
            return Redirect::back()
                ->withInput($response['data']);
        }

        $name = strtoupper($response['data']['name']);
        $message = 'You successfully created the user "'.$name.'"!';
        Session::flash('message', $message);
        return Redirect::route('admin.users.index');
    }


    /**
     * Display the specified user
     * GET /users/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        // Do not use show(). Redir to index just in case
        return Redirect::route('admin.users.index');
    }


    /**
     * Show the form for editing a specific user
     * GET /users/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        // Is this record locked?
        if ($this->repository->isLocked($id))
        {
            $response = 'This user is not available for editing, as someone else is currently editing this user';
            Session::flash('message', $response);
            Session::flash('status_code', 400 );
            return Redirect::route('admin.users.index');
        }


        // My custom helpful HELPER method "adminPageSubTitle()" displays the "title" field of a record.
        // There is no such "title" field in the users table. So, let's pretend, to make my helpful helper method happy!
        $user = $this->repository->getFind($id);
        $user->title = $user->name;

        // Lock the record
        $this->repository->populateLockFields($id);

        return view('lasallecmsadmin::'.config('lasallecmsadmin.admin_template_name').'/users/create',[
            'pagetitle'   => 'Users',
            'DatesHelper' => DatesHelper::class,
            'Form'        => Form::class,
            'HTMLHelper'  => HTMLHelper::class,
            'user'         => $user,
        ]);
    }


    /**
     * Update the specific user in the db
     * PUT /users/{id}
     *
     * @param  Request   $request
     * @return Response
     */
    public function update(Request $request)
    {
        $response = $this->dispatchFrom(UpdateUserCommand::class, $request);

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
            $message = "Persist failed. It does not happen often, but Laravel's save failed. The database operation is called at Lasallecms\Lasallecmsapi\Users\UpdateUserFormProcessing. MySQL probably hiccupped, so probably just try again.";
            Session::flash('message', $message);

            // Return to the edit form with error messages
            return Redirect::back()
                ->withInput($response['data']);
        }


        $name = strtoupper($response['data']['name']);
        $message = 'Your "'.$name.'" user updated successfully!';
        Session::flash('message', $message);
        return Redirect::route('admin.users.index');
    }


    /**
     * Remove the specific user from the db
     * DELETE /users/{id}
     *
     * This method is not routed through a REQUEST, unfortunately. So,
     * using a user collection as the array access-ible object. Remember,
     * Laravel's command bus needs an array access-ible object!
     * Also, note using $this->dispatch(), not $this->dispatchFrom().
     *
     * @param  int      $id
     * @return Response
     */
    public function destroy($id)
    {
        // Is this record locked?
        if ($this->repository->isLocked($id))
        {
            $response = 'This user is not available for deletion, as someone else is currently editing this user';
            Session::flash('message', $response);
            Session::flash('status_code', 400 );
            return Redirect::route('admin.users.index');
        }

        $user = $this->repository->getFind($id);

        $response = $this->dispatch(new DeleteUserCommand($user));

        Session::flash('status_code', $response['status_code'] );

        if (strpos("This user cannot be deleted", $response['status_text']))
        {
            $message = $response['status_text'];
            Session::flash('message', $message);

            // Return to the index listing with error messages
            return Redirect::route('admin.users.index');
        }


        if ($response['status_text'] == "persist_failed")
        {
            $message = "Persist failed. It does not happen often, but Laravel's deletion failed. The database operation is called at Lasallecms\Lasallecmsapi\Users\DeleteUserFormProcessing. MySQL probably hiccupped, so probably just try again.";
            Session::flash('message', $message);

            // Return to the index listing with error messages
            return Redirect::route('admin.users.index');
        }

        $name = strtoupper($user->name);
        $message = 'You successfully deleted the user "'.$name.'"!';
        Session::flash('message', $message);
        return Redirect::route('admin.users.index');
    }
}