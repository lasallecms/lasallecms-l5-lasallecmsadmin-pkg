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
                            {{{ (isset($category)) ? 'Edit the "'.$category->title.'"' : 'Create' }}} Category
                        </span>
                </h1>
                <br /><br />
            </div> <!-- row -->



            <div class="row">

                @include('lasallecmsadmin::bob1.partials.message')


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
                                    {{{ $category->title }}} &nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="The name is unique, so it is unchange-able."><i class="fa fa-info-circle"></i></a>
                                    <br />
                                    {!! Form::hidden('title', $category->title) !!}
                                @else
                                    {!! Form::input('text', 'title', Input::old('title', isset($category) ? $category->title : '')) !!}
                                    {{{ $errors->first('title', '<span class="help-block">:message</span>') }}}
                                @endif

                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('description', 'Description: ') !!}
                            </td>
                            <td>
                                {!! Form::input('text', 'description', Input::old('description', isset($category) ? $category->description : '')) !!}
                                {{{ $errors->first('description', '<span class="help-block">:message</span>') }}}
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


                        @if ( isset($category) )
                            <tr>
                                <td>
                                    {!! Form::label('created at', 'Created At: ') !!}
                                </td>
                                <td>
                                    {{{ $DatesHelper::convertDatetoFormattedDateString($category->created_at) }}} &nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="The Created At date is automatically filled in."><i class="fa fa-info-circle"></i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    {!! Form::label('updated at', 'Updated At: ') !!}
                                </td>
                                <td>
                                    {{{ $DatesHelper::convertDatetoFormattedDateString($category->updated_at) }}} &nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="The Updated At date is automatically filled in"><i class="fa fa-info-circle"></i></a>
                                </td>
                            </tr>
                        @endif


                        <tr>
                            <td>

                            </td>
                            <td>
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

            </div> <!-- row -->


        </div> <!-- container -->

    </section>
@stop