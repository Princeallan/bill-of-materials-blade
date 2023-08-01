@extends('layouts.app')

@section('content')
    <div class="container">


        <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="th-sm">#</th>
                <th class="th-sm">Name</th>
                <th class="th-sm">uom</th>
                <th class="th-sm">quantity</th>
                <th class="th-sm">Is Active</th>
                <th class="th-sm">Date Added</th>

            </tr>
            </thead>
            <tbody>
            @foreach($products as $key => $product)
                <tr>
                    <td> {{ $loop->iteration }}</td>
                    <td> {{ $product->name }}</td>
                    <td> {{ $product->uom }}</td>
                    <td> {{ $product->quantity }}</td>
                    <td> {{ $product->is_active == 1 ? "active" : "Inactive" }}</td>
                    <td> {{ $product->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th class="th-sm">#</th>
                <th class="th-sm">Name</th>
                <th class="th-sm">uom</th>
                <th class="th-sm">quantity</th>
                <th class="th-sm">Is Active</th>
                <th class="th-sm">Date Added</th>
            </tr>
            </tfoot>
        </table>


    </div>
@endsection
