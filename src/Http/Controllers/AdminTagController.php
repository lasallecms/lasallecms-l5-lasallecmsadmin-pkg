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

use Lasallecms\Lasallecmsapi\Contracts\TagRepository;
use Lasallecms\Helpers\Dates\DatesHelper;
use Lasallecms\Helpers\HTML\HTMLHelper;

use Lasallecms\Lasallecmsadmin\Commands\CreateTagCommand;
use Lasallecms\Lasallecmsadmin\Commands\DeleteTagCommand;
use Lasallecms\Lasallecmsadmin\Commands\UpdateTagCommand;

use Carbon\Carbon;
use Config;
use Form;
use Input;
use Session;
use Redirect;


/*
 * Resource controller for administration of tags
 */
class AdminTagController extends Controller {

    /*
     * Repository
     *
     * @var  Lasallecms\Lasallecmsapi\Contracts\TagRepository
     */
    protected $repository;



    /*
     * Create a new repository instance
     *
     * @param  Lasallecms\Lasallecmsapi\Contracts\TagRepository $tagRepository
     * @return void
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->repository = $tagRepository;
    }




    /**
     * Display a listing of tags
     * GET /tags/index
     *
     * @return Response
     */
    public function index() {

        // If this user has locked records for this table, then unlock 'em
        $this->repository->unlockMyRecords('tags');


        $tags = $this->repository->getAll();

        return view('lasallecmsadmin::'.config('lasallecmsadmin.admin_template_name').'/tags/index',[
            'Form' => Form::class,
            'tags' => $tags,
        ]);
    }

    /**
     * Form to create a new tag
     * GET /tags/create
     *
     * @return Response
     */
    public function create()
    {
        return view('lasallecmsadmin::'.config('lasallecmsadmin.admin_template_name').'/tags/create',[
            'pagetitle'   => 'Tags',
            'DatesHelper' => DatesHelper::class,
            'Form'        => Form::class,
            'HTMLHelper'  => HTMLHelper::class,
        ]);
    }


    /**
     * Store a newly created resource in storage
     * POST admin/tags/create
     *
     * @param  Request   $request
     * @return Response
     */
    public function store(Request $request) {
        $response = $this->dispatchFrom(CreateTagCommand::class, $request);

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
            $message = "Persist failed. It does not happen often, but Laravel's save failed. The database operation is called at Lasallecms\Lasallecmsapi\Tags\CreateTagFormProcessing. MySQL probably hiccupped, so probably just try again.";
            Session::flash('message', $message);

            // Return to the edit form with error messages
            return Redirect::back()
                ->withInput($response['data']);
        }





        $title = strtoupper($response['data']['title']);
        $message = 'You successfully created the tag "'.$title.'"!';
        Session::flash('message', $message);
        return Redirect::route('admin.tags.index');
    }


    /**
     * Display the specified category
     * GET /tags/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        // Do not use show(). Redir to index just in case
        return Redirect::route('admin.tags.index');
    }




    /**
     * Show the form for editing a specific category
     * GET /tags/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        // Is this record locked?
        if ($this->repository->isLocked($id))
        {
            $response = 'This tag is not available for editing, as someone else is currently editing this tag';
            Session::flash('message', $response);
            Session::flash('status_code', 400 );
            return Redirect::route('admin.tags.index');
        }

        // Lock the record
        $this->repository->populateLockFields($id);

        return view('lasallecmsadmin::'.config('lasallecmsadmin.admin_template_name').'/tags/create',[
            'pagetitle'   => 'Tags',
            'DatesHelper' => DatesHelper::class,
            'Form'        => Form::class,
            'HTMLHelper'  => HTMLHelper::class,
            'tag'         => $this->repository->getFind($id),
        ]);
    }

    /**
     * Update the specific tag in the db
     * PUT /tags/{id}
     *
     * @param  Request   $request
     * @return Response
     */
    public function update(Request $request)
    {
        $response = $this->dispatchFrom(UpdateTagCommand::class, $request);

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
            $message = "Persist failed. It does not happen often, but Laravel's save failed. The database operation is called at Lasallecms\Lasallecmsapi\Tags\UpdateTagFormProcessing. MySQL probably hiccupped, so probably just try again.";
            Session::flash('message', $message);

            // Return to the edit form with error messages
            return Redirect::back()
                ->withInput($response['data']);
        }


        $title = strtoupper($response['data']['title']);
        $message = 'Your "'.$title.'" tag updated successfully!';
        Session::flash('message', $message);
        return Redirect::route('admin.tags.index');
    }

    /**
     * Remove the specific tag from the db
     * DELETE /tags/{id}
     *
     * This method is not routed through a REQUEST, unfortunately. So,
     * using a tag collection as the array access-ible object. Remember,
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
            $response = 'This tag is not available for deletion, as someone else is currently editing this tag';
            Session::flash('message', $response);
            Session::flash('status_code', 400 );
            return Redirect::route('admin.tags.index');
        }

        $tag = $this->repository->getFind($id);

        $response = $this->dispatch(new DeleteTagCommand($tag));

        Session::flash('status_code', $response['status_code'] );


        if ($response['status_text'] == "foreign_key_check_failed")
        {
            $message = "Cannot delete this tag because one or more posts are currently using this tag, ";
            Session::flash('message', $message);

            // Return to the edit form with error messages
            return Redirect::back()
                ->withInput($response['data']);
        }


        if ($response['status_text'] == "persist_failed")
        {
            $message = "Persist failed. It does not happen often, but Laravel's deletion failed. The database operation is called at Lasallecms\Lasallecmsapi\Tags\DeleteTagFormProcessing. MySQL probably hiccupped, so probably just try again.";
            Session::flash('message', $message);

            // Return to the edit form with error messages
            return Redirect::back()
                ->withInput($response['data']);
        }



        $title = strtoupper($response['data']['id']->title);
        $message = 'You successfully deleted the tag "'.$title.'"!';
        Session::flash('message', $message);
        return Redirect::route('admin.tags.index');

    }
}