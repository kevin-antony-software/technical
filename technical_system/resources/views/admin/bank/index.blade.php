<x-admin.nav>
    <div class="container pt-2">
        <div class="row">
            <div class="col-6">
                <a href="{{ route('bank.create') }}" class="btn btn-block btn-primary"><strong> Add new Bank </strong></a>
            </div>
            <div class="col-6">
                <a href="{{ route('bank_detail.create') }}" class="btn btn-block btn-warning"><strong> Bank Transfer</strong></a>
            </div>
        </div>
    </div>

        <div class="container pt-2">
            <div class="pt-2">
                <table id="example" class="display" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width:10%;">ID</th>
                            <th style="width:20%;">Bank Name </th>
                            <th style="width:20%;">Balance </th>
                            <th style="width:20%;">Action </th>

                        </tr>
                    </thead>
                    <tbody>
                        @if (count($banks))
                            @foreach ($banks as $bank)
                                <tr>
                                    <td> {{ $bank->id }}</td>
                                    <td> {{ $bank->name }} </td>
                                    <td> {{ number_format($bank->balance,2) }} </td>

                                    <td>
                                        <a href="{{ route('bank.show', $bank->id) }}" class="fas fa-eye"></a>
                                        <a href="{{ route('bank.edit', $bank->id) }}" class="far fa-edit"></a>

                                        <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()"
                                            class="far fa-trash-alt"></a>
                                        <form action="{{ route('bank.destroy', $bank->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')

                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr> No Data Found </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
        <script>
            new DataTable('#example', {
                info: false,
                lengthChange: false,
                pageLength: 20,
                order: [0, 'desc'],
                layout: {
                    topStart: {
                        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                    }
                }
            });
        </script>

</x-admin.nav>

