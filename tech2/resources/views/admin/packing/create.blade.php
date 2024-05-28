<x-admin.nav>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script type='text/javascript'>
        $(window).load(function() {

            plist = [
                    @foreach ($customers as $c)
                        {
                            label: "{!! $c->name !!}"
                        },
                    @endforeach
                ],

                @for ($i = 1; $i < 30; $i++)
                    $('#customer{!! $i !!}').autocomplete({
                        source: plist,
                        minLength: 2,

                        select: function(event, ui) {
                            event.preventDefault();
                            $('#customer{!! $i !!}').val(ui.item.label);
                            this.value = ui.item.label;
                        }

                    });
                @endfor
        });
    </script>

    <form action="{{ route('courier_packing.store') }}" method="post" onsubmit="return validateForm()">
        @csrf
        <div class="container">
            <div class="pre-scrollable" style="max-height: 75vh">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th width=20%>Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($x = 1; $x <= 20; $x++)
                                <tr>
                                    <td>
                                        <input id="customer{{ $x }}" name="customer{{ $x }}"
                                            class="form-control">
                                    </td>
                                    <td><input type="number" name="Qty{{ $x }}" id="Qty{{ $x }}"
                                            class="form-control"></td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="container pt-5">
            <div class="form-group">
                <button type="submit" value="Submit" class="btn btn-primary btn-lg btn-block">Print</button>
            </div>
        </div>

    </form>
    <script>
        function validateForm() {
            for (var i = 1; i < 21; i++) {
                qty = "Qty" + i;
                ItemName = "customer" + i;
                if (document.getElementById(ItemName).value != "") {
                    if (document.getElementById(qty).value == "") {
                        alert("Qty cant be blank with customer");
                        return false;
                    }
                }
            }
            return true;
        }
    </script>
</x-admin.nav>
