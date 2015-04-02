
@if ( Session::get('message') )


    {{-- The status_code is either 200, 400 or 500 --}}
    @if ( Session::get('status_code') == 200 )
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

            <h4><span class="glyphicon glyphicon-ok"></span>  Message!</h4>
    @endif


    @if ( Session::get('status_code') == 400 )
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

            <h4><span class="glyphicon glyphicon-exclamation-sign"></span>  Warning!</h4>
    @endif



    @if ( Session::get('status_code') == 500 )
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

            <h4><span class="glyphicon glyphicon-remove"></span>  Error!</h4>
    @endif






       <hr />

       <h4>{{ Session::get('message') }}</h4>

    </div>
    <br />
@endif