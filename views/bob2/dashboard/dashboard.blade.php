@extends('lasallecmsadmin::bob1.layouts.default')



@section('content')



    <div class="container">

        <div class="row">
            <h1>
                <span class="label label-info">
                    Dashboard
                </span>
            </h1>
            <br /><br />
        </div>


        @include('lasallecmsadmin::bob1.partials.message')



        <h1>Users! [There are {{{ count($users) }}} users in the db]</h1><br /><br />

                <!-- bootstrap table tutorial http://twitterbootstrap.org/twitter-bootstrap-table-example-tutorial -->

<!-- http://datatables.net/manual/options -->

        <table id="table_id" class="table table-striped table-bordered table-hover" data-order='[[ 1, "asc" ]]' data-page-length='25'>
                <thead>
                <tr class="info">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Activated</th>
                    <th>Enabled</th>
                </tr>

                </thead>

                <tbody>
                    @foreach ($users as $user)
                      <tr>
                        <td align="center">{{{ $user->id }}}</td>

                        <td>{{{ $user->name }}}</td>

                        <td>{{{ $user->email }}}</td>

                        <td align="center">{{{ $user->activated }}}</td>

                        <td align="center">{{{ $user->enabled }}}</td>

                      </tr>


                    @endforeach
                </tbody>
            </table>


    </div> <!-- container -->


@stop


