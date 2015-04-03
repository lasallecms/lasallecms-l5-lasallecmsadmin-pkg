@extends('lasallecmsadmin::bob1.layouts.default')



@section('content')

    <!-- Start: Main content -->
    <section class="content">


        <div class="container">

            <br /><br />
            <div class="row">
                <h1>
                <span class="label label-info">
                    List of Updates to Posts
                </span>
                </h1>
                <br /><br />
            </div>


            @include('lasallecmsadmin::bob1.partials.message')


            @if (count($postupdates) > 0 )

                <a class="btn btn-default pull-right" href="{{ route('admin.postupdates.create') }}" role="button">
                    <span class="glyphicon glyphicon-heart-empty"></span>  Create a Post Update
                </a>
                <br /><br /><br />


                {{-- bootstrap table tutorial http://twitterbootstrap.org/twitter-bootstrap-table-example-tutorial --}}

                {{-- http://datatables.net/manual/options --}}

                <table id="table_id" class="table table-striped table-bordered table-hover" data-order='[[ 1, "asc" ]]' data-page-length='25'>
                    <thead>
                    <tr class="info">
                        <th style="text-align: center;">ID</th>
                        <td align="center">Title</td>
                        <td align="center">Excerpt</td>
                        <td align="center">Published</td>
                        <td align="center">For Post</td>
                        <td align="center">Modified</td>
                        <td align="center"></td>
                        <td align="center"></td>
                    </tr>

                    </thead>

                    <tbody>
                    @foreach ($postupdates as $postupdate)
                        <tr>
                            <td align="center">{{{ $postupdate->id }}}</td>

                            <td>{{{ $postupdate->title }}}</td>

                            <td>{{{ $postupdate->excerpt }}}</td>

                            <td align="center">{!! $HTMLHelper::convertToCheckOrXBootstrapButtons($postupdate->enabled) !!}<td>

                            <td align="center">{{{ \Lasallecms\Lasallecmsapi\Models\Post::find($postupdate->post_id)->title }}}</td>

                            <td align="center">{{{ $DatesHelper::convertDatetoFormattedDateString($tag->updated_at) }}}</td>

                            <td align="center">
                                <a href="{{{ URL::route('admin.postupdates.edit', $tag->id) }}}" class="btn btn-success  btn-xs" role="button">
                                    <i class="glyphicon glyphicon-edit"></i>
                                </a>
                            </td>
                            <td align="center">

                                {{-- If there is just one post update, then suppress the delete button --}}
                                {{-- Actually, not for post updates! So changing the >1 to >0 --}}
                                @if (count($postupdates) > 0)

                                    {!! Form::open(array('url' => 'admin/postupdates/' . $postupdate->id)) !!}
                                    {!! Form::model($postupdate, array('route' => array('admin.postupdates.destroy', $tag->id), 'method' => 'DELETE')) !!}

                                    <button type="submit" class="btn btn-danger btn-xs" data-confirm="Do you really want to DELETE the {!! strtoupper($postupdate->title) !!} Post Update?">
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
                There are no post updates. Go ahead, create your first post update!

                <br /><br />

                <a class="btn btn-default" href="{{ route('admin.postupdates.create') }}" role="button">
                    <span class="glyphicon glyphicon-heart-empty"></span>  Create a Post Update
                </a>
            @endif


        </div> <!-- container -->

        </div> <!-- content -->
        <!-- End: Main content -->

    </section>
@stop