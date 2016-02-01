<?php

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



$router->get('admin',[
    'as' => 'admin.home',
    'uses' => 'AdminDashboardController@index'
]);


Route::group(array('prefix' => 'admin'), function()
{
    Route::resource('posts', 'AdminPostController');
    Route::post('posts/confirmDeletion/{id}', 'AdminPostController@confirmDeletion');
    Route::post('posts/confirmDeletionMultipleRows', 'AdminPostController@confirmDeletionMultipleRows');
    Route::post('posts/destroyMultipleRecords', 'AdminPostController@destroyMultipleRecords');

    Route::resource('categories', 'AdminCategoryController');
    Route::post('categories/confirmDeletion/{id}', 'AdminCategoryController@confirmDeletion');
    Route::post('categories/confirmDeletionMultipleRows', 'AdminCategoryController@confirmDeletionMultipleRows');
    Route::post('categories/destroyMultipleRecords', 'AdminCategoryController@destroyMultipleRecords');

    Route::resource('tags', 'AdminTagController');
    Route::post('tags/confirmDeletion/{id}', 'AdminTagController@confirmDeletion');
    Route::post('tags/confirmDeletionMultipleRows', 'AdminTagController@confirmDeletionMultipleRows');
    Route::post('tags/destroyMultipleRecords', 'AdminTagController@destroyMultipleRecords');

    Route::resource('postupdates', 'AdminPostupdateController');
    Route::post('postupdates/confirmDeletion/{id}', 'AdminPostupdateController@confirmDeletion');
    Route::post('postupdates/confirmDeletionMultipleRows', 'AdminPostupdateController@confirmDeletionMultipleRows');
    Route::post('postupdates/destroyMultipleRecords', 'AdminPostupdateController@destroyMultipleRecords');

    Route::resource('users', 'AdminUserController');
    Route::post('users/confirmDeletion/{id}', 'AdminUserController@confirmDeletion');
    Route::post('users/confirmDeletionMultipleRows', 'AdminUserController@confirmDeletionMultipleRows');
    Route::post('users/destroyMultipleRecords', 'AdminUserController@destroyMultipleRecords');

    Route::resource('usergroups', 'AdminUsergroupController');
    Route::post('usergroups/confirmDeletion/{id}', 'AdminUsergroupController@confirmDeletion');
    Route::post('usergroups/confirmDeletionMultipleRows', 'AdminUsergroupController@confirmDeletionMultipleRows');
    Route::post('usergroups/destroyMultipleRecords', 'AdminUsergroupController@destroyMultipleRecords');
});

