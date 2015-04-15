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
                            {{{ (isset($user)) ? 'Edit '.$user->name : 'Create a New User' }}}
                        </span>
                    </h1>
                    <br /><br />
            </div> <!-- row -->



            <div class="row">

                @include('lasallecmsadmin::bob1.partials.message')


                <div class="col-md-6">

                    {{-- this is a combo create or edit form. Display the proper "form action"  --}}
                    @if ( isset($user) )
                        {!! Form::model($user, array('route' => array('admin.users.update', $user->id), 'method' => 'PUT')) !!}

                        {!! Form::hidden('id', $user->id) !!}
                    @else
                        {!! Form::open(['route' => 'admin.users.store']) !!}
                    @endif

                    {{-- the table! --}}
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <tr>
                            <td>
                                {!! Form::label('name', 'User\'s Name: ') !!}
                            </td>
                            <td>
                                {!! Form::input('text', 'name', Input::old('name', isset($user) ? $user->name : '')) !!}
                                {{{ $errors->first('name', '<span class="help-block">:message</span>') }}}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('email', 'Email: ') !!}
                            </td>
                            <td>
                                {!! Form::email('email', Input::old('email', isset($user) ? $user->email : '')) !!}&nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="Email must be unique."><i class="fa fa-info-circle"></i></a>
                                {{{ $errors->first('email', '<span class="help-block">:message</span>') }}}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('password', 'Password: ') !!}
                            </td>
                            <td>
                                {!! Form::password('password') !!}&nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="The At least six characters."><i class="fa fa-info-circle"></i></a>
                                {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('password_confirmation', 'Confirm Password: ') !!}
                            </td>
                            <td>
                                {!! Form::password('password_confirmation') !!}
                                {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('activated', 'Activated: ') !!}
                            </td>
                            <td>
                                {!! Form::checkbox('activated', '1', Input::old('activated')) !!}
                                {{{ $errors->first('activated', '<span class="help-block">:message</span>') }}}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('enabled', 'Enabled: ') !!}
                            </td>
                            <td>
                                {!! Form::checkbox('enabled', '1', Input::old('enabled')) !!}
                                {{{ $errors->first('enabled', '<span class="help-block">:message</span>') }}}
                            </td>
                        </tr>


                        @if ( isset($user) )
                            <tr>
                                <td>
                                    {!! Form::label('created at', 'Created At: ') !!}
                                </td>
                                <td>
                                    {{{ $DatesHelper::convertDatetoFormattedDateString($user->created_at) }}} &nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="The Created At date is automatically filled in."><i class="fa fa-info-circle"></i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    {!! Form::label('updated at', 'Updated At: ') !!}
                                </td>
                                <td>
                                    {{{ $DatesHelper::convertDatetoFormattedDateString($user->updated_at) }}} &nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="The Updated At date is automatically filled in"><i class="fa fa-info-circle"></i></a>
                                </td>
                            </tr>
                        @endif


                        <tr>
                            <td>

                            </td>
                            <td>
                                @if ( isset($user) )
                                    {!! Form::submit( 'Edit User!') !!}
                                @else
                                    {!! Form::submit( 'Create User!') !!}
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