<x-admin.nav>
    <style>
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        * html .ui-autocomplete {
            height: 200px;
        }
    </style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function() {
            var cusJqery = {!! json_encode($CourierCustomers->toArray()) !!};
            var cusName = [];
            for (var ckj = 0; ckj < cusJqery.length; ckj++) {
                cusName.push(cusJqery[ckj].name);
            }

            $("#customer_name").autocomplete({
                source: cusName
            });
        });
    </script>

    <div class="container pt-2">
        <h3>Create Courier pick up Form</h3>
        <form method="POST" action="{{ route('courier_pickup.store') }}">
            @csrf

            <div class="mb-3 row">
                <label for="customer_name" class="col-sm-2 col-form-label">Customer </label>
                <div class="col-sm-10">
                    <input id="customer_name" name="customer_name" class="form-control"
                        value="{{ old('customer_name') }}" required>
                </div>
            </div>
            <button class="btn btn-block btn-primary" type="submit">Create New Pickup</button>
        </form>
    </div>
</x-admin.nav>
