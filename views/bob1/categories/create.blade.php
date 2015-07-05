@extends('lasallecmsadmin::bob1.layouts.default')

@section('content')

    <!-- Main content -->
    <section class="content">

        <div class="container">



            {{-- form's title --}}
            <div class="row">
                {!! $HTMLHelper::adminPageTitle('LaSalleCMS', 'Categories', '') !!}

                @if ( isset($category) )
                    {!! $HTMLHelper::adminPageSubTitle($category, 'Category') !!}
                @else
                    {!! $HTMLHelper::adminPageSubTitle(null, 'Category') !!}
                @endif
            </div> <!-- row -->

            <br /><br />



            <div class="row">

                @include('lasallecmsadmin::bob1.partials.message')

                <div class="col-md-3"></div>

                <div class="col-md-6">

                    {{-- this is a combo create or edit form. Display the proper "form action"  --}}
                    @if ( isset($category) )
                        {!! Form::model($category, array('route' => array('admin.categories.update', $category->id), 'method' => 'PUT')) !!}

                        {!! Form::hidden('id', $category->id) !!}
                    @else
                        {!! Form::open(['route' => 'admin.categories.store']) !!}
                    @endif

                    {{-- the table! --}}
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <tr>
                            <td>
                                {!! Form::label('name', 'Category\'s Name: ') !!}
                            </td>
                            <td>
                                @if ( isset($category) )
                                    {{--
                                      After trying to get $options array to work and failing, I am just using plain ol' html.
                                      Hacked Illuminate\Html\FormBuilder.php's input() method successfully, but can't seem
                                      to pass it the proper $options field. Oh well.
                                     --}}
                                    {{{ $category->title }}}
                                    <br />
                                    {!! Form::hidden('title', $category->title) !!}
                                @else
                                    {!! Form::input('text', 'title', Input::old('title', isset($category) ? $category->title : '')) !!}

                                    &nbsp;&nbsp; <a tabindex="0" data-toggle="popover" data-trigger="focus" data-content="Name must be unique."><i class="fa fa-info-circle"></i> </a>
                                    {{{ $errors->first('title', '<span class="help-block">:message</span>') }}}
                                @endif

                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('content', 'Content: ') !!}
                            </td>
                            <td>
                                <textarea name="content" id="content">
                                    {!! Input::old('content', isset($category) ? $category->content : '')  !!}
                                </textarea>

                                <script type="text/javascript" src="{{{ Config::get('app.url') }}}/{{{ Config::get('lasallecms.public_folder') }}}/packages/lasallecmsadmin/bob1/ckeditor/ckeditor.js"></script>

                                {!! "<script>CKEDITOR.replace('content');</script>" !!}


                                &nbsp;&nbsp; <a tabindex="0" data-toggle="popover" data-trigger="focus" data-content="Displays on the site. Optional."><i class="fa fa-info-circle"></i> </a>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('description', 'Description: ') !!}
                            </td>
                            <td>
                                <textarea name="description" id="description">{!! Input::old('description', isset($category) ? $category->description : '')  !!}</textarea>

                                &nbsp;&nbsp; <a tabindex="0" data-toggle="popover" data-trigger="focus" data-content="Description for this form. Does not display on the site. Optional."><i class="fa fa-info-circle"></i> </a>

                                {{{ $errors->first('description', '<span class="help-block">:message</span>') }}}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('featured_image', 'Featured Image: ') !!}
                            </td>
                            <td>
                                {!! Form::input('text', 'featured_image', Input::old('featured_image', isset($category) ? $category->featured_image : '')) !!}
                            </td>
                        </tr>


                        <tr>
                            <td>
                                {!! Form::label('parent_id', 'Parent Category: ') !!}
                            </td>
                            <td>
                                @if ( isset($category) )
                                    {!! $HTMLHelper::categoryParentSingleSelectEdit($categories, $category->parent_id, $category->id) !!}
                                @else
                                    {!! $HTMLHelper::categoryParentSingleSelectCreate($categories) !!}
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('enabled', 'Enabled: ') !!}
                            </td>
                            <td>
                                @if ( isset($category) )
                                    {!! Form::checkbox('enabled', '1', Input::old('enabled',  $category->enabled)) !!}
                                @else
                                    {!! Form::checkbox('enabled', '1', Input::old('enabled')) !!}
                                @endif
                            </td>
                        </tr>


                        @if ( isset($category) )
                            <tr>
                                <td>
                                    {!! Form::label('created at', 'Created At: ') !!}
                                </td>
                                <td>
                                    {{{ $DatesHelper::convertDatetoFormattedDateString($category->created_at) }}}

                                    &nbsp;&nbsp; <a tabindex="0" data-toggle="popover" data-trigger="focus" data-content="The Created At date is automatically filled in."><i class="fa fa-info-circle"></i> </a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    {!! Form::label('updated at', 'Updated At: ') !!}
                                </td>
                                <td>
                                    {{{ $DatesHelper::convertDatetoFormattedDateString($category->updated_at) }}}

                                    &nbsp;&nbsp; <a tabindex="0" data-toggle="popover" data-trigger="focus" data-content="The Updated At date is automatically filled in."><i class="fa fa-info-circle"></i> </a>
                                </td>
                            </tr>
                        @endif


                        <tr>
                            <td>

                            </td>
                            <td>

                                {{-- Hidden fields --}}
                                <input name="field_list" type="hidden" value="{{{ json_encode($field_list) }}}">
                                <input name="namespace_formprocessor" type="hidden" value="{{{ $namespace_formprocessor  }}}">

                                @if ( isset($category) )
                                    <input name="classname_formprocessor_update" type="hidden" value="{{{ $classname_formprocessor_update }}}">
                                @else
                                     <input name="classname_formprocessor_create" type="hidden" value="{{{ $classname_formprocessor_create }}}">
                                @endif

                                <input name="crud_action" type="hidden" value="create">


                                @if ( isset($category) )
                                    {!! Form::submit( 'Edit Category!') !!}
                                @else
                                    {!! Form::submit( 'Create Category!') !!}
                                @endif

                                {!! $HTMLHelper::back_button('Cancel') !!}



                            </td>
                        </tr>

                    </table>

                    {!! Form::close() !!}


                </div> <!-- col-md-6 -->

                <div class="col-md-3"></div>

            </div> <!-- row -->


        </div> <!-- container -->

    </section>
@stop