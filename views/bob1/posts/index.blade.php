@extends('lasallecmsadmin::bob1.layouts.default')



@section('content')

    <!-- Start: Main content -->
    <section class="content">


        <div class="container">

            <br /><br />
            <div class="row">
                <h1>
                <span class="label label-info">
                    List of Posts
                </span>
                </h1>
                <br /><br />
            </div>


            @include('lasallecmsadmin::bob1.partials.message')


            @if (count($posts) > 0 )

                <a class="btn btn-default pull-right" href="{{ route('admin.posts.create') }}" role="button">
                    <span class="glyphicon glyphicon-heart-empty"></span>  Create Post
                </a>
                <br /><br /><br />

                {{-- bootstrap table tutorial http://twitterbootstrap.org/twitter-bootstrap-table-example-tutorial --}}
                {{-- http://datatables.net/manual/options --}}

                <table id="table_id" class="table table-striped table-bordered table-hover" data-order='[[ 4, "desc" ]]' data-page-length='25'>
                    <thead>
                    <tr class="info">
                        <th style="text-align: center;">ID</th>
                        <th style="text-align: center;">Enabled</th>
                        <th>Title</th>
                        <th>Excerpt</th>
                        <th>Categories</th>
                        <th>Publish On</th>
                        <th style="text-align: center;">Edit Post</th>
                        <th style="text-align: center;">Delete Post</th>
                        <th style="text-align: center;">Add a New Update</th>
                    </tr>

                    </thead>

                    <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td align="center">{{{ $post->id }}}</td>

                            <td align="center">{!! $HTMLHelper::convertToCheckOrXBootstrapButtons($post->enabled) !!}</td>

                            <td>{{{ $post->title }}}</td>

                            <td>{{{ $post->excerpt }}}</td>

                            <td align="center">{!! $HTMLHelper::listSingleCollectionElementOnSeparateRow($postRepository->findCategoriesByPostId($post->id)) !!}</td>

                            <td>{{{ $DatesHelper::convertDateONLYtoFormattedDateString($post->publish_on) }}}</td>

                            <td align="center">
                                <a href="{{{ URL::route('admin.posts.edit', $post->id) }}}" class="btn btn-success  btn-xs" role="button">
                                    <i class="glyphicon glyphicon-edit"></i>
                                </a>
                            </td>
                            <td align="center">

                                {{-- If there is just one post, then suppress the delete button --}}
                                {{-- Actually, not for posts! So changing the >1 to >0 --}}
                                @if (count($posts) > 0)

                                    {!! Form::open(array('url' => 'admin/posts/' . $post->id)) !!}
                                    {!! Form::model($post, array('route' => array('admin.posts.destroy', $post->id), 'method' => 'DELETE')) !!}

                                    <button type="submit" class="btn btn-danger btn-xs" data-confirm="Do you really want to DELETE the {!! strtoupper($post->title) !!} post?">
                                        <i class="glyphicon glyphicon-remove"></i>
                                    </button>

                                    {!! Form::close() !!}
                                @endif
                            </td>

                            <td align="center">
                                <a href="postupdates/create?post_id={{ $post->id  }}"><i class="fa fa-pencil fa-lg"></i></a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

            @else
                There are no posts. Go ahead, create your first post!

                <br /><br />

                <a class="btn btn-default" href="{{ route('admin.posts.create') }}" role="button">
                    <span class="glyphicon glyphicon-heart-empty"></span>  Create Post
                </a>
            @endif



            SEO help:
            <ul>
                <li><a href="https://adwords.google.com/KeywordPlanner" target="_blank">https://adwords.google.com/KeywordPlanner</a></li>
                <li><a href="https://websiteadvantage.com.au/Google-SERP-Emulator" target="_blank">https://websiteadvantage.com.au/Google-SERP-Emulator</a></li>

            </ul>

        </div> <!-- container -->

        </div> <!-- content -->
        <!-- End: Main content -->

    </section>
@stop