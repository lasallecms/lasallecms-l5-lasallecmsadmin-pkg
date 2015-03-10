@if ( Session::get('message') )

    <div class="alert alert-warning alert-dismissible" role="alert">

      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

       <h4><span class="glyphicon glyphicon-exclamation-sign"></span> Message!</h4>

       <hr />

       <strong>{{ Session::get('message') }}</strong>

    </div>
    <br />
@endif