<x-admin.nav>
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script> --}}

    <div class="container pt-5">
            <a class="btn btn-success float-right" href="{{ route('user.index') }}" role="button">Back to Index</a>
            <h6><strong>User ID - {{ $user->id }} </strong></h6>
            <h6><strong>User Name - {{ $user->name }} </strong></h6>

            <form method="POST" action="{{ route('user.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group pt-2">
                    <label for="position">Choose a Position</label>
                    <select id="position" name="position" class="form-control" :value="{{ $user->position }}"
                        onchange="showCustomer()">
                        <option @if ($user->position == 'admin') {{ 'selected="selected"' }} @endif value="admin"> admin
                        </option>
                        <option @if ($user->position == 'director') {{ 'selected="selected"' }} @endif value="director">
                            director</option>
                        <option @if ($user->position == 'manager') {{ 'selected="selected"' }} @endif value="manager">manager
                        <option @if ($user->position == 'senior-tech-executive') {{ 'selected="selected"' }} @endif
                            value="senior-tech-executive">senior-tech-executive</option>

                        <option @if ($user->position == 'technical-executive') {{ 'selected="selected"' }} @endif
                            value="technical-executive">technical-executive</option>
                        <option @if ($user->position == 'sales-executive') {{ 'selected="selected"' }} @endif
                            value="sales-executive">
                            sales-executive</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-6">
                        <a class="btn btn-block btn-secondary" href="{{ route('user.index') }}" role="button">Go Back
                            to Index</a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-block btn-primary">Update user</button>
                    </div>
                </div>
            </form>
        </div>
</x-admin.nav>
