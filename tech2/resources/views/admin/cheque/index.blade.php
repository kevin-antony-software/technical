<x-admin.nav>
        <div class="container pt-2">
            <div class="pt-2">
                <table id="example" class="display" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>Cheque ID</th>
                            <th>Payment ID</th>
                            <th>Customer Name </th>
                            <th>Cheque Number </th>
                            <th>Bank </th>
                            <th>Branch </th>
                            <th>Amount </th>
                            <th>Cheque Date </th>
                            <th>Status </th>
                            <th>Pass/Ret</th>
                            <th>Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($cheques))
                            @foreach ($cheques as $cheque)
                                <tr>
                                    <td> {{ $cheque->id }} </td>
                                    <td> <a href="{{ route('payment.show', $cheque->payment_id) }}">{{ $cheque->payment_id }}</a></td>
                                    <td> {{ $cheque->customer->name }} </td>
                                    <td> {{ $cheque->cheque_number }} </td>
                                    <td> {{ $cheque->cheque_bank }} </td>
                                    <td> {{ $cheque->cheque_branch }} </td>
                                    <td> {{ number_format($cheque->amount,2) }} </td>
                                    <td> {{ $cheque->cheque_date }} </td>
                                    <td> {{ $cheque->status }} </td>
                                    <td>
                                        <div class="row">
                                            @if ($cheque->status == 'pending')
                                                <form action="{{ route('cheque.passCheque', $cheque->id) }}"
                                                    method="post">
                                                    @csrf
                                                    <select class="form-select form-select-sm" name="bankID" id="bankID"
                                                        aria-label=".form-select-sm example">
                                                        <option value="">select bank</option>
                                                        @foreach ($banks as $bank)
                                                            <option value="{{ $bank->id }}">{{ $bank->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" onclick="save()"
                                                        class="btn btn-outline-success btn-sm">Pass</button>
                                                </form>
                                                <a href="{{ route('cheque.returnCheque', $cheque->id) }}"><button
                                                        type="button"
                                                        class="btn btn-outline-danger btn-sm">Return</button></a>
                                            @endif
                                            @if($cheque->status == 'returned')
                                            <form action="{{ route('cheque.passCheque', $cheque->id) }}"
                                                method="post">
                                                @csrf
                                                <select class="form-select form-select-sm" name="bankID" id="bankID"
                                                    aria-label=".form-select-sm example">
                                                    <option value="">select bank</option>
                                                    @foreach ($banks as $bank)
                                                        <option value="{{ $bank->id }}">{{ $bank->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" onclick="save()"
                                                    class="btn btn-outline-success btn-sm">Re-Pass</button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('cheque.edit', $cheque->id) }}" class="far fa-edit"></a>
                                        <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()"
                                            class="far fa-trash-alt"></a>
                                        <form action="{{ route('cheque.destroy', $cheque->id) }}" method="post">
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
