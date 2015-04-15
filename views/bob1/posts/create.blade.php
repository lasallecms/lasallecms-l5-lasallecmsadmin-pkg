@extends('lasallecmsadmin::bob1.layouts.default')

@section('content')
    <!-- Main content -->
    <section class="content">

        <div class="container">

            {{-- form's title --}}
            <div class="row">
                <br /><br />
                    <h1>
                        <span class="label label-info">
                            {{{ (isset($post)) ? 'Edit the "'.$post->title.'"' : 'Create' }}} Post
                        </span>
                    </h1>
                    <br /><br />
            </div> <!-- row -->



            <div class="row">

                @include('lasallecmsadmin::bob1.partials.message')


                <div class="col-md-12">

                    {{-- this is a combo create or edit form. Display the proper "form action"  --}}
                    @if ( isset($post) )
                        {!! Form::model($post, array('route' => array('admin.posts.update', $post->id), 'method' => 'PUT')) !!}

                        {!! Form::hidden('id', $post->id) !!}
                    @else
                        {!! Form::open(['route' => 'admin.posts.store']) !!}
                    @endif

                    {{-- the table! --}}
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <tr>
                            <td>
                                {!! Form::label('name', 'Post\'s Title: ') !!}
                            </td>
                            <td>
                                {!! Form::input('text', 'title', Input::old('title', isset($post) ? $post->title : '')) !!}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('slug', 'Slug: ') !!}
                            </td>
                            <td>
                                {!! Form::input('text', 'slug', Input::old('slug', isset($post) ? $post->slug : '')) !!}&nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="No spaces! A unique slug will be generated automatically when left blank."><i class="fa fa-info-circle"></i></a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('content', 'Content: ') !!}
                            </td>
                            <td>
                                <textarea name="content" id="content1">
                                    {!! Input::old('content', isset($post) ? $post->content : '')  !!}
                                </textarea>

                                <script type="text/javascript" src="{{{ Config::get('app.url') }}}/{{{ Config::get('lasallecms.public_folder') }}}/packages/lasallecmsadmin/bob1/ckeditor/ckeditor.js"></script>

                                <script>CKEDITOR.replace('content');</script>
                            </td>
                        </tr>


                        <tr>
                            <td>
                                {!! Form::label('excerpt', 'Excerpt: ') !!}
                            </td>
                            <td>
                                <textarea name="excerpt" id="excerpt">{!! Input::old('excerpt', isset($post) ? $post->excerpt : '')  !!}</textarea>&nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="Teaser text displayed on your site's post listing. You can leave blank, or hand-craft your excerpt. Note the config settings for excerpts."><i class="fa fa-info-circle"></i></a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('meta_description', 'Meta Description: ') !!}
                            </td>
                            <td>
                                {!! Form::input('text', 'meta_description', Input::old('meta_description', isset($post) ? $post->meta_description : '')) !!}&nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="This is the blurb that displays in Google search results. Excerpt is used when left blank."><i class="fa fa-info-circle"></i></a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('canonical_url', 'Canonical Url: ') !!}
                            </td>
                            <td>
                                {!! Form::input('text', 'canonical_url', Input::old('canonical_url', isset($post) ? $post->canonical_url : '')) !!}&nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="Preferred URL for search engines. Auto created when blank."><i class="fa fa-info-circle"></i></a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('featured_image', 'Featured Image: ') !!}
                            </td>
                            <td>
                                {!! Form::input('text', 'featured_image', Input::old('featured_image', isset($post) ? $post->featured_image : '')) !!}&nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="My ode to WordPress! The one single image that represents this post, displayed in lists, and at top of the post."><i class="fa fa-info-circle"></i></a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('enabled', 'Enabled: ') !!}
                            </td>
                            <td>
                                {!! Form::checkbox('enabled', '1', Input::old('enabled')) !!}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('publish_on', 'Publish On: ') !!}
                            </td>
                            <td>
                                {!! Form::input('date', 'publish_on', Input::old('publish_on', isset($post) ? $post->publish_on : $DatesHelper::todaysDateNoTime()  )) !!}
                            </td>
                        </tr>


                        <tr>
                            <td>
                                {!! Form::label('categories', 'Category: ') !!}
                            </td>
                            <td>
                                @if ( isset($post) )
                                    {!! $HTMLHelper::postCategoryMultipleSelectEdit($categories, $post->id, $postRepository->findCategoriesByPostId($post->id, 'id')) !!}
                                @else
                                    {!! $HTMLHelper::postCategoryMultipleSelectCreate($categories) !!}
                                @endif

                                    <span class="help-block">Category and tags are vastly different. You can even ignore tags altogether. But LaSalleCMS uses categories to group posts in the front-end.</span>

                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('tags', 'Tag: ') !!}
                            </td>
                            <td>
                                @if ( isset($post) )
                                    {!! $HTMLHelper::postTagMultipleSelectEdit($tags, $post->id, $postRepository->findTagsByPostId($post->id, 'id')) !!}

                                @else
                                    {!! $HTMLHelper::postTagMultipleSelectCreate($tags) !!}
                                @endif
                            </td>
                        </tr>


                        @if ( isset($post) )
                            <tr>
                                <td>
                                    {!! Form::label('created at', 'Created At: ') !!}
                                </td>
                                <td>
                                    {{{ $DatesHelper::convertDatetoFormattedDateString($post->created_at) }}} &nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="The Created At date is automatically filled in."><i class="fa fa-info-circle"></i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    {!! Form::label('updated at', 'Updated At: ') !!}
                                </td>
                                <td>
                                    {{{ $DatesHelper::convertDatetoFormattedDateString($post->updated_at) }}} &nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="The Updated At date is automatically filled in"><i class="fa fa-info-circle"></i></a>
                                </td>
                            </tr>
                        @endif


                        <tr>
                            <td>

                            </td>
                            <td>
                                @if ( isset($post) )
                                    {!! Form::submit( 'Edit Post!') !!}
                                @else
                                    {!! Form::submit( 'Create Post!') !!}
                                @endif

                                {!! $HTMLHelper::back_button('Cancel') !!}



                            </td>
                        </tr>

                    </table>

                    {!! Form::close() !!}


                </div> <!-- col-md-6 -->

            </div> <!-- row -->


        </div> <!-- container -->

    </section>
@stop