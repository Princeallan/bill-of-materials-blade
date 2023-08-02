@extends('layouts.app')

@section('content')

        <div class="container">


            <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="th-sm">#</th>
                    <th class="th-sm">Product Item</th>
                    <th class="th-sm">Material Count</th>
                    <th class="th-sm">quantity</th>
                    <th class="th-sm">UOM</th>
                    <th class="th-sm">Project</th>
                    <th class="th-sm">Is Active</th>
                    <th class="th-sm">Is Default</th>
                    <th class="th-sm">Allow alternative</th>
                    <th class="th-sm">Rate set</th>
                    <th class="th-sm">Date Added</th>

                </tr>
                </thead>
                <tbody>
                @foreach($boms as $key => $bom)
                    <tr>
                        <td> {{ $loop->iteration }}</td>
                        <td> {{ $bom->product->name }}</td>
                        <td> {{ $bom->items_count }}</td>
                        <td> {{ $bom->quantity }}</td>
                        <td> {{ $bom->uom }}</td>
                        <td> {{ $bom->project }}</td>
                        <td> {{ $bom->is_active == 1 ? "active" : "Inactive" }}</td>
                        <td> {{ $bom->is_default== 1 ? "active" : "Inactive" }}</td>
                        <td> {{ $bom->allow_alternative == 1 ? "active" : "Inactive" }}</td>
                        <td> {{ $bom->rate_set == 1 ? "active" : "Inactive" }}</td>
                        <td> {{ $bom->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th class="th-sm">#</th>
                    <th class="th-sm">Product Item</th>
                    <th class="th-sm">Material Count</th>
                    <th class="th-sm">quantity</th>
                    <th class="th-sm">UOM</th>
                    <th class="th-sm">Project</th>
                    <th class="th-sm">Is Active</th>
                    <th class="th-sm">Is Default</th>
                    <th class="th-sm">Allow alternative</th>
                    <th class="th-sm">Rate set</th>
                    <th class="th-sm">Date Added</th>
                </tr>
                </tfoot>
            </table>


        </div>

@endsection
