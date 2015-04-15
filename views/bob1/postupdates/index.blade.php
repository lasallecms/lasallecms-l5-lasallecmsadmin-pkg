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

                <br /><br /><br />


                {{-- bootstrap table tutorial http://twitterbootstrap.org/twitter-bootstrap-table-example-tutorial --}}

                {{-- http://datatables.net/manual/options --}}

                <table id="table_id" class="table table-striped table-bordered table-hover" data-order='[[ 1, "asc" ]]' data-page-length='25'>
                    <thead>
                    <tr class="info">
                        <th style="text-align: center;">ID</th>
                        <th style="text-align: center;">Enabled</td>
                        <th style="text-align: center;">Title</td>
                        <th style="text-align: center;">Excerpt</td>
                        <th style="text-align: center;">For Post</td>
                        <th style="text-align: center;">Publish On</td>
                        <th style="text-align: center;"></td>
                        <th style="text-align: center;"></td>
                    </tr>

                    </thead>

                    <tbody>
                    @foreach ($postupdates as $postupdate)
                        <tr>
                            <td align="center">{{{ $postupdate->id }}}</td>

                            <td align="center">{!! $HTMLHelper::convertToCheckOrXBootstrapButtons($postupdate->enabled) !!}</td>

                            <td>{{{ $postupdate->title }}}</td>

                            <td>{{{ $postupdate->excerpt }}}</td>

                            <td align="center">{{{ \Lasallecms\Lasallecmsapi\Models\Post::find($postupdate->post_id)->title }}}</td>

                            <td align="center">{{{ $DatesHelper::convertDateONLYtoFormattedDateString($postupdate->publish_on) }}}</td>

                            <td align="center">
                                <a href="{{{ URL::route('admin.postupdates.edit', $postupdate->id) }}}" class="btn btn-success  btn-xs" role="button">
                                    <i class="glyphicon glyphicon-edit"></i>
                                </a>
                            </td>
                            <td align="center">

                                {{-- If there is just one post update, then suppress the delete button --}}
                                {{-- Actually, not for post updates! So changing the >1 to >0 --}}
                                @if (count($postupdates) > 0)

                                    {!! Form::open(array('url' => 'admin/postupdates/' . $postupdate->id)) !!}
                                    {!! Form::model($postupdate, array('route' => array('admin.postupdates.destroy', $postupdate->id), 'method' => 'DELETE')) !!}

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
                <div class="span3 well">
                    <h4>
                        There are no post updates.
                        <br /><br />
                        <ul>
                            <li>goto the posts listing</li>
                            <li>select a post</li>
                            <li>click its "Add a New Update</li>
                        </ul>
                    </h4>

                    <br />

                    <a class="btn btn-success" href="{{ route('admin.posts.index') }}" role="button">
                        <span class="glyphicon glyphicon-heart-empty"></span>  Goto the posts listing...
                    </a>
                </div>
            @endif


        </div> <!-- container -->

        </div> <!-- content -->
        <!-- End: Main content -->

    </section>
@stop