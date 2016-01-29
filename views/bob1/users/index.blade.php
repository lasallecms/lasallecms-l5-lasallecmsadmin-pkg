@extends('lasallecmsadmin::bob1.layouts.default')


@section('content')

    <!-- Main content -->
    <section class="content">


        <div class="container">

            <div class="row">
                <br /><br />
                {!! $HTMLHelper::adminPageTitle('LaSalleCMS', 'Users', '') !!}
            </div>


            <div class="row">

                @include('lasallecmsadmin::bob1.partials.message')

                {!! $HTMLHelper::adminCreateButton('users', 'User', 'right') !!}

                <div class="col-md-1"></div>

                <div class="col-md-11">



            {{-- bootstrap table tutorial http://twitterbootstrap.org/twitter-bootstrap-table-example-tutorial --}}

            {{-- http://datatables.net/manual/options --}}

            <table id="table_id" class="table table-striped table-bordered table-hover" data-order='[[ 1, "asc" ]]' data-page-length='25'>
                <thead>
                <tr class="info">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th style="text-align: center;">Activated</th>
                    <th style="text-align: center;">Enabled</th>

                    @if ($peoplesTableExists)
                        <th style="text-align: center;">LaSalleCRM</th>
                    @endif

                    <th style="text-align: center;">Edit<br />User</th>
                    <th style="text-align: center;">Delete<br />User</th>
                </tr>

                </thead>

                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td align="center">{{{ $user->id }}}</td>

                        <td>{{{ $user->name }}}</td>

                        <td>{{{ $user->email }}}</td>

                        <td align="center">
                            {!! $HTMLHelper::convertToCheckOrXBootstrapButtons($user->activated) !!}
                            </td>

                        <td align="center">
                            {!! $HTMLHelper::convertToCheckOrXBootstrapButtons($user->enabled) !!}
                        </td>

                        @if ($peoplesTableExists)
                            <td align="center">
                                {!! $repository->getPeopleIdForIndexListing($user->id) !!}
                            </td>
                        @endif


                        <td align="center">
                            <a href="{{{ URL::route('admin.users.edit', $user->id) }}}" class="btn btn-success  btn-xs" role="button">
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                        </td>

                        <td align="center">
                            {{-- If there is just one user, then suppress the delete button --}}
                            {{-- If one user, it should be the "first among equals user" --}}


                            @if ( $user->email != config('auth.administrator_first_among_equals_email') )


                                {{-- If LaSalleCRM is installed --}}
                                @if ($peoplesTableExists)

                                    {{-- If this user does *NOT* have a record in the "peoples" db table --}}
                                    {{-- then this user id deletable. Otherwise, foreign key constraint --}}
                                    @if ($repository->getPeopleIdForIndexListing($user->id) == "Not in LaSalleCRM")

                                        {!! Form::open(array('url' => 'admin/users/' . $user->id)) !!}
                                        {!! Form::model($user, array('route' => array('admin.users.destroy', $user->id), 'method' => 'DELETE')) !!}

                                            <button type="submit" class="btn btn-danger btn-xs" data-confirm="Do you really want to DELETE the {!! strtoupper($user->name) !!} user?">
                                                <i class="glyphicon glyphicon-remove"></i>
                                            </button>

                                        {!! Form::close() !!}
                                    @endif

                                @else
                                    {{-- Yes, I am repeating the delete form.  --}}
                                    {{-- If LaSalleCRM is installed, then display the delete form --}}

                                    {!! Form::open(array('url' => 'admin/users/' . $user->id)) !!}
                                    {!! Form::model($user, array('route' => array('admin.users.destroy', $user->id), 'method' => 'DELETE')) !!}

                                        <button type="submit" class="btn btn-danger btn-xs" data-confirm="Do you really want to DELETE the {!! strtoupper($user->name) !!} user?">
                                            <i class="glyphicon glyphicon-remove"></i>
                                        </button>

                                    {!! Form::close() !!}
                                @endif

                            @endif
                        </td>

                    </tr>


                @endforeach
                </tbody>
            </table>

        </div> <!-- col-md-11 -->

        </div> <!-- row -->


        @if (!$peoplesTableExists)
            <div class="row">

                <br /><br />

                <div class="col-md-4"></div>

                <div class="col-md-4">
                    <div class="alert alert-warning" role="alert">
                        <h4 style="text-align: center">FYI: LaSalleCRM is not installed</h4>
                    </div>
                </div>

                <div class="col-md-4"></div>

            </div> <!-- row -->
        @endif




        </div> <!-- container -->

    </section>
@stop


