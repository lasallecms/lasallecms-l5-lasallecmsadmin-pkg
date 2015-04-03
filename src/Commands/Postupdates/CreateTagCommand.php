<?php namespace Lasallecms\Lasallecmsadmin\Commands\Postupdates;

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

use Illuminate\Contracts\Bus\SelfHandling;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Lasallecms\Lasallecmsapi\Postupdates\CreatePostupdateFormProcessing;

use Lasallecms\Lasallecmsadmin\Commands\Command;


class CreatePostupdateCommand extends Command implements SelfHandling {

    use DispatchesCommands;

    public $post_id;
    public $title;
    public $content;
    public $excerpt;
    public $enabled;
    public $published_on;



    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($post_id, $title, $content, $excerpt, $enabled, $published_on)
    {
        $this->post_id      = $post_id;
        $this->title        = $title;
        $this->content      = $content;
        $this->excerpt      = $excerpt;
        $this->enabled      = $enabled;
        $this->published_on = $published_on;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(CreatePostupdateFormProcessing $createPostupdateFormProcessing)
    {
        return $createPostupdateFormProcessing->quarterback($this);
    }
}