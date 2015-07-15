    <!-- jQuery 2.1.3 (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>



    <!-- SlimScroll -->
    <script src="{{{ Config::get('app.url') }}}/packages/lasallecmsadmin/bob1/plugins/slimScroll/jquery.slimScroll.min.js" type="text/javascript"></script>

    <!-- FastClick -->
    <script src='"{{{ Config::get('app.url') }}}/packages/lasallecmsadmin/bob1/plugins/fastclick/fastclick.min.js'></script>

    <!-- AdminLTE App -->
    <script src="{{{ Config::get('app.url') }}}/packages/lasallecmsadmin/bob1/dist/js/app.min.js" type="text/javascript"></script>


    <!-- DataTables (http://datatables.net/manual/installation) -->
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.js"></script>


    <!-- prettyprint -->
    <!-- http://google-code-prettify.googlecode.com/svn/trunk/README.html -->
    <!--
    <script src="http://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
    -->

    <script>
        $(document).ready( function () {
            $('#table_id').DataTable();
        } );
    </script>

    <!-- http://getbootstrap.com/javascript/#popovers -->
    <script>
        $(function () {
            $('[data-toggle="popover"]').popover()
        })
    </script>


    <!-- http://datatables.net/manual/options -->
    <script>
        $('#table_id').DataTable( {
            scrollY: 400
        } );
    </script>


    <!-- custom-ajax.js for forms https://laracasts.com/lessons/javascript-conveniences -->
    <script>
    // --------------------------------------------------------
    //    https://laracasts.com/lessons/javascript-conveniences
    // ----------------------------------------------------------

    (function() {

        // Quickie PubSub
        var o = $({});
        $.subscribe = function() { o.on.apply(o, arguments) };
        $.publish = function() { o.trigger.apply(o, arguments) };


        // Async submit a form's input.
        var submitLaravelRequest = function(e) {
            var form = $(this);
            var method = form.find('input[name="_method"]').val() || 'POST';

            $.ajax({
                type: method,
                url: form.prop('action'),
                data: form.serialize(),
                success: function() {
                    $.publish('ajax.request.success', form);
                }
            });

            e.preventDefault();
        };


        // Offer flash notification messages.
        // 'data-remote-success-message' => 'Yay. All Done.'
        $.subscribe('ajax.request.success', function(e, form) {
            var message = $(form).data('remote-success-message');

            if (message) {
                $('.flash').html(message).fadeIn(300).delay(2500).fadeOut(300);
            }
        })


        // Handle success callbacks. To trigger Task.foo(), do:
        // 'data-model' => 'Task', 'data-remote-on-success' => 'foo'
        $.subscribe('ajax.request.success', function(e, form) {
            triggerClickCallback.apply(form, [e, $(form).data('remote-on-success')]);
        });


        // Confirm an action before proceeding.
        var confirmAction = function(e) {
            var input = $(this);

        // disable the actual form's submit button so form is not re-submitted when this modal is displayed
            input.prop('disabled', 'disabled');

        // Or, much better, use a dedicated modal.
            if ( ! confirm(input.data('confirm'))) {
                e.preventDefault();
            }

            input.removeAttr('disabled');
        };


        // Trigger the registered callback for a click or form submission.
        var triggerClickCallback = function(e, method) {
            var that = $(this);

        // What's the name of the parent model/scope/object.
            if ( ! (model = that.closest('*[data-model]').data('model'))) {
                return;
            }


        // As long as the object and method exist, trigger it and pass through the form.
            if (typeof window[model] == 'object' && typeof window[model][method] == 'function') {
                window[model][method](that);
            } else {
                console.error('Could not call method ' + method + ' on object ' + model);
            }

            e.preventDefault();
        }

        // And bind functions to user events.
        $('form[data-remote]').on('submit', submitLaravelRequest);
        $('input[data-confirm], button[data-confirm]').on('click', confirmAction);
        $('*[data-click]').on('click', function(e) {
            triggerClickCallback.apply(this, [e, $(this).data('click')]);
        });

    })();
    </script>

