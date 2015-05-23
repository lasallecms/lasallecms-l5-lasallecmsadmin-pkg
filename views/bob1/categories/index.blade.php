@extends('lasallecmsadmin::bob1.layouts.default')



@section('content')

    <!-- Start: Main content -->
    <section class="content">


        <div class="container">

            <br /><br />
            {!! $HTMLHelper::adminPageTitle('LaSalleCMS', 'Categories', '') !!}




            <div class="row">

                @include('lasallecmsadmin::bob1.partials.message')

                <div class="col-md-1"></div>

                <div class="col-md-11">


            @if (count($categories) > 0 )

            {!! $HTMLHelper::adminCreateButton('categories', 'Category', 'right') !!}


            {{-- bootstrap table tutorial http://twitterbootstrap.org/twitter-bootstrap-table-example-tutorial --}}

            {{-- http://datatables.net/manual/options --}}

            <table id="table_id" class="table table-striped table-bordered table-hover" data-order='[[ 1, "asc" ]]' data-page-length='25'>
                <thead>
                <tr class="info">
                    <th style="text-align: center;">ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th style="text-align: center;">Parent Category</th>
                    <th></th>
                    <th></th>
                </tr>

                </thead>

                <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td align="center">{{{ $category->id }}}</td>

                        <td>{{{ $category->title }}}</td>

                        <td>{{{ $category->description }}}</td>

                        <td align="center">{{{ $HTMLHelper::displayParentCategoryTitle($category->parent_id, $categoryRepository) }}}</td>

                        <td align="center">
                            <a href="{{{ URL::route('admin.categories.edit', $category->id) }}}" class="btn btn-success  btn-xs" role="button">
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
                        </td>
                        <td align="center">

                            {{-- If there is just one category, then suppress the delete button --}}
                            {{-- Actually, not for categories! So changing the >1 to >0 --}}
                            @if (count($categories) > 0)

                                {!! Form::open(array('url' => 'admin/categories/' . $category->id)) !!}
                                {!! Form::model($category, array('route' => array('admin.categories.destroy', $category->id), 'method' => 'DELETE')) !!}

                                <button type="submit" class="btn btn-danger btn-xs" data-confirm="Do you really want to DELETE the {!! strtoupper($category->title) !!} category?">
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
                There are no categories. Go ahead, create your first category!

                <br /><br />

                <a class="btn btn-default" href="{{ route('admin.tags.create') }}" role="button">
                    <span class="glyphicon glyphicon-heart-empty"></span>  Create Category
                </a>
            @endif


                </div> <!-- col-md-11 -->

            </div> <!-- row -->

        </div> <!-- container -->

    </section>
@stop