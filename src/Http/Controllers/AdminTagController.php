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

use Lasallecms\Lasallecmsapi\Models\Tag;
use Lasallecms\Helpers\Dates\DatesHelper;

use Config;
use Form;
use Session;
use Redirect;


class AdminTagController extends Controller {


    /**
     * Display a listing of tags
     * GET /tags/index
     *
     * @return Response
     */
    public function index() {

        $tags = Tag::all();

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
        //
    }


    /**
     * Store a newly created resource in storage
     * POST admin/tags/create
     *
     * @return Response
     */
    public function store() {
        //
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
        $tag = Tag::find($id);

        return view('lasallecmsadmin::'.config('lasallecmsadmin.admin_template_name').'/tags/create',[
            'pagetitle' => 'Tags',
            'DatesHelper' => DatesHelper::class,
            'Form' => Form::class,
            'tag' => $tag
        ]);
    }

    /**
     * Update the specific tag in the db
     * PUT /tags/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $tag = Tag::find($id);

        // Native Laravel flash
        Session::flash('message', 'Successfully edited the"'.$tag->title.'" tag.');
        return Redirect::route('admin.tags.index');
    }

    /**
     * Remove the specific tag from the db
     * DELETE /tags/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }
}