@extends('lasallecmsadmin::bob1.layouts.default')

@section('content')

        <!-- Main content -->
<section class="content">

    <div class="container">
        <div class="row">


            {{-- form's title --}}
            <div class="row">
                <br /><br />
                {!! $HTMLHelper::adminPageTitle('LaSalleCMS', 'Users', '') !!}
                <br /><br />
            </div>


            <div class="row">

                <div class="col-md-2 text-center">
                    <div class="boxX">
                        <div class="box-content">
                            {{-- empty on purpose --}}
                        </div>
                    </div>
                </div>

                <div class="col-md-8 text-center">
                    <div class="box">
                        <div class="box-content">
                            <h1 class="tag-title">
                                Hey, {{ $logged_in_user->name }}!
                                <hr />
                                Just want to confirm this deletion with you first.
                                <hr />
                                Do you really want to delete this user:
                                <br /><br />
                                "<em>{{ $user->name }}</em>"
                                <br />
                                (ID #{{ $user->id }})?
                            </h1>
                            <hr />
                            <p>&nbsp;</p>
                            <br />

                            {!! Form::open(array('url' => 'admin/users/' . $user->id)) !!}
                            {!! Form::model($user, array('route' => array('admin.users.destroy', $user->id), 'method' => 'DELETE')) !!}

                            <button type="submit" class="btn btn-block btn-success">
                                <i class="fa fa-check fa-2x"></i>&nbsp;&nbsp; <strong><u>Yes</u>, I am absolutely sure that I want to delete this user.</strong>
                            </button>


                            {!! Form::close() !!}

                            <br /><br />

                            <a href="{{{ URL::route('admin.users.index') }}}" class="btn btn-block btn-danger"><i class="fa fa-times fa-2x"></i>&nbsp;&nbsp; <strong>Oh <u>No</u>, I do <u>not</u> want to delete this user.</strong></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 text-center">
                    <div class="boxX">
                        <div class="box-content">
                            {{-- empty on purpose --}}
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>



</section>
@stop