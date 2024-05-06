<x-admin.nav>
    <div class="container pt-2">
        <h3>Create Component Purchase Form</h3>
        <form method="POST" action="{{ route('component_purchase.store') }}" onsubmit="return validateForm()">
            @csrf
            <style>
                .pre-scrollable {
                    max-height: 540px;
                }
            </style>
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
                        @for ($i = 1; $i < 31; $i++)
                            <tr>
                                <td><input type="text" name="itemNo_{!! $i !!}"
                                        id="itemNo_{!! $i !!}" class="form-control" autocomplete="off"
                                        readonly></td>
                                <td><input type="text" name="itemName_{!! $i !!}"
                                        id="itemName_{!! $i !!}" class="form-control"></td>
                                <td><input type="number" name="quantity_{!! $i !!}"
                                        id="quantity_{!! $i !!}" class="form-control changesNo"
                                        value="">
                                </td>
                                <td><input type="text" name="category_{!! $i !!}"
                                        id="category_{!! $i !!}" class="form-control" readonly>
                                </td>

                            </tr>
                        @endfor
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
                    <button type="submit" class="btn btn-block btn-primary">Save New component purchase</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        function validateForm() {
            var itemNo;
            var ItemName;
            var quantity;
            var category;

            for (var i = 1; i < 31; i++) {
                itemNo = "itemNo_" + i;
                ItemName = "itemName_" + i;
                quantity = "quantity_" + i;
                category = "category_" + i;

                if (document.getElementById(itemNo).value != "") {
                    if (document.getElementById(quantity).value == "") {
                        alert("qty cant be empty");
                        return false;
                    }
                    if (document.getElementById(ItemName).value == "") {
                        alert("Item Name cant be empty");
                        return false;
                    }
                }
            }

            return true;
        }
    </script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script type='text/javascript'>
        $(window).load(function() {

            plist = [
                    @foreach ($components as $p)
                        {
                            label: "{!! $p->name !!}",
                            productCode: "{!! $p->id !!}",
                            category: "{!! $p->component_category->name !!}"
                        },
                    @endforeach
                ],

                @for ($i = 1; $i < 31; $i++)
                    $('#itemName_{!! $i !!}').autocomplete({
                        source: plist,
                        minLength: 2,

                        select: function(event, ui) {
                            event.preventDefault();
                            $('#itemName_{!! $i !!}').val(ui.item.label);
                            this.value = ui.item.label;
                            $('#itemNo_{!! $i !!}').val(ui.item.productCode);
                            $('#category_{!! $i !!}').val(ui.item.category);
                            $('#quantity_{!! $i !!}').val(0);
                        }
                    });
                @endfor
        });
    </script>
</x-admin.nav>
