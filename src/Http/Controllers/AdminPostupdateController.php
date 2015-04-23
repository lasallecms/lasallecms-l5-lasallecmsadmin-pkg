<?php namespace Lasallecms\Lasallecmsadmin\Http\Controllers;

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

use Illuminate\Http\Request;

use Lasallecms\Lasallecmsapi\Contracts\PostupdateRepository;
use Lasallecms\Helpers\Dates\DatesHelper;
use Lasallecms\Helpers\HTML\HTMLHelper;

use Lasallecms\Lasallecmsadmin\Commands\Postupdates\CreatePostupdateCommand;
use Lasallecms\Lasallecmsadmin\Commands\Postupdates\DeletePostupdateCommand;
use Lasallecms\Lasallecmsadmin\Commands\Postupdates\UpdatePostupdateCommand;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Form;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;


/*
 * Resource controller for administration of post updates
 */
class AdminPostupdateController extends AdminController {

    /*
     * Repository
     *
     * @var  Lasallecms\Lasallecmsapi\Contracts\PostupdateRepository
     */
    protected $repository;



    /*
     * Create a new repository instance
     *
     * @param  Lasallecms\Lasallecmsapi\Contracts\PostupdateRepository $postupdateRepository
     * @return void
     */
    public function __construct(PostupdateRepository $postupdateRepository)
    {
        // execute AdminController's construct method first in order to run the middleware
        parent::__construct() ;

        $this->repository = $postupdateRepository;
    }




    /**
     * Display a listing of post updates
     * GET /postupdates/index
     *
     * @return Response
     */
    public function index() {

        // If this user has locked records for this table, then unlock 'em
        $this->repository->unlockMyRecords('postupdates');


        $postupdates = $this->repository->getAll();

        return view('lasallecmsadmin::'.config('lasallecmsadmin.admin_template_name').'/postupdates/index',[
            'pagetitle' => 'Post Updates',
            'DatesHelper' => DatesHelper::class,
            'HTMLHelper'  => HTMLHelper::class,
            'postupdates' => $postupdates,
            'postRepository' => $this->repository,
        ]);
    }

    /**
     * Form to create a new post update
     * GET /postupdates/create
     *
     * @return Response
     */
    public function create()
    {
        // Look, right now, the way it works, is you need to supply the ID of post this update pertains.
        // No POST ID, no create!
        $post_id = Input::get('post_id');

        if ( (int) $post_id < 1 )
        {
            // flash message with redirect
            Session::flash('status_code', 400 );
            $message = 'Please initiate the creation of a new update for your post by clicking the icon ';
            $message .= 'in the row of the post you want to update.';
            Session::flash('message', $message);
            return Redirect::route('admin.posts.index');
        }

        return view('lasallecmsadmin::'.config('lasallecmsadmin.admin_template_name').'/postupdates/create',[
            'pagetitle'   => 'Post Updates',
            'DatesHelper' => DatesHelper::class,
            'Form'        => Form::class,
            'HTMLHelper'  => HTMLHelper::class,
            'post_id'     => $post_id,
        ]);
    }


    /**
     * Store a newly created resource in storage
     * POST admin/postupdates/create
     *
     * @param  Request   $request
     * @return Response
     */
    public function store(Request $request) {
        $response = $this->dispatchFrom(CreatePostupdateCommand::class, $request);

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
            $message = "Persist failed. It does not happen often, but Laravel's save failed. The database operation is called at Lasallecms\Lasallecmsapi\Postupdates\CreatePostupdateFormProcessing. MySQL probably hiccupped, so probably just try again.";
            Session::flash('message', $message);

            // Return to the edit form with error messages
            return Redirect::back()
                ->withInput($response['data']);
        }

        $title = strtoupper($response['data']['title']);
        $message = 'You successfully created the post update "'.$title.'"!';
        Session::flash('message', $message);
        return Redirect::route('admin.postupdates.index');
    }


    /**
     * Display the specified post update
     * GET /postupdates/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        // Do not use show(). Redir to index just in case
        return Redirect::route('admin.postupdates.index');
    }


    /**
     * Show the form for editing a specific post update
     * GET /postupdates/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        // Is this record locked?
        if ($this->repository->isLocked($id))
        {
            $response = 'This post update is not available for editing, as someone else is currently editing this post update';
            Session::flash('message', $response);
            Session::flash('status_code', 400 );
            return Redirect::route('admin.postupdates.index');
        }

        // Lock the record
        $this->repository->populateLockFields($id);

        return view('lasallecmsadmin::'.config('lasallecmsadmin.admin_template_name').'/postupdates/create',[
            'pagetitle'   => 'Post Updates',
            'DatesHelper' => DatesHelper::class,
            'Form'        => Form::class,
            'HTMLHelper'  => HTMLHelper::class,
            'postupdate'  => $this->repository->getFind($id),
        ]);
    }

    /**
     * Update the specific post update in the db
     * PUT /postupdates/{id}
     *
     * @param  Request   $request
     * @return Response
     */
    public function update(Request $request)
    {
        $response = $this->dispatchFrom(UpdatePostupdateCommand::class, $request);

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
            $message = "Persist failed. It does not happen often, but Laravel's save failed. The database operation is called at Lasallecms\Lasallecmsapi\Postupdates\UpdatePostupdateFormProcessing. MySQL probably hiccupped, so probably just try again.";
            Session::flash('message', $message);

            // Return to the edit form with error messages
            return Redirect::back()
                ->withInput($response['data']);
        }


        $title = strtoupper($response['data']['title']);
        $message = 'Your "'.$title.'" post update updated successfully!';
        Session::flash('message', $message);
        return Redirect::route('admin.postupdates.index');
    }

    /**
     * Remove the specific post update from the db
     * DELETE /postupdates/{id}
     *
     * This method is not routed through a REQUEST, unfortunately. So,
     * using a post update collection as the array access-ible object. Remember,
     * Laravel's command bus needs an array access-ible object!
     * Also, note using $this->dispatch(), not $this->dispatchFrom().
     *
     * @param  int      $id
     * @return Response
     */
    public function destroy($id) {

        // Is this record locked?
        if ($this->repository->isLocked($id))
        {
            $response = 'This post update is not available for deletion, as someone else is currently editing this post update';
            Session::flash('message', $response);
            Session::flash('status_code', 400 );
            return Redirect::route('admin.postupdates.index');
        }

        $postupdate = $this->repository->getFind($id);

        $response = $this->dispatch(new DeletePostupdateCommand($postupdate));

        Session::flash('status_code', $response['status_code'] );


        if ($response['status_text'] == "foreign_key_check_failed")
        {
            $message = "Cannot delete this post update because one or more posts are currently using this post update, ";
            Session::flash('message', $message);

            // Return to the edit form with error messages
            return Redirect::back()
                ->withInput($response['data']);
        }


        if ($response['status_text'] == "persist_failed")
        {
            $message = "Persist failed. It does not happen often, but Laravel's deletion failed. The database operation is called at Lasallecms\Lasallecmsapi\Postupdates\DeletePostupdateFormProcessing. MySQL probably hiccupped, so probably just try again.";
            Session::flash('message', $message);

            // Return to the edit form with error messages
            return Redirect::back()
                ->withInput($response['data']);
        }



        $title = strtoupper($response['data']['id']->title);
        $message = 'You successfully deleted the post update "'.$title.'"!';
        Session::flash('message', $message);
        return Redirect::route('admin.postupdates.index');

    }
}