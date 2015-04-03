@extends('lasallecmsadmin::bob1.layouts.default')

@section('content')
    <!-- Main content -->
    <section class="content">

        <div class="container">

            {{-- form's title --}}
            <div class="row">
                <br /><br />
                @if ( isset($postupdate) )
                    Edit the update <i>{{ \Lasallecms\Lasallecmsapi\Models\Post::find($postupdate->post_id)->title }}</i>
                    <br />
                    &nbsp;&nbsp;for post <i>{{ $postupdate->title }}</i>

                @else
                    Create an Update
                    <br />
                    &nbsp;&nbsp;for the post: <i>{{ \Lasallecms\Lasallecmsapi\Models\Post::find($post_id)->title }}</i>
                @endif
                <br /><br />
            </div> <!-- row -->



            <div class="row">

                @include('lasallecmsadmin::bob1.partials.message')


                <div class="col-md-6">

                    {{-- this is a combo create or edit form. Display the proper "form action"  --}}
                    @if ( isset($tag) )
                        {!! Form::model($postupdate, array('route' => array('admin.postupdates.update', $postupdate->id), 'method' => 'PUT')) !!}

                        {!! Form::hidden('id', $postupdate->id) !!}
                    @else
                        {!! Form::open(['route' => 'admin.postupdates.store']) !!}
                    @endif

                    {{-- the table! --}}
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <tr>
                            <td>
                                {!! Form::label('name', 'Update\'s Name: ') !!}
                            </td>
                            <td>
                                {!! Form::input('text', 'title', Input::old('title', isset($postupdate) ? $postupdate->title : '')) !!}
                                {{{ $errors->first('title', '<span class="help-block">:message</span>') }}}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('content', 'Content: ') !!}
                            </td>
                            <td>
                                {!! Form::input('text', 'content', Input::old('content', isset($postupdate) ? $postupdate->content : '')) !!}
                                {{{ $errors->first('postupdate', '<span class="help-block">:message</span>') }}}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('excerpt', 'Excerpt: ') !!}
                            </td>
                            <td>
                                {!! Form::input('text', 'excerpt', Input::old('excerpt', isset($postupdate) ? $postupdate->excerpt : '')) !!}&nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="The update excerpt is displayed in a list of excerpts for the post. Generally, the content is displayed in the actual post, not the excerpt."><i class="fa fa-info-circle"></i></a>
                                {{{ $errors->first('postupdate', '<span class="help-block">:message</span>') }}}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('enabled', 'Enabled: ') !!}
                            </td>
                            <td>
                                {!! $HTMLHelper::convertToCheckOrXBootstrapButtons($postupdate->enabled) !!}
                            <td>
                        </tr>

                        <tr>
                            <td>
                                {!! Form::label('publish on', 'Publish On: ') !!}
                            </td>
                            <td>
                                {{{ $DatesHelper::convertDatetoFormattedDateString($postupdate->publish_on) }}} &nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="When do you want this update to display?"><i class="fa fa-info-circle"></i></a>
                            </td>
                        </tr>

                        @if ( isset($postupdate) )
                            <tr>
                                <td>
                                    {!! Form::label('created at', 'Created At: ') !!}
                                </td>
                                <td>
                                    {{{ $DatesHelper::convertDatetoFormattedDateString($postupdate->created_at) }}} &nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="The Created At date is automatically filled in."><i class="fa fa-info-circle"></i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    {!! Form::label('updated at', 'Updated At: ') !!}
                                </td>
                                <td>
                                    {{{ $DatesHelper::convertDatetoFormattedDateString($postupdate->updated_at) }}} &nbsp;&nbsp; <a href="#" data-toggle="popover" data-content="The Updated At date is automatically filled in"><i class="fa fa-info-circle"></i></a>
                                </td>
                            </tr>
                        @endif


                        @if ( isset($postupdate) )
                            {{ Form::hidden('post_id', $postupdate->post_id) }}
                        @else
                            {{ Form::hidden('post_id', $post_id) }}
                        @endif


                        <tr>
                            <td>

                            </td>
                            <td>
                                @if ( isset($postupdate) )
                                    {!! Form::submit( 'Edit Tag!') !!}
                                @else
                                    {!! Form::submit( 'Create Tag!') !!}
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