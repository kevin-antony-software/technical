<x-admin.nav>
    <div class="container">
        <h2>Job Close Form</h2>
        <form method="POST" action="{{ route('repair_job.closeSave', $job->id) }}">
            @csrf

                <div class="row">
                    <div class="col-lg-12">
                        <div class="pre-scrollable">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="10%">Item No</th>
                                            <th width="20%">Item Price</th>
                                            <th width="60%">Item Name</th>
                                            <th width="10%">Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 1; $i < 30; $i++)
                                            <tr>
                                                <td><input type="text" name="itemNo_{!! $i !!}" readonly
                                                        id="itemNo_{!! $i !!}" class="form-control"
                                                        autocomplete="off" @if ($i <= $count) value={{$jobDetails[$i-1]->component_id }}@endif></td>
                                                <td><input type="number" name="itemPrice_{!! $i !!}" readonly
                                                        id="itemPrice_{!! $i !!}" class="form-control"
                                                        autocomplete="off" @if ($i <= $count) value={{$jobDetails[$i-1]->component_price }}@endif></td>
                                                <td><input type="text" name="itemName_{!! $i !!}"
                                                        id="itemName_{!! $i !!}" class="form-control"
                                                        autocomplete="off" @if ($i <= $count) value={{$jobDetails[$i-1]->component->name }}@endif></td>
                                                <td><input type="text" name="quantity_{!! $i !!}"
                                                        id="quantity_{!! $i !!}" class="form-control changesNo"
                                                        autocomplete="off" ondrop="return false;" onpaste="return false;"
                                                        accesskey="a" @if ($i <= $count) value={{$jobDetails[$i-1]->qty }}@endif>
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

    </div>
    <div class="container pt-5">
        <h3> Charges </h3>
        <div class="form-group">
            <label for="repairCharges">Repair Charges</label>
            <input class="form-control" type="number" id="repairCharges" name="repairCharges" @if($job->current_status_id == 3) value = {{ $job->repair_charges }}@else value=0 @endif >
        </div>
        <div class="form-group">
            <label for="totalCharges">Total Charges</label>
            <input class="form-control" type="number" id="totalCharges" name="totalCharges" @if($job->current_status_id == 3) value = {{ $job->total_charges }}@else value=0 @endif>
        </div>
        <div class="form-group">
            <label for="discount">Discount</label>
            <input class="form-control" type="number" id="discount" name="discount" @if($job->current_status_id == 3) value = {{ $job->discount }}@else value=0 @endif>
        </div>
        <div class="form-group">
            <label for="finalTotal">Final Total</label>
            <input class="form-control" type="number" id="finalTotal" name="finalTotal" @if($job->current_status_id == 3) value = {{ $job->final_total }}@else value=0 @endif>
        </div>
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="common" id="commonIssue" name="commonIssue">
                <label class="form-check-label" for="commonIssue">
                    Common issue
                </label>
            </div>
        </div>


        <div id="common-area" style="display: none;">
            <div class="form-group">
                <select class="form-control" id="issueOld" name="issueOld">
                    @foreach ($issues as $issue)
                        <option value="{{ $issue->issue }}">{{ $issue->issue }}</option>
                    @endforeach

                </select>
            </div>
        </div>
        <div id="not-common-area">
            <div class="form-group">
                <h3> Issue </h3>
                <textarea class="form-control" type="textarea" id="issue" name="issue" rows="5" cols="30">
                    @if($job->current_status_id == 3) {{ $job->issue }}

                    @else

                    @endif
                </textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <a class="btn btn-block btn-secondary" href="{{ route('repair_job.index') }}" role="button">Go Back
                    to Index</a>
            </div>
            <div class="col-6">
                <button type="submit" class="btn btn-block btn-primary">Close Repair Job</button>
            </div>
        </div>
    </div>


    </form>
    <script>
        document.getElementById("commonIssue").addEventListener("click", displayissue);

        function displayissue() {
            if (document.getElementById("commonIssue").checked == true) {
                document.getElementById("common-area").style.display = 'block';
                document.getElementById("not-common-area").style.display = 'none';
            } else {
                document.getElementById("common-area").style.display = 'none';
                document.getElementById("not-common-area").style.display = 'block';
            }

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
                            productPrice: "{!! $p->price !!}"
                        },
                    @endforeach
                ],

                @for ($i = 1; $i < 30; $i++)
                    $('#itemName_{!! $i !!}').autocomplete({
                        source: plist,
                        minLength: 2,

                        select: function(event, ui) {
                            event.preventDefault();
                            $('#itemName_{!! $i !!}').val(ui.item.label);
                            this.value = ui.item.label;
                            $('#itemNo_{!! $i !!}').val(ui.item.productCode);
                            $('#itemPrice_{!! $i !!}').val(ui.item.productPrice);
                            $('#quantity_{!! $i !!}').val(0);
                        }

                    });
                @endfor
        });
    </script>

    <script type='text/javascript'>
        var totalComponentcharges = 0;

        @for ($t = 1; $t < 30; $t++)
            $("#quantity_{!! $t !!}").keyup(function() {

                var temp = 0;
                var inta = 0;
                var intab = 0;

                @for ($x = 1; $x < 30; $x++)
                    inta = $('#itemPrice_{!! $x !!}').val() * $('#quantity_{!! $x !!}')
                        .val();
                    intab = Number(inta);
                    temp = intab + temp;
                    totalComponentcharges = intab + totalComponentcharges;
                    console.log(temp);
                @endfor
                var dis = Number($('#discount').val());
                $('#totalCharges').val(temp + Number($("#repairCharges").val()));
                $('#finalTotal').val(temp - dis + Number($("#repairCharges").val()));

            });
        @endfor

        $("#repairCharges").keyup(function() {
            var totalComponentcharges1 = 0;
            var temp1 = 0;
            var inta1 = 0;
            var intab1 = 0;
            @for ($xy = 1; $xy < 30; $xy++)
                inta1 = $('#itemPrice_{!! $xy !!}').val() * $('#quantity_{!! $xy !!}')
                    .val();
                intab1 = Number(inta1);
                temp1 = intab1 + temp1;
                totalComponentcharges1 = intab1 + totalComponentcharges1;
                console.log(temp1);
            @endfor

            $('#totalCharges').val(totalComponentcharges1 + Number($("#repairCharges").val()));
            $('#finalTotal').val(Number($('#totalCharges').val()) - Number($('#discount').val()));

        });
        $("#discount").keyup(function() {
            $('#finalTotal').val(Number($('#totalCharges').val()) - Number($('#discount').val()));
        });
    </script>
</x-admin.nav>

