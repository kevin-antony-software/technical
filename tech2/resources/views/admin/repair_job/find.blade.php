<x-admin.nav>
    <div class="container pt-2">
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
                var models = {!! json_encode($machine_models->toArray()) !!};
                var modelsArray = [];
                for (var ckj = 0; ckj < models.length; ckj++) {
                    modelsArray.push(models[ckj].name);
                }

                $("#model").autocomplete({
                    source: modelsArray
                });
            });
        </script>
        <form method="POST" action="{{ route('repair_job.show_find') }}" onsubmit="return validateForm()">
            @csrf

            <div class="form-group">
                <label for="customer_name">Customer </label>
                <input id="customer_name" name="customer_name" class="form-control" value="{{ old('customer_name') }}">
                @error('customer_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="model">Model</label>
                <input type="text" class="form-control" id="model" name="model" aria-describedby="model"
                    value="{{ old('model') }}">
                @error('model')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="job_id">Job id</label>
                <input type="number" class="form-control" id="job_id" name="job_id" aria-describedby="job_id"
                    value="{{ old('job_id') }}">
                @error('job_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="row">
                <div class="col-6">
                    <a class="btn btn-block btn-secondary" href="{{ route('repair_job.index') }}" role="button">Go Back
                        to Index</a>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-block btn-primary">Find Job</button>
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
