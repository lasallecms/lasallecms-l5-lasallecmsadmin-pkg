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
                            {{{ (isset($tag)) ? 'Edit the "'.$tag->title.'"' : 'Create' }}} Tag
                        </span>
                    </h1>
                    <br /><br />
            </div> <!-- row -->



            <div class="row">

                @include('lasallecmsadmin::bob1.partials.message')


                <div class="col-md-6">

                    {{-- this is a combo create or edit form. Display the proper "form action"  --}}
                    @if ( isset($tag) )
                        {!! Form::model($tag, array('route' => array('admin.tags.update', $tag->id), 'method' => 'PUT')) !!}

                        {!! Form::hidden('id', $tag->id) !!}
                    @else
                        {!! Form::open(['route' => 'admin.tags.store']) !!}
                    @endif

                    {{-- the table! --}}
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <tr>
                            <td>
                                {!! Form::label('name', 'Tag\'s Name: ') !!}
                            </td>
                            <td>
                                @if ( isset($tag) )
                                    {{--
                                      After trying to get $options array to work and failing, I am just using plain ol' html.
                                      Hacked Illuminate\Html\FormBuilder.php's input() method successfully, but can't seem
                                      to pass it the proper $options field. Oh well.
                                     --}}
                                    {{{ $tag->title }}} &nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="The name is unique, so it is unchange-able."><i class="fa fa-info-circle"></i></a>
                                    <br />
                                    {!! Form::hidden('title', $tag->title) !!}
                                @else
                                    {!! Form::input('text', 'title', Input::old('title', isset($tag) ? $tag->title : '')) !!}
                                    {{{ $errors->first('title', '<span class="help-block">:message</span>') }}}
                                @endif

                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('description', 'Description: ') !!}
                            </td>
                            <td>
                                {!! Form::input('text', 'description', Input::old('description', isset($tag) ? $tag->description : '')) !!}
                                {{{ $errors->first('description', '<span class="help-block">:message</span>') }}}
                            </td>
                        </tr>


                        @if ( isset($tag) )
                            <tr>
                                <td>
                                    {!! Form::label('created at', 'Created At: ') !!}
                                </td>
                                <td>
                                    {{{ $DatesHelper::convertDatetoFormattedDateString($tag->created_at) }}} &nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="The Created At date is automatically filled in."><i class="fa fa-info-circle"></i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    {!! Form::label('updated at', 'Updated At: ') !!}
                                </td>
                                <td>
                                    {{{ $DatesHelper::convertDatetoFormattedDateString($tag->updated_at) }}} &nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="The Updated At date is automatically filled in"><i class="fa fa-info-circle"></i></a>
                                </td>
                            </tr>
                        @endif


                        <tr>
                            <td>

                            </td>
                            <td>
                                @if ( isset($tag) )
                                    {!! Form::submit( 'Edit Tag!') !!}
                                @else
                                    {!! Form::submit( 'Create Tag!') !!}
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