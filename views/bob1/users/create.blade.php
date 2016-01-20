@extends('lasallecmsadmin::bob1.layouts.default')

@section('content')
    <!-- Main content -->
    <section class="content">

        <div class="container">

            {{-- form's title --}}
            <div class="row">
                <br /><br />
                {!! $HTMLHelper::adminPageTitle('LaSalleCMS', 'Users', '') !!}

                @if ( isset($user) )
                    {!! $HTMLHelper::adminPageSubTitle($user, 'User') !!}
                @else
                    {!! $HTMLHelper::adminPageSubTitle(null, 'User') !!}
                @endif
            </div> <!-- row -->

            <br /><br />


            <div class="row">

                @include('lasallecmsadmin::bob1.partials.message')

                <div class="col-md-3"></div>

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
                        <tr><td colspan="2"><hr></td></tr>


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

                        <tr>
                            <td>
                                {!! Form::label($field['name'], $HTMLHelper::adminFormFieldLabel($field) .': ') !!}
                            </td>
                            <td>
                                @if ( isset($user) )
                                    {!! $repository->multipleSelectFromRelatedTableUpdate($field['related_table_name'], $field['related_model_class'], $user->id) !!}
                                @else
                                    {!! $repository->multipleSelectFromRelatedTableCreate($field, 'create') !!}
                                @endif
                            </td>
                        </tr>

                        @if ( isset($user) )
                            <tr>
                                <td>
                                    {!! Form::label('created at', 'Created At: ') !!}
                                </td>
                                <td>
                                    {!! $DatesHelper::convertDatetoFormattedDateString($user->created_at) !!} &nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="The Created At date is automatically filled in."><i class="fa fa-info-circle"></i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    {!! Form::label('updated at', 'Updated At: ') !!}
                                </td>
                                <td>
                                    {!! $DatesHelper::convertDatetoFormattedDateString($user->updated_at) !!} &nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="The Updated At date is automatically filled in"><i class="fa fa-info-circle"></i></a>
                                </td>
                            </tr>
                        @endif


                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr class="info"><td colspan="2"><strong>Two Factor Authorization:</strong></td></tr>

                        <td>
                            {!! Form::label('two_factor_auth_enabled', 'Enabled for 2FA: ') !!}
                        </td>
                        <td>
                            {!! Form::checkbox('two_factor_auth_enabled', '1', Input::old('two_factor_auth_enabled')) !!}&nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="Enable if 2FA is disabled, but you want this specific user to still go through the 2FA process when logging in to front-end and admin."><i class="fa fa-info-circle"></i></a>
                            {{{ $errors->first('two_factor_auth_enabled', '<span class="help-block">:message</span>') }}}
                        </td>

                        <tr>
                            <td>
                                {!! Form::label('phone_country_code', 'Phone Country Code: ') !!}
                            </td>
                            <td>
                                {!! Form::input('text', 'phone_country_code', Input::old('phone_country_code', isset($user) ? $user->phone_country_code : '')) !!}&nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="Canada = 1, USA = 1"><i class="fa fa-info-circle"></i></a>
                                {{{ $errors->first('phone_country_code', '<span class="help-block">:message</span>') }}}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('phone_number', 'Phone Number: ') !!}
                            </td>
                            <td>
                                {!! Form::input('text', 'phone_number', Input::old('phone_number', isset($user) ? $user->phone_number : '')) !!}&nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="No spaces, no dashes, no country code. eg: 647-123-4567"><i class="fa fa-info-circle"></i></a>
                                {{{ $errors->first('phone_number', '<span class="help-block">:message</span>') }}}
                            </td>
                        </tr>

                        <tr><td colspan="2"><hr></td></tr>



                        @if ( isset($user) )
                            <tr class="info"><td colspan="2"><strong>Last Login</strong></td></tr>

                            <td>
                                Last Login Date:
                            </td>
                            <td>
                                @if (isset($user->last_login))
                                    {!! $DatesHelper::convertDatetoFormattedDateString($user->last_login) !!}, at {!! date("h:i a",strtotime($user->last_login)) !!}
                                @else
                                    {!! $user->name !!} has not yet logged in for the first time.
                                @endif
                            </td>

                            <tr>
                                <td>
                                    Last Login IP:
                                </td>
                                <td>
                                    @if (isset($user->last_login))
                                        {!! $user->last_login_ip !!}
                                    @else
                                        {!! $user->name !!} has not yet logged in for the first time.
                                    @endif
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
                <div class="col-md-3"></div>

            </div> <!-- row -->


        </div> <!-- container -->

    </section>
@stop

