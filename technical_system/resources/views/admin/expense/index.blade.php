@extends('index2')
@section('content')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<section class="content">
    @include('components.datatableScriptHeader')

	<div class="container-fluid pt-2">
                <div class="row">
                            <div class="col-md-6">

                                <a href="{{ route('expense.create') }}" class="btn btn-primary ">Add new Expense</a>

                            </div>
                </div>
        <div class="pt-2">
	      	   <table id="myTable" class="display" width="100%">

                    <thead class="thead-dark">
                        <tr>

                            <th width=10%>ID</th>
                            <th width=20%>To</th>
                            <th>Date</th>
                            <th>Category</th>
                            <th>Method</th>
                            <th>Amount</th>
                            <th>User</th>
                            <th>Description</th>
                            <th>Show</th>


                          </tr>
                      </thead>
                      <tbody>
                      @if(count($expenses))
                            @foreach($expenses as $expense)
                            <tr>
                            <td>{!! $expense->id !!}</td>
                            <td>{!! $expense->to !!}</td>
                            <td>{!! $expense->actualDate !!}</td>
							<td>{!! $expense->category !!}</td>
                            <td>{!! $expense->method !!}</td>
                            <td>{!! $expense->amount !!}</td>
                            <td>{!! $expense->user_name !!}</td>
                            <td>{!! $expense->description !!}</td>
                            <td> <a href="{{ route('expense.show', $expense->id) }}" class="btn btn-primary">view</a></td>

                           </tr>
                            @endforeach
                            @else
                            <tr> No Data Found </tr>

                            @endif
                        </tbody>

                  </table>
          </div>

	</div>
    @include('components.datatableScript')




</section>




@endsection
