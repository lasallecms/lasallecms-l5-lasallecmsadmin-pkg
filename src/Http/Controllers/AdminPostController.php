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

use Lasallecms\Lasallecmsapi\Contracts\CategoryRepository;
use Lasallecms\Lasallecmsapi\Contracts\PostRepository;
use Lasallecms\Lasallecmsapi\Contracts\TagRepository;
use Lasallecms\Helpers\Dates\DatesHelper;
use Lasallecms\Helpers\HTML\HTMLHelper;

use Lasallecms\Lasallecmsadmin\Commands\Posts\CreatePostCommand;
use Lasallecms\Lasallecmsadmin\Commands\Posts\DeletePostCommand;
use Lasallecms\Lasallecmsadmin\Commands\Posts\UpdatePostCommand;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Form;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;


/*
 * Resource controller for administration of posts
 */
class AdminPostController extends Controller {

    /*
     * Repository
     *
     * @var  Lasallecms\Lasallecmsapi\Contracts\PostRepository
     */
    protected $repository;

    /*
     * CategoryRepository
     *
     * @var Lasallecms\Lasallecmsapi\Contracts\CategoryRepository
     */
    protected $categoryRepository;

    /*
     * CategoryRepository
     *
     * @var Lasallecms\Lasallecmsapi\Contracts\TagRepository
     */
    protected $tagRepository;


    /*
     * Create a new repository instance
     *
     * @param  Lasallecms\Lasallecmsapi\Contracts\PostRepository $postRepository
     * @return void
     */
    public function __construct(
        PostRepository $postRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository
    )
    {
        $this->repository = $postRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
    }




    /**
     * Display a listing of posts
     * GET /posts/index
     *
     * @return Response
     */
    public function index() {

        // If this user has locked records for this table, then unlock 'em
        $this->repository->unlockMyRecords('posts');

        $posts = $this->repository->allPostsForDisplayOnAdminListing();

        return view('lasallecmsadmin::'.config('lasallecmsadmin.admin_template_name').'/posts/index',[
            'pagetitle' => 'Posts',
            'Form' => Form::class,
            'DatesHelper' => DatesHelper::class,
            'HTMLHelper'  => HTMLHelper::class,
            'posts' => $posts,
            'postRepository' => $this->repository,
        ]);
    }

    /**
     * Form to create a new post
     * GET /posts/create
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->getAll();
        $tags       = $this->tagRepository ->getAll();

        return view('lasallecmsadmin::'.config('lasallecmsadmin.admin_template_name').'/posts/create',[
            'pagetitle'   => 'Posts',
            'DatesHelper' => DatesHelper::class,
            'Form'        => Form::class,
            'HTMLHelper'  => HTMLHelper::class,
            'tags'        => $tags,
            'categories'  => $categories,
            'carbon'      => Carbon::class,
        ]);
    }


    /**
     * Store a newly created resource in storage
     * POST admin/posts/create
     *
     * @param  Request   $request
     * @return Response
     */
    public function store(Request $request) {

        $response = $this->dispatchFrom(CreatePostCommand::class, $request);

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
            $message = "Persist failed. It does not happen often, but Laravel's save failed. The database operation is called at Lasallecms\Lasallecmsapi\Posts\CreatePostFormProcessing. MySQL probably hiccupped, so probably just try again.";
            Session::flash('message', $message);

            // Return to the edit form with error messages
            return Redirect::back()
                ->withInput($response['data']);
        }

        $title = strtoupper($response['data']['title']);
        $message = 'You successfully created the post "'.$title.'"!';
        Session::flash('message', $message);
        return Redirect::route('admin.posts.index');
    }


    /**
     * Display the specified post
     * GET /posts/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        // Do not use show(). Redir to index just in case
        return Redirect::route('admin.posts.index');
    }




    /**
     * Show the form for editing a specific post
     * GET /posts/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        // Is this record locked?
        if ($this->repository->isLocked($id))
        {
            $response = 'This post is not available for editing, as someone else is currently editing this post';
            Session::flash('message', $response);
            Session::flash('status_code', 400 );
            return Redirect::route('admin.posts.index');
        }

        // Lock the record
        $this->repository->populateLockFields($id);

        $categories = $this->categoryRepository->getAll();
        $tags       = $this->tagRepository ->getAll();

        return view('lasallecmsadmin::'.config('lasallecmsadmin.admin_template_name').'/posts/create',[
            'pagetitle'   => 'Posts',
            'DatesHelper' => DatesHelper::class,
            'Form'        => Form::class,
            'HTMLHelper'  => HTMLHelper::class,
            'post'         => $this->repository->getFind($id),
            'tags'        => $tags,
            'categories'  => $categories,
            'postRepository' => $this->repository,
        ]);
    }

    /**
     * Update the specific post in the db
     * PUT /posts/{id}
     *
     * @param  Request   $request
     * @return Response
     */
    public function update(Request $request)
    {
        $response = $this->dispatchFrom(UpdatePostCommand::class, $request);

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
            $message = "Persist failed. It does not happen often, but Laravel's save failed. The database operation is called at Lasallecms\Lasallecmsapi\Posts\UpdatePostFormProcessing. MySQL probably hiccupped, so probably just try again.";
            Session::flash('message', $message);

            // Return to the edit form with error messages
            return Redirect::back()
                ->withInput($response['data']);
        }


        $title = strtoupper($response['data']['title']);
        $message = 'Your "'.$title.'" post updated successfully!';
        Session::flash('message', $message);
        return Redirect::route('admin.posts.index');
    }

    /**
     * Remove the specific post from the db
     * DELETE /posts/{id}
     *
     * This method is not routed through a REQUEST, unfortunately. So,
     * using a post collection as the array access-ible object. Remember,
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
            $response = 'This post is not available for deletion, as someone else is currently editing this post';
            Session::flash('message', $response);
            Session::flash('status_code', 400 );
            return Redirect::route('admin.posts.index');
        }

        $post = $this->repository->getFind($id);

        $response = $this->dispatch(new DeletePostCommand($post));

        Session::flash('status_code', $response['status_code'] );


        if ($response['status_text'] == "foreign_key_check_failed")
        {
            $message = "Cannot delete this post because one or more posts are currently using this post, ";
            Session::flash('message', $message);

            // Return to the edit form with error messages
            return Redirect::back()
                ->withInput($response['data']);
        }


        if ($response['status_text'] == "persist_failed")
        {
            $message = "Persist failed. It does not happen often, but Laravel's deletion failed. The database operation is called at Lasallecms\Lasallecmsapi\Posts\DeletePostFormProcessing. MySQL probably hiccupped, so probably just try again.";
            Session::flash('message', $message);

            // Return to the edit form with error messages
            return Redirect::back()
                ->withInput($response['data']);
        }



        $title = strtoupper($response['data']['id']->title);
        $message = 'You successfully deleted the post "'.$title.'"!';
        Session::flash('message', $message);
        return Redirect::route('admin.posts.index');

    }
}