@extends('lasallecmsadmin::bob1.layouts.default')



@section('content')

    <!-- Start: Main content -->
    <section class="content">


        <div class="container">

            <br /><br />
            <div class="row">
                <h1>
                <span class="label label-info">
                    List of Tags
                </span>
                </h1>
                <br /><br />
            </div>


            @include('lasallecmsadmin::bob1.partials.message')


            @if (count($tags) > 0 )

            <a class="btn btn-default pull-right" href="{{ route('admin.tags.create') }}" role="button">
                <span class="glyphicon glyphicon-heart-empty"></span>  Create Tag
            </a>
            <br /><br /><br />


            {{-- bootstrap table tutorial http://twitterbootstrap.org/twitter-bootstrap-table-example-tutorial --}}

            {{-- http://datatables.net/manual/options --}}

            <table id="table_id" class="table table-striped table-bordered table-hover" data-order='[[ 1, "asc" ]]' data-page-length='25'>
                <thead>
                <tr class="info">
                    <th style="text-align: center;">ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th></th>
                    <th></th>
                </tr>

                </thead>

                <tbody>
                @foreach ($tags as $tag)
                    <tr>
                        <td align="center">{{{ $tag->id }}}</td>

                        <td>{{{ $tag->title }}}</td>

                        <td>{{{ $tag->description }}}</td>

                        <td align="center">
                            <a href="{{{ URL::route('admin.tags.edit', $tag->id) }}}" class="btn btn-success  btn-xs" role="button">
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                        </td>
                        <td align="center">

                            {{-- If there is just one tag, then suppress the delete button --}}
                            {{-- Actually, not for tags! So changing the >1 to >0 --}}
                            @if (count($tags) > 0)

                                {!! Form::open(array('url' => 'admin/tags/' . $tag->id)) !!}
                                {!! Form::model($tag, array('route' => array('admin.tags.destroy', $tag->id), 'method' => 'DELETE')) !!}

                                <button type="submit" class="btn btn-danger btn-xs" data-confirm="Do you really want to DELETE the {!! strtoupper($tag->title) !!} tag?">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </button>

                                {!! Form::close() !!}
                            @endif
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>

            @else
                There are no tags. Go ahead, create your first tag!

                <br /><br />

                <a class="btn btn-default" href="{{ route('admin.tags.create') }}" role="button">
                    <span class="glyphicon glyphicon-heart-empty"></span>  Create Tag
                </a>
            @endif


        </div> <!-- container -->

    </div> <!-- content -->
    <!-- End: Main content -->

    </section>
@stop