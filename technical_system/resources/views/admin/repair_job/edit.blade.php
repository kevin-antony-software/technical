<x-admin.nav>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        .ui-autocomplete {
            max-height: 100px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        * html .ui-autocomplete {
            height: 100px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function() {
            var cusJqery = {!! json_encode($customers) !!};
            var cusName = [];
            for (var ckj = 0; ckj < cusJqery.length; ckj++) {
                cusName.push(cusJqery[ckj].name);
            }

            $("#customer_name").autocomplete({
                source: cusName
            });
        });
    </script>
    <script>
        $(function() {
            var models = {!! json_encode($models->toArray()) !!};
            var modelsArray = [];
            for (var ckj = 0; ckj < models.length; ckj++) {
                modelsArray.push(models[ckj].name);
            }

            $("#model").autocomplete({
                source: modelsArray
            });
        });
    </script>
    <script>
        $(function() {
            $('#serial_number').on('keypress', function(e) {
                if (e.which == 32) {
                    alert('Space Detected');
                    return false;
                }
            });
        });
    </script>
    <div class="container pt-2">
        <h3>Create New Repair Job Form</h3>
        <form method="POST" action="{{ route('repair_job.update', $repair_job) }}" onsubmit="return validateForm()">
            @csrf
            @method("PUT")
            <div class="form-group">
                <label for="customer_name">Customer </label>
                <input id="customer_name" name="customer_name" class="form-control" value="{{ $repair_job->customer->name }}">
                @error('customer_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="serial_number">Serial Number</label>
                <input type="text" class="form-control" id="serial_number" name="serial_number"
                    aria-describedby="serial_number" value="{{ $repair_job->serial_number }}" required>
                @error('serial_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="model">Model</label>
                <input type="text" class="form-control" id="model" name="model" aria-describedby="model"
                    value="{{ $repair_job->machine_model->name }}" required>
                @error('model')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="method_came_in">method came in</label>
                <input type="text" class="form-control" id="method_came_in" name="method_came_in"
                    aria-describedby="method_came_in" value="{{ $repair_job->method_came_in }}" required>
                @error('method_came_in')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="special_discount">special discount</label>
                <input type="number" class="form-control" id="special_discount" name="special_discount"
                    aria-describedby="special_discount" value="{{ $repair_job->special_discount }}">
                @error('special_discount')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="warranty_type" id="inlineRadio1"
                        value="With-Warranty" @if ($repair_job->warranty_type == "With-Warranty") checked @endif>
                    <label class="form-check-label" for="inlineRadio1">With Warranty</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="warranty_type" id="inlineRadio2"
                        value="Without-Warranty" @if ($repair_job->warranty_type == "Without-Warranty") checked @endif>
                    <label class="form-check-label" for="inlineRadio2">Without Warranty</label>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <a class="btn btn-block btn-secondary" href="{{ route('repair_job.index') }}" role="button">Go Back
                        to Index</a>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-block btn-primary">Edit Repair Job</button>
                </div>
            </div>
        </form>
        <script>
            function validateForm() {

                myButton = document.getElementById("submitButton");
                myButton.disabled = true;
                return true;
            }
        </script>
    </div>
</x-admin.nav>
