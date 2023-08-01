@extends('layouts.app')

@section('content')
    <style>
        td.hidden {
            display: none;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card shadow-lg rounded">
                <div class="card-body">

                    <form id="productForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group  mb-3">
                                    <label for="itemProductSelect">Select Item Product: <span
                                            class="text-danger">*</span></label>
                                    <select id="IemProductSelect" class="form-control" name="product_id">
                                        <option value="">Select a product...</option>
                                        <!-- Add your product options here -->
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="bomUom">UOM: </label>
                                    <input type="text" id="bomUom" name="uom" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="bomQuantity">Quantity: <span class="text-danger">*</span></label>
                                    <input type="number" id="bomQuantity" name="quantity" class="form-control" required>
                                    <span class="text-muted">Quantity of item obtained after manufacturing/ repacking from given quantities of raw materials</span>
                                </div>

                            </div>
                            <div class="col-md-6 p-3">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" name="is_active" type="checkbox" value="1"
                                           id="isDefault">
                                    <label class="form-check-label" for="isDefault">Is Default</label>
                                </div>
                                <div class="form-check mt-3">
                                    <input class="form-check-input" name="is_default" type="checkbox" value="1"
                                           id="isActive">
                                    <label class="form-check-label" for="isActive">Is Active</label>
                                </div>
                                <div class="form-check mt-3">
                                    <input class="form-check-input" name="is_alternative" type="checkbox" value="1"
                                           id="allowAlternative">
                                    <label class="form-check-label" for="allowAlternative">Allow alternative
                                        item</label>
                                </div>
                                <div class="form-check mt-3">
                                    <input class="form-check-input" name="rate_set" type="checkbox" value="1"
                                           id="setRate">
                                    <label class="form-check-label" for="setRate">Set rate of sub-assembly item based on
                                        BOM</label>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="projectTitle">Project:</label>
                                    <input type="text" id="projectTitle" name="project" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group  col-md-4 mb-3">
                            <label for="itemMaterialSelect">Raw Material: <span class="text-danger">*</span></label>
                            <select id="itemMaterialSelect" class="form-control">
                                <option value="">Select a Material...</option>
                                @foreach($products as $product)
                                    <option value="{{$product}}">{{$product->name}}</option>
                                @endforeach

                            </select>
                        </div>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>UOM</th>
                                <th>Price</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="productTableBody">
                            <!-- Rows will be dynamically added here -->
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="">
                                <button type="submit" class="btn btn-primary float-end">Submit</button>

                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>

    <script>
        // Keep track of the selected products and their quantities
        let selectedProducts = [];

        // Function to update the table based on the selected product
        function updateTable() {
            const tableBody = document.getElementById('productTableBody');
            tableBody.innerHTML = '';

            // console.log(selectedProducts)
            let totalAmount = 0;

            for (const product in selectedProducts) {
                let parsedProduct = JSON.parse(product)
                // Calculate the amount

                parsedProduct.qty = selectedProducts[product];
                const amount = parsedProduct.qty * parsedProduct.price;

                // Create a new table row
                const newRow = document.createElement('tr');
                newRow.innerHTML =
                    `<td class="hidden">${product}</td>
                      <td>${parsedProduct.name}</td>
                      <td contenteditable="true">${parsedProduct.qty}</td>
                      <td>${parsedProduct.uom}</td>
                      <td>${parsedProduct.price}</td>
                      <td>${amount}</td>

                      <td><button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button></td>
                    `;

                // Append the row to the table body
                tableBody.appendChild(newRow);

                totalAmount += amount;
            }

            // Add a total row at the end
            const totalRow = document.createElement('tr');
            totalRow.innerHTML =
                `
                    <td colspan="4" class="text-right"><strong>Total Amount:</strong></td>
                    <td><strong>${totalAmount}</strong></td>
                `;
            tableBody.appendChild(totalRow);
        }

        // Function to handle product selection changes
        document.getElementById('itemMaterialSelect').addEventListener('change', function () {
            const selectedProduct = this.value;

            if (selectedProduct) {

                if (selectedProducts[selectedProduct]) {
                    console.log(selectedProducts[selectedProduct].qty)
                    selectedProducts[selectedProduct]++;
                } else {
                    selectedProducts[selectedProduct] = 1;
                }

                // Update the table with the latest data
                updateTable();
            }
        });

        // Function to handle quantity changes (when user edits quantity)
        document.getElementById('productTableBody').addEventListener('input', function (event) {
            const target = event.target;
            if (target.tagName === 'TD' && target.hasAttribute('contenteditable')) {
                const productName = target.parentElement.children[0].textContent;
                const newQuantity = parseInt(target.textContent) || 0;
                console.log(productName, selectedProducts[productName],newQuantity)
                selectedProducts[productName] = newQuantity;
                updateTable();
            }
        });

        // Function to handle row deletion
        function deleteRow(button) {
            const row = button.parentElement.parentElement;
            const productName = row.children[0].textContent;
            delete selectedProducts[productName];
            row.remove();
            updateTable();
        }

        // Function to handle form submission
        document.getElementById('productForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const data = {
                product_id: document.getElementById('IemProductSelect').value,
                project_title: document.getElementById('projectTitle').value,
                is_active: document.getElementById('isActive').value,
                is_default: document.getElementById('isDefault').value,
                rate_set: document.getElementById('setRate').value,
                allow_alternative: document.getElementById('allowAlternative').value,
                quantity: document.getElementById('bomQuantity').value,
                uom: document.getElementById('bomUom').value,
                rawMaterials: [],
                '_token': "{{ csrf_token() }}",
            };

            for (const product in selectedProducts) {
                data.rawMaterials.push({
                    product: product,
                    quantity: selectedProducts[product]
                });
            }

            // AJAX to post form data to the /bom endpoint
            $.ajax({
                type: 'POST',
                url: '/boms',
                data: JSON.stringify(data),
                contentType: 'application/json',
                success: function (response) {
                    console.log('Form submitted successfully:', response);
                    document.getElementById('productForm').reset();
                    selectedProducts = {};
                    updateTable();
                },
                error: function (error) {
                    console.error('Error submitting form:', error);
                }
            });
        });

    </script>
@endsection
