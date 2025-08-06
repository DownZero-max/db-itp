@extends('layouts.app')

@section('title-block', 'Orders')

@section('content')

    <div class="w-100" style="margin: 0; padding: 0; height: 90vh; display: flex; flex-direction: column;">

    <!-- Верхняя часть: таблица заказов -->
        <div class="border rounded bg-white overflow-y-auto overflow-x-hidden px-2 pb-2" style="height: 300px; position: relative;">
            <table id="orders-table"
                   class="table table-bordered table-sm align-middle text-center mb-0 resizable-columns resizable"
                   data-resizable-columns-id="orders-main"
                   style="width:100%">
                <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Date Compl.</th>
                    <th>Name, Last Name</th>
                    <th>Phone</th>
                    <th>Payment</th>
                    <th>Transfer</th>
                    <th>Check</th>
                    <th>Wrong</th>
                    <th>Verified</th>
                    <th>Incompl.</th>
                    <th>Performer</th>
                    <th>Delivery</th>
                    <th>Address</th>
                    <th>About Delivery</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->date }}</td>
                        <td>{{ $order->date_completed }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->phone_number }}</td>
                        <td>{{ $order->payment ? '$' : '' }}</td>
                        <td>{{ $order->transfer ? '⮳' : '' }}</td>
                        <td>{{ $order->check ? '🧾' : '' }}</td>
                        <td>{{ $order->wrong ? '🧱' : '' }}</td>
                        <td>{{ $order->verified ? '✔' : '' }}</td>
                        <td>{{ $order->incomplete ? '🚩' : '' }}</td>
                        <td>{{ $order->performer }}</td>
                        <td>{{ $order->delivery ? '✈' : '' }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ $order->about_delivery }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="border rounded bg-light p-3 d-flex gap-3" style="flex: 1 1 40%; overflow-y: visible;">
        <div style="width: 90px;" class="d-flex flex-column gap-0">
                <input type="text" class="form-control form-control-sm px-0 py-0" placeholder="barcode">
                <button class="btn btn-outline-secondary btn-sm px-0 py-0">...</button>
                <button class="btn btn-outline-primary btn-sm px-0 py-0">+</button>
                <button class="btn btn-outline-danger btn-sm px-0 py-0">-</button>
                <button class="btn btn-outline-warning btn-sm px-0 py-0">Undo</button>
                <button id="detailsSaveBtn" class="btn btn-outline-success btn-sm px-0 py-0">Save</button>
                <button class="btn btn-outline-dark btn-sm px-0 py-0">Word</button>
                <button class="btn btn-outline-info btn-sm px-0 py-0">Guarant.</button>
                <div class="form-check mt-1">
                    <input class="form-check-input" type="checkbox" id="himselfCheck">
                    <label class="form-check-label small" for="himselfCheck">Cost Pr.</label>
                </div>
            </div>
            <div class="d-flex flex-column flex-grow-1" style="height: 100%; width: 100%;">
                <!-- Верх: логотип и кнопки -->
                <div class="d-flex align-items-center justify-content-between bg-white p-2 border-bottom mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ asset('img/logo.svg') }}" alt="Logo" style="height:32px;">
                        <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addOrderModal">Add
                        </button>
                        <button class="btn btn-outline-secondary btn-sm">Edit</button>
                        <button class="btn btn-outline-secondary btn-sm">Delete</button>
                        <button class="btn btn-outline-secondary btn-sm">Filter</button>
                        <input type="text" class="form-control form-control-sm" placeholder="fast pass" style="width:120px;">
                    </div>
                </div>

                <!-- Центр: текст -->
                <div class="overflow-y-auto mb-2 w-100" style="max-height: 200px; overflow-x: hidden; min-width: 100%;">
                    <table class="table table-bordered table-sm mb-0 text-center align-middle resizable-columns resizable" data-resizable-columns-id="order-details" id="order-details-table" style="width: 100%;">
                        <thead class="table-light">
                        <tr>
                            <th data-resizable-column-id="name">Name</th>
                            <th data-resizable-column-id="model">Model</th>
                            <th data-resizable-column-id="serial">Serial №</th>
                            <th data-resizable-column-id="sales_price">Sales price</th>
                            <th data-resizable-column-id="quantity">Quantity</th>
                            <th data-resizable-column-id="warranty">Warranty</th>
                            <th data-resizable-column-id="input_select">Input select</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Строки появятся динамически -->
                        </tbody>
                    </table>
                </div>

                <!-- Низ: сумма и кнопки -->
                <div class="border-top pt-2 d-flex align-items-center gap-2">
                    <span class="fw-bold small">Σ payment</span>
                    <span class="text-primary small">0</span>

                    <button class="btn btn-outline-secondary btn-sm px-3 py-1" style="margin-left: 300px;">Pay...</button>

                    <label for="debtField" class="form-label mb-0 ms-3 small">Debt</label>
                    <input id="debtField" type="text" class="form-control form-control-sm" placeholder="0" style="width: 70px;">
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addOrderModal" tabindex="-1" aria-labelledby="addOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 500px; max-height: 90vh;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addOrderModalLabel">Add/Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 69vh; overflow-y: auto;">
                    <!-- ID (always =NEW=)-->
                    <div class="row mb-0 align-items-center">
                        <label class="col-4 col-form-label small" style="font-size: 0.95rem; height: calc(1.5em + .5rem + 2px);">ID</label>
                        <div class="col-8">
                            <select class="form-select form-select-sm" disabled>
                                <option>=NEW=</option>
                            </select>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="row mb-0 align-items-center">
                        <label class="col-4 col-form-label small" style="font-size: 0.95rem; height: calc(1.5em + .5rem + 2px);">Date</label>
                        <div class="col-8">
                            <input type="date" class="form-control form-control-sm" name="date">
                        </div>
                    </div>

                    <!-- Date Completed -->
                    <div class="row mb-0 align-items-center">
                        <label class="col-4 col-form-label small" style="font-size: 0.95rem; height: calc(1.5em + .5rem + 2px);">Date Completed</label>
                        <div class="col-8">
                            <input type="date" class="form-control form-control-sm" name="date_completed">
                        </div>
                    </div>

                    <!-- Name, Last Name -->
                    <div class="row mb-0 align-items-center">
                        <label class="col-4 col-form-label small" style="font-size: 0.95rem; height: calc(1.5em + .5rem + 2px);">Name, Last Name</label>
                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" name="name">
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="row mb-0 align-items-center">
                        <label class="col-4 col-form-label small" style="font-size: 0.95rem; height: calc(1.5em + .5rem + 2px);">Phone</label>
                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" name="phone">
                        </div>
                    </div>

                    <!-- Checkbox Section -->
                    <div class="row py-0 align-items-center">
                        <label class="col-4 col-form-label small mb-0 d-flex align-items-center pe-1" for="paymentCheck" style="font-size: 0.95rem;">Payment</label>
                        <div class="col-8 py-0">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" id="paymentCheck">
                            </div>
                        </div>
                    </div>
                    <div class="row py-0 align-items-center">
                        <label class="col-4 col-form-label small mb-0 d-flex align-items-center pe-1" for="transferCheck" style="font-size: 0.95rem;">Transfer</label>
                        <div class="col-8 py-0">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" id="transferCheck">
                            </div>
                        </div>
                    </div>
                    <div class="row py-0 align-items-center">
                        <label class="col-4 col-form-label small mb-0 d-flex align-items-center pe-1" for="checkCheck" style="font-size: 0.95rem;">Check</label>
                        <div class="col-8 py-0">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" id="checkCheck">
                            </div>
                        </div>
                    </div>
                    <div class="row py-0 align-items-center">
                        <label class="col-4 col-form-label small mb-0 d-flex align-items-center pe-1" for="wrongCheck" style="font-size: 0.95rem;">Wrong</label>
                        <div class="col-8 py-0">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" id="wrongCheck">
                            </div>
                        </div>
                    </div>
                    <div class="row py-0 align-items-center">
                        <label class="col-4 col-form-label small mb-0 d-flex align-items-center pe-1" for="verifiedCheck" style="font-size: 0.95rem;">Verified(lock)</label>
                        <div class="col-8 py-0">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" id="verifiedCheck">
                            </div>
                        </div>
                    </div>
                    <div class="row py-0 align-items-center">
                        <label class="col-4 col-form-label small mb-0 d-flex align-items-center pe-1" for="deliveryCheck" style="font-size: 0.95rem;">Delivery</label>
                        <div class="col-8 py-0">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" id="deliveryCheck">
                            </div>
                        </div>
                    </div>

                    <!-- Address & Time (скрыты до клика "Delivery") -->
                    <div id="deliveryFields" class="mt-2 d-none">
                        <div class="row mb-0 align-items-center">
                            <label class="col-4 col-form-label small" style="font-size: 0.95rem; height: calc(1.5em + .5rem + 2px);">Address</label>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" name="address">
                            </div>
                        </div>
                        <div class="row mb-0 align-items-center mt-1">
                            <label class="col-4 col-form-label small" style="font-size: 0.95rem; height: calc(1.5em + .5rem + 2px);">Time</label>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" name="time">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" id="saveOrderBtn">OK</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
<style>
    #order-details-table {
        width: 100% !important;
        table-layout: auto !important;
        }

    #order-details-table th,
    #order-details-table td {
        white-space: nowrap;
        }

    .flex-grow-1.overflow-auto.mb-2 {
        width: 100% !important;
    }

    #orders-table {
        table-layout: fixed !important;
    }

    #orders-table thead th {
        position: sticky;
        top: 0;
        background-color: #fff;
        z-index: 100;
    }

    .dataTables_scrollBody tbody tr.selected td {
        background-color: #cce5ff !important;
    }
</style>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
       const deliveryCheckbox = document.getElementById('deliveryCheck');
       const deliveryFields = document.getElementById('deliveryFields');

       deliveryFields.classList.toggle('d-none', !deliveryCheckbox.checked);

       deliveryCheckbox.addEventListener('change', function () {
           deliveryFields.classList.toggle('d-none', !this.checked);
       });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('saveOrderBtn').addEventListener('click', function () {
            const date = document.querySelector('input[name="date"]').value;
            const dateCompleted = document.querySelector('input[name="date_completed"]').value;
            const name = document.querySelector('input[name="name"]').value;
            const phone = document.querySelector('input[name="phone"]').value;

            const payment = document.getElementById('paymentCheck').checked;
            const transfer = document.getElementById('transferCheck').checked;
            const check = document.getElementById('checkCheck').checked;
            const wrong = document.getElementById('wrongCheck').checked;
            const verified = document.getElementById('verifiedCheck').checked;
            const delivery = document.getElementById('deliveryCheck').checked;
            const address = delivery ? document.querySelector('input[name="address"]').value : '';
            const aboutDelivery = delivery ? document.querySelector('input[name="time"]').value : '';

            // Подсчет нового ID
            const tableBody = document.querySelector('#orders-table tbody');
            const nextId = tableBody.rows.length + 1;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${nextId}</td>
                <td>${date}</td>
                <td>${dateCompleted}</td>
                <td>${name}</td>
                <td>${phone}</td>
                <td>${payment ? '$' : ''}</td>
                <td>${transfer ? '⮳' : ''}</td>
                <td>${check ? '🧾' : ''}</td>
                <td>${wrong ? '🧱' : ''}</td>
                <td>${verified ? '✔' : ''}</td>
                <td>${wrong || !verified ? '🚩' : ''}</td>
                <td>-</td>
                <td>${delivery ? '✈' : ''}</td>
                <td>${address}</td>
                <td>${aboutDelivery}</td>
            `;
            tableBody.appendChild(tr);

            // Уведомляем DataTables, что появилась строка
            $('#orders-table').DataTable().row.add($(tr)).draw();

            // Закрываем модалку вручную
            const modal = bootstrap.Modal.getInstance(document.getElementById('addOrderModal'));
            modal.hide();

        });
    });
</script>
