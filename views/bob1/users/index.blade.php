@extends('lasallecmsadmin::bob1.layouts.default')


@section('content')

    <!-- Main content -->
    <section class="content">


        <div class="container">

            <br /><br />
            <div class="row">
                <h1>
                <span class="label label-info">
                    List of Users
                </span>
                </h1>
                <br /><br />
            </div>


            @include('lasallecmsadmin::bob1.partials.message')


            <a class="btn btn-default pull-right" href="{{ route('admin.users.create') }}" role="button">
                <span class="glyphicon glyphicon-heart-empty"></span>  Create a User
            </a>
            <br /><br /><br />



            {{-- bootstrap table tutorial http://twitterbootstrap.org/twitter-bootstrap-table-example-tutorial --}}

            {{-- http://datatables.net/manual/options --}}

            <table id="table_id" class="table table-striped table-bordered table-hover" data-order='[[ 1, "asc" ]]' data-page-length='25'>
                <thead>
                <tr class="info">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Activated</th>
                    <th>Enabled</th>
                    <th></th>
                    <th></th>
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

                        <td align="center">
                            <a href="{{{ URL::route('admin.users.edit', $user->id) }}}" class="btn btn-success  btn-xs" role="button">
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                        </td>

                        <td align="center">
                            {{-- If there is just one user, then suppress the delete button --}}
                            {{-- If one user, it should be the "first among equals user" --}}


                            @if ( $user->email != config('auth.administrator_first_among_equals_email') )

                                {!! Form::open(array('url' => 'admin/users/' . $user->id)) !!}
                                {!! Form::model($user, array('route' => array('admin.users.destroy', $user->id), 'method' => 'DELETE')) !!}

                                <button type="submit" class="btn btn-danger btn-xs" data-confirm="Do you really want to DELETE the {!! strtoupper($user->name) !!} user?">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </button>

                                {!! Form::close() !!}
                            @endif
                        </td>

                    </tr>


                @endforeach
                </tbody>
            </table>




            </div> <!-- container -->



    </section><!-- /.content -->
@stop


