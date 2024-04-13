<x-admin.nav>
    <div class="container pt-2">
        <h3>Accept Component Purchase Form</h3>
        <form method="POST" action="{{ route('component_purchase.update', $component_purchase) }}"
            onsubmit="return validateForm()">
            @csrf
            @method('PUT')
            <div class="pre-scrollable">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="10%">Item No</th>
                            <th width="50%">Item Name</th>
                            <th width="15%">Quantity</th>
                            <th width="25%">Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($component_pruchase_details as $component_pruchase_detail)
                            <tr>
                                <td>{{ $component_pruchase_detail->component_id }}</td>
                                <td>{{ $component_pruchase_detail->component->name }}</td>
                                <td>{{ $component_pruchase_detail->qty }}</td>
                                <td>{{ $component_pruchase_detail->component->component_category->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-6">
                    <a class="btn btn-block btn-secondary" href="{{ route('component_purchase.index') }}"
                        role="button">Go Back
                        to Index</a>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-block btn-primary">Accept component purchase</button>
                </div>
            </div>
        </form>
    </div>
</x-admin.nav>
