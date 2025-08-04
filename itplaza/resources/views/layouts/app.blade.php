<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title-block', 'Dashboard')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-resizable-columns@0.2.3/dist/jquery.resizableColumns.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/plugins/jquery.resizableColumns.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-storage-api@1.9.4/jquery.storageapi.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/resizable-columns@0.2.3/resizable-columns.css">
    <style>
        table.dataTable thead th {
            font-weight: normal !important;
            font-size: 0.75rem !important;
            white-space: nowrap;
        }

        table.dataTable th,
        table.dataTable td {
            padding-left: 4px !important;
            padding-right: 4px !important;
        }
    </style>
    <style>
        #serialsList input[type="text"] {
            padding: 2px 6px;
            font-size: 0.75rem;
            height: 24px;
            line-height: 1;
            margin: 0 !important;
            border-radius: 2px;
        }
        #serialsList {
            display: flex;
            flex-direction: column;
            gap: 1px;
            max-height: 120px;
            overflow-y: auto;
        }
    </style>
    <style>
        #stockInModal table.table tbody > tr.selected > td {
            background-color: #cce5ff !important;
        }
    </style>

</head>

<body class="bg-light">

    <nav class="navbar navbar-light bg-white border-bottom px-3 mb-0 d-flex justify-content-between">
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Main
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#stockInModal">Stock In</a></li>
                <li><a class="dropdown-item" href="#">Debt Repayment</a></li>
                <li><a class="dropdown-item" href="#">Exit</a></li>
                <li><a class="dropdown-item" href="#">Report Errors</a></li>
            </ul>

            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Directory
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Parts/Models</a></li>
                <li><a class="dropdown-item" href="#">Partners</a></li>
                <li><a class="dropdown-item" href="#">Users</a></li>
            </ul>

            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Report
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Incoming Report</a></li>
                <li><a class="dropdown-item" href="#">Outgoing</a></li>
                <li><a class="dropdown-item" href="#">Remainder</a></li>
                <li><a class="dropdown-item" href="#">Cash register</a></li>
                <li><a class="dropdown-item" href="#">Serials</a></li>
                <li><a class="dropdown-item" href="#">Incoming by partner</a></li>
                <li><a class="dropdown-item" href="#">Outgoing by partner</a></li>
                <li><a class="dropdown-item" href="#">Debts</a></li>
                <li><a class="dropdown-item" href="#">Cash Incoming/Outgoing</a></li>
                <li><a class="dropdown-item" href="#">Cash register close-out</a></li>
            </ul>

            <button class="btn btn-outline-secondary btn-sm">About the program</button>
        </div>

        <span class=" ms-auto text-muted">You are currently logged in as: <strong>{{ $username ?? 'Guest' }}</strong></span>
    </nav>

    <main class="container-fluid px-0" style="height:90dvh; display: flex; flex-direction: column;">
        @yield('content')
    </main>
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>-->
    <script>
        function makeColumnsResizable(table) {
            const cols = table.querySelectorAll('th');
            cols.forEach((col, index) => {
                col.style.position = 'relative';
                const resizer = document.createElement('div');
                resizer.style.width = '5px';
                resizer.style.height = '100%';
                resizer.style.position = 'absolute';
                resizer.style.right = '0';
                resizer.style.top = '0';
                resizer.style.cursor = 'col-resize';
                resizer.style.userSelect = 'none';
                resizer.style.zIndex = '1';

                col.appendChild(resizer);

                let startX, startWidth;

                resizer.addEventListener('mousedown', (e) => {
                    startX = e.pageX;
                    startWidth = col.offsetWidth;
                    document.addEventListener('mousemove', resize);
                    document.addEventListener('mouseup', stopResize);
                    e.preventDefault();
                });

                function resize(e) {
                    const newWidth = startWidth + (e.pageX - startX);
                    col.style.width = newWidth + 'px';
                }

                function stopResize() {
                    document.removeEventListener('mousemove', resize);
                    document.removeEventListener('mouseup', stopResize);
                }
            });
        }

        $(document).ready(function () {
            var orderDetailsStore = {};
            const itemTemplate = [
                { name: 'Processor',       warranty: 11 },
                { name: 'Mainboard',       warranty: 6  },
                { name: 'Cooler',          warranty: 0  },
                { name: 'Ram',             warranty: 11 },
                { name: 'Case',            warranty: 0  },
                { name: 'HDD',             warranty: 11 },
                { name: 'Keyboard',        warranty: 0  },
                { name: 'Mouse',           warranty: 0  },
                { name: 'Monitor',         warranty: 11 },
                { name: 'Video card',      warranty: 0  },
                { name: 'Cables',          warranty: 0  }
            ];
            const table = $('#orders-table').DataTable({
                autoWidth: false,
                paging: false,
                searching: false,
                ordering: false,
                columnDefs: [
                    { width: '80px', targets: 0 },
                    { width: '120px', targets: 1 }
                ]
            });

            $('#orders-table tbody').on('click', 'tr', function () {
                $('#orders-table tbody tr').removeClass('selected');
                $(this).addClass('selected');

                const orderId = $(this).children('td').first().text().trim();
                if (!orderId) return;

                renderDetailsForOrder(orderId);
            });

            $('#order-details-table tbody').on('input', 'input[data-field]', function() {
                const field = this.dataset.field;
                const rowIndex = parseInt(this.dataset.row, 10);
                const selectedOrderRow = $('#orders-table tbody tr.selected').first();
                if (!selectedOrderRow.length) return;
                const orderId = selectedOrderRow.children('td').first().text().trim();
                if (!orderId) return;

                const record = orderDetailsStore[orderId][rowIndex];
                if (field === 'sales_price' || field === 'quantity') {
                    record[field] = this.value === '' ? 0 : Number(this.value);
                } else {
                    record[field] = this.value;
                }
            });

            $('#detailsSaveBtn').on('click', function() {
                const selectedOrderRow = $('#orders-table tbody tr.selected').first();
                if (!selectedOrderRow.length) return;

                const orderId = selectedOrderRow.children('td').first().text().trim();
                if (!orderId) return;

                orderDetailsStore[orderId].forEach(r => r.locked = true);

                renderDetailsForOrder(orderId);

                // TODO: проверить роль пользователя (isAdmin) и показать Unlock, если нужно
            });

            $('#orders-table').resizableColumns({ store: window.store });
            makeColumnsResizable(document.querySelector('.dataTables_scrollHeadInner > table'));

            function renderDetailsForOrder(orderId) {
                const tbody = document.querySelector('#order-details-table tbody');
                tbody.innerHTML = '';

                // Если уже есть сохранённые данные для этого заказа — берём их,
                // иначе создаём по шаблону (sales_price = 0, quantity = 0).
                const rows = orderDetailsStore[orderId] || itemTemplate.map(it => ({
                    name: it.name,
                    model: '',
                    serial: '',
                    sales_price: 0,
                    quantity: 0,
                    warranty: it.warranty, // число месяцев
                    input_select: '',
                    locked: false  // признак «заблокировано после Save»
                }));

                rows.forEach((r, idx) => {
                    const tr = document.createElement('tr');
                    // Если заблокировано — делаем ячейки просто текстом, иначе input.
                    tr.innerHTML = `
                      <td>${r.name}</td>
                      <td>${r.locked ? (r.model || '') : `<input type="text" class="form-control form-control-sm" data-field="model" data-row="${idx}" value="${r.model}">`}</td>
                      <td>${r.locked ? (r.serial || '') : `<input type="text" class="form-control form-control-sm" data-field="serial" data-row="${idx}" value="${r.serial}">`}</td>
                      <td>${r.locked ? r.sales_price : `<input type="number" class="form-control form-control-sm" data-field="sales_price" data-row="${idx}" value="${r.sales_price}">`}</td>
                      <td>${r.locked ? r.quantity : `<input type="number" class="form-control form-control-sm" data-field="quantity" data-row="${idx}" value="${r.quantity}">`}</td>
                      <td>
                        ${r.locked
                            ? (r.warranty + ' month')
                            : `<div class="d-flex align-items-center">
                                <input type="number"
                                        class="form-control form-control-sm"
                                        data-field="warranty"
                                        data-row="${idx}"
                                        value="${r.warranty}">
                                <span class="ms-1">month</span>
                            </div>`}
                      </td>
                      <td>${r.locked ? (r.input_select || '') :
                        `<input type="text" class="form-control form-control-sm" data-field="input_select" data-row="${idx}" value="${r.input_select}">`}</td>
    `;
                    tbody.appendChild(tr);
                });

                orderDetailsStore[orderId] = rows;
            }

        });
    </script>
<div class="modal fade" id="stockInModal" tabindex="-1" aria-labelledby="stockInLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 1400px; width: 95%; height: 500px">
        <div class="modal-content border border-secondary" style="height: 600px; display: flex; flex-direction: column">
            <div class="modal-header py-2 bg-light border-bottom">
                <h6 class="modal-title" id="stockInLabel">Stock In</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-3 py-2 d-flex flex-column" style="max-height: 400px; overflow-y: auto;">
                <datalist id="partners-list"></datalist>
                <datalist id="barcodes-list"></datalist>
                <datalist id="models-list"></datalist>
                <div class="table-responsive small mb-0 flex-grow-1" style="max-height: unset; overflow-y: auto;">
                    <table class="table table-bordered table-sm mb-0 text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Partner</th>
                                <th>Product Type</th>
                                <th>Model</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Performer</th>
                                <th>Barcode</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--Здесь будут строки-->
                        </tbody>
                    </table>
                </div>

            </div>
            <!--Нижняя форма-->
            <div class="modal-footer px-3 py-2 border-top mt-auto">
                <form class="row gy-1 gx-2 align-items-center small w-100">
                    <div class="col-auto" style="width: 110px;">
                        <label class="form-label mb-0">Date</label>
                        <input type="date" id="stock-date" class="form-control form-control-sm">
                    </div>
                    <div class="col-auto">
                        <label class="form-label mb-0">Partner</label>
                        <input type="text" id="stock-partner" class="form-control form-control-sm" list="partners-list">
                    </div>
                    <div class="col-auto">
                        <label class="form-label mb-0">Barcode</label>
                        <input type="text" id="stock-barcode" class="form-control form-control-sm" list="barcodes-list" placeholder="barcode">
                    </div>
                    <div class="col-auto">
                        <label class="form-label mb-0">Product Type</label>
                        <select class="form-select form-select-sm" id="stock-type">
                            <option value="">Select</option>
                            <option>Accessories</option>
                            <option>Accessories DG</option>
                            <option>All-in-One Desktops</option>
                            <option>Auto Electronics</option>
                            <option>Barcode Scaner</option>
                            <option>Battery</option>
                            <option>Blender</option>
                            <option>Cables</option>
                            <option>Camera</option>
                            <option>Card Reader</option>
                            <option>Cartridge</option>
                            <option>Case</option>
                            <option>CCTV Accessories</option>
                            <option>CD disc</option>
                            <option>CLEANERS</option>
                            <option>Clock</option>
                            <option>Combine</option>
                            <option>Computer</option>
                            <option>Console</option>
                            <option>Constructor</option>
                            <option>Converter Adapter</option>
                            <option>Cooler</option>
                            <option>DVD Disc</option>
                            <option>DVD-RW</option>
                            <option>Fax</option>
                            <option>Filament</option>
                            <option>Flash USB</option>
                            <option>Fotoaparat</option>
                            <option>Furniture</option>
                            <option>Hairdrier</option>
                            <option>HDD</option>
                            <option>Headphone</option>
                            <option>Headset</option>
                            <option>Heraxos</option>
                            <option>Holder Monitor & TV</option>
                            <option>Iron</option>
                            <option>Juicer</option>
                            <option>Kettle/թեյնիկ</option>
                            <option>Keyboard</option>
                            <option>Lamp/Լամպ</option>
                            <option>Lan card</option>
                            <option>Laptop Screen</option>
                            <option>M2 SSD</option>
                            <option>Mainboard</option>
                            <option>Meat Grinder(msaxac)</option>
                            <option>Microphon</option>
                            <option>Mixer</option>
                            <option>Mobile Accessories</option>
                            <option>Monitor</option>
                            <option>Mouse</option>
                            <option>Netbook</option>
                            <option>Network</option>
                            <option>NOT & Ext HDD</option>
                            <option>NoteBook</option>
                            <option>NoteBook D</option>
                            <option>NoteBook K</option>
                            <option>Payusak</option>
                            <option>Perexodnik</option>
                            <option>Planshet</option>
                            <option>Power Supply</option>
                            <option>Printer</option>
                            <option>Processor</option>
                            <option>Proektor</option>
                            <option>Ram</option>
                            <option>RAM SODIMM</option>
                            <option>Raskulachit</option>
                            <option>Ruil</option>
                            <option>SATA Cable</option>
                            <option>Scales</option>
                            <option>Scaner</option>
                            <option>Skooter</option>
                            <option>Software</option>
                            <option>Sound Card</option>
                            <option>Speaker</option>
                            <option>Toaster</option>
                            <option>Tools</option>
                            <option>Tuxt A4</option>
                            <option>TV</option>
                            <option>TV tuner</option>
                            <option>UPS</option>
                            <option>UTP Cable</option>
                            <option>Vacuum Cleaner/Փոշեկուլ</option>
                            <option>Video card</option>
                            <option>VoIP Equipments</option>
                            <option>Waffle Iron</option>
                            <option>WebCam</option>
                            <option>Work</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <label class="form-label mb-0">Model</label>
                        <input type="text" id="stock-model" class="form-control form-control-sm" list="models-list">
                    </div>
                    <div class="col-auto">
                        <label class="form-label mb-0">Quantity</label>
                        <input type="number" id="stock-quantity" class="form-control form-control-sm">
                    </div>
                    <div class="col-auto">
                        <label class="form-label mb-0">Price</label>
                        <input type="number" id="stock-price" class="form-control form-control-sm">
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-between mt-2">
                        <div class="d-flex align-items-center">
                            <div class="form-check me-2">
                                <input class="form-check-input" type="checkbox" id="editCheckbox">
                                <label class="form-check-label" for="editCheckbox">Edit</label>
                            </div>
                            <button type="button" class="btn btn-success btn-sm d-none" id="saveStockInRow">Save</button>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary btn-sm" id="addStockInRow">Add</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-delete" id="deleteStockInRow">Delete</button>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="watchSeries">
                            <label class="form-check-label" for="watchSeries">Watch Series</label>
                            <div id="seriesPanel" class="mt-2 d-none border rounded p-2 bg-light small">
                                <label class="form-label">Serial Numbers:</label>
                                <div id="serialsList" class="mb-2">

                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary me-2" id="addSerialBtn">New</button>
                                <button type="button" class="btn btn-sm btn-outline-danger" id="deleteSerialBtn">Delete</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let selectedRow = null;
            let isEditing = false;
            let lastClickedRow = null;

            const watchSeriesCheckbox = document.getElementById('watchSeries');
            const seriesPanel = document.getElementById('seriesPanel');

            watchSeriesCheckbox.addEventListener('change', function () {
                if (this.checked && selectedRow) {
                    seriesPanel.classList.remove('d-none');

                    // Загрузим сериал номера
                    const storageCell = selectedRow.querySelector('.serials-storage');
                    const serials = storageCell?.innerText ? JSON.parse(storageCell.innerText) : [];

                    serialsList.innerHTML = '';
                    serials.forEach(serial => {
                        const input = document.createElement('input');
                        input.type = 'text';
                        input.value = serial;
                        serialsList.appendChild(input);
                    });
                } else {
                    seriesPanel.classList.add('d-none');
                    serialsList.innerHTML = '';
                }
            });

            const serialsList = document.getElementById('serialsList');
            const addSerialBtn = document.getElementById('addSerialBtn');
            const deleteSerialBtn = document.getElementById('deleteSerialBtn');

            addSerialBtn.addEventListener('click', function () {
                const input = document.createElement('input');
                input.type = 'text';
                input.className = 'form-control form-control-sm mb-1';
                input.placeholder = 'Serial number';
                serialsList.appendChild(input);
                saveSerialsToRow();
            });

            deleteSerialBtn.addEventListener('click', function () {
                if (serialsList.lastElementChild) {
                    serialsList.removeChild(serialsList.lastElementChild);
                    saveSerialsToRow();
                }
            });

            function saveSerialsToRow() {
                if (!selectedRow) return;

                const storageCell = selectedRow.querySelector('.serials-storage');
                const serials = Array.from(serialsList.querySelectorAll('input')).map(input => input.value.trim()).filter(val => val !== '');
                storageCell.innerText = JSON.stringify(serials);
            }

            document.getElementById('editCheckbox').addEventListener('change', function () {
                isEditing = this.checked;

                if (isEditing && selectedRow) {
                    fillFormFromRow(selectedRow);
                }
            });

            document.querySelector('#stockInModal table tbody').addEventListener('click', function (e) {
                const tr = e.target.closest('tr');
                if (!tr) return;

                if (selectedRow) selectedRow.classList.remove('selected');
                tr.classList.add('selected');
                selectedRow = tr;
                lastClickedRow = tr;

                if (isEditing) {
                    fillFormFromRow(tr);
                }

                if (watchSeriesCheckbox.checked) {
                    const storageCell = tr.querySelector('.serials-storage');
                    const serials = storageCell?.innerText ? JSON.parse(storageCell.innerText) : [];
                    serialsList.innerHTML = '';
                    serials.forEach(serial => {
                        const input = document.createElement('input');
                        input.type = 'text';
                        input.className = 'form-control form-control-sm mb-1';
                        input.value = serial;
                        serialsList.appendChild(input);
                    });
                }
            });

            const editCheckbox = document.getElementById('editCheckbox');
            const saveBtn = document.getElementById('saveStockInRow');

            editCheckbox.addEventListener('change', function () {
                if (this.checked) {
                    saveBtn.classList.remove('d-none');
                    if (lastClickedRow) {
                        fillFormFromRow(lastClickedRow);
                    }
                } else {
                    saveBtn.classList.add('d-none');
                }
            });

            document.getElementById('addStockInRow')?.addEventListener('click', function () {
                const tableBody = document.querySelector('#stockInModal table tbody');

                const date = document.getElementById('stock-date').value;
                const partner = document.getElementById('stock-partner').value;
                const barcode = document.getElementById('stock-barcode').value;
                const productType = document.getElementById('stock-type').value;
                const model = document.getElementById('stock-model').value;
                const quantity = document.getElementById('stock-quantity').value;
                const price = document.getElementById('stock-price').value;
                const performer = "Harut"; // пока временно фиксировано

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${date}</td>
                    <td>${partner}</td>
                    <td>${productType}</td>
                    <td>${model}</td>
                    <td>${quantity}</td>
                    <td>${price}</td>
                    <td>${performer}</td>
                    <td>${barcode}</td>
                    <td hidden class="serials-storage"></td>
                `;

                tableBody.appendChild(tr);

                function addToDatalist(id,value) {
                    const list = document.getElementById(id);
                    const options = Array.from(list.options).map(o => o.value);
                    if (!options.includes(value) && value.trim() !== '') {
                        const opt = document.createElement('option');
                        opt.value = value;
                        list.appendChild(opt);
                    }
                }

                addToDatalist('partners-list', partner);
                addToDatalist('barcodes-list', barcode);
                addToDatalist('models-list', model);
            });



            document.querySelector('#stockInModal .btn-delete')?.addEventListener('click', function () {
                if (selectedRow) {
                    selectedRow.remove();
                    selectedRow = null;
                }
            });

            document.querySelector('#deleteStockInRow')?.addEventListener('click', function () {
                if (selectedRow) {
                    selectedRow.remove();
                    selectedRow = null;
                }
            });

            document.getElementById('saveStockInRow').addEventListener('click', function () {
                console.log(selectedRow);
                if (!selectedRow) return;

                const cells = selectedRow.querySelectorAll('td');

                cells[0].innerText = document.getElementById('stock-date').value;
                cells[1].innerText = document.getElementById('stock-partner').value;
                cells[2].innerText = document.getElementById('stock-type').value;
                cells[3].innerText = document.getElementById('stock-model').value;
                cells[4].innerText = document.getElementById('stock-quantity').value;
                cells[5].innerText = document.getElementById('stock-price').value;
                cells[7].innerText = document.getElementById('stock-barcode').value;
            });
        });

        function fillFormFromRow(tr) {
            const cells = tr.querySelectorAll('td');
            document.getElementById('stock-date').value = cells[0].innerText;
            document.getElementById('stock-partner').value = cells[1].innerText;
            document.getElementById('stock-type').value = cells[2].innerText;
            document.getElementById('stock-model').value = cells[3].innerText;
            document.getElementById('stock-quantity').value = cells[4].innerText;
            document.getElementById('stock-price').value = cells[5].innerText;
            document.getElementById('stock-barcode').value = cells[7].innerText;
        }
    </script>
    <script>
        $(function () {
            $('#order-details-table').resizableColumns();
        });
    </script>
</body>
</html>
