@extends('app/components/main')
@section('title', 'Transaksi Hari Ini')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">
                        Transaksi Hari Ini ({{ date('d M Y') }})
                    </h6>
                    <div>
                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                            data-bs-target="#modalTambahPemasukan">
                            <i class="fas fa-plus"></i> Tambah Pemasukan
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                            data-bs-target="#modalTambahPengeluaran">
                            <i class="fas fa-plus"></i> Tambah Pengeluaran
                        </button>
                    </div>
                </div>
                @if ($errors->count() > 0)
                    <div id="ERROR_COPY" style="display: none;">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br />
                        @endforeach
                    </div>
                @endif
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover display nowrap" id="dataTable" width="100%" cellspacing="0">
                            <thead class="text-center">
                                <tr>
                                    <th>No.</th>
                                    <th>Dibuat Oleh</th>
                                    <th>Kode Transaksi</th>
                                    <th>Tipe</th>
                                    <th>Paket Jasa</th>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Nominal Pemasukan</th>
                                    <th>Nominal Pengeluaran</th>
                                    <th>Waktu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $transaction->user->name }}</td>
                                        <td>{{ $transaction->transaction_code }}</td>
                                        @if ($transaction->type == 'income')
                                            <td>Pemasukan</td>
                                            <td>{{ $transaction->package->name }}</td>
                                            <td></td>
                                        @else
                                            <td>Pengeluaran</td>
                                            <td></td>
                                            <td>{{ $transaction->item->name }}</td>
                                        @endif
                                        <td>{{ $transaction->quantity }}</td>
                                        @if ($transaction->type == 'income')
                                            <td>Rp. {{ $transaction->getFormattedTotalAttribute() }}</td>
                                            <td></td>
                                        @else
                                            <td></td>
                                            <td>Rp. {{ $transaction->getFormattedTotalAttribute() }}</td>
                                        @endif
                                        <td>{{ $transaction->updated_at }}</td>
                                        <td scope="row" class="text-center">
                                            <a href="" data-bs-toggle="modal"
                                                data-bs-target="#modalUbahData{{ $transaction->id }}"
                                                class="btn btn-sm btn-dark">Ubah</a>
                                            <a href="{{ route('daily-transactions.destroy', $transaction->id) }}"
                                                class="btn btn-sm btn-danger btn-delete">Hapus</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal add pemasukan --}}
    <div class="modal fade" id="modalTambahPemasukan" tabindex="-1" aria-labelledby="modalTambahPemasukanLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahPemasukanLabel">Tambah Pemasukan</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('transactions.income.store') }}">
                        @csrf
                        <div id="add_form_pemasukan">
                            <div class="row mb-3">
                                <input type="hidden" name="noIncome[]" value="1">
                                <div class="col-md-5">
                                    <select class="form-control" name="packageIncome[]" id="packageIncome" required>
                                        <option value="" disabled selected>--- Paket Jasa ---</option>
                                        @foreach ($packages as $package)
                                            <option value="{{ $package->id }}">{{ $package->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="quantityIncome[]" id="quantityIncome"
                                        placeholder="Jumlah" value="1" min="1" required>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text font-weight-bold" id="basic-addon1">Rp.</span>
                                        </div>
                                        <input type="text" class="form-control bg-white" aria-describedby="basic-addon1"
                                            id="subtotalIncome" name="subtotalIncome[]" value="{{ old('subtotal') }}"
                                            placeholder="Sub Total" readonly required>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id="btn_add_row_pemasukan" class="btn btn-outline-info">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end of modal add pemasukan --}}

    {{-- modal add pengeluaran --}}
    <div class="modal fade" id="modalTambahPengeluaran" tabindex="-1" aria-labelledby="modalTambahPengeluaranLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahPengeluaranLabel">Tambah Pengeluaran</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('transactions.expense.store') }}">
                        @csrf
                        <div id="add_form_pengeluaran">
                            <div class="row mb-3">
                                <input type="hidden" name="noExpense[]" value="1">
                                <div class="col-md-5">
                                    <select class="form-control" name="itemExpense[]" id="item" required>
                                        <option value="" disabled selected>--- Barang ---</option>
                                        @foreach ($items as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="quantityExpense[]" id="quantity"
                                        placeholder="Jumlah" value="1" min="1" required>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text font-weight-bold" id="basic-addon1">Rp.</span>
                                        </div>
                                        <input type="number" class="form-control bg-white" aria-describedby="basic-addon1"
                                            id="subtotal" name="subtotalExpense[]" value="{{ old('subtotal') }}"
                                            placeholder="Sub Total" required>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id="btn_add_row_pengeluaran" class="btn btn-outline-info">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end of modal add pengeluaran --}}

    {{-- modal edit data --}}
    @foreach ($transactions as $transaction)
    <div class="modal fade" id="modalUbahData{{ $transaction->id }}" tabindex="-1" aria-labelledby="modalUbahDataLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUbahDataLabel">Ubah {{ $transaction->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('transactions.update',$transaction->id) }}">
                        @csrf
                        <div id="add_form_pengeluaran">
                            <div class="row mb-3">
                                <div class="col-md-5">
                                    @if ($transaction->type == 'income')
                                    <select class="form-control" name="package_id" id="packageIncome{{ $transaction->id }}"" required>
                                        <option value="" selected disabled>--- Paket Jasa ---</option>
                                        <option value="{{ $transaction->package_id }}" selected hidden>{{ $transaction->package->name }}</option>
                                        @foreach ($packages as $package)
                                            <option value="{{ $package->id }}">{{ $package->name }}</option>
                                        @endforeach
                                    </select>
                                    @else    
                                        <select class="form-control" name="item_id" required>
                                            <option value="" selected disabled>--- Barang ---</option>
                                            <option value="{{ $transaction->item_id }}" selected hidden>{{ $transaction->item->name }}</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="quantity" id="{{ $transaction->type == 'income' ? 'quantityIncome'.$transaction->id : 'quantity' }}"
                                        placeholder="Jumlah" value="{{ $transaction->quantity }}" min="1" required>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text font-weight-bold" id="basic-addon1">Rp.</span>
                                        </div>
                                        <input type="number" class="form-control bg-white" aria-describedby="basic-addon1"
                                            id="{{ $transaction->type == 'income' ? 'subtotalIncome'.$transaction->id : 'subtotal' }}" name="total" value="{{ $transaction->total }}"
                                            placeholder="Sub Total" required {{ $transaction->type == 'income' ? 'readonly' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    {{-- end of modal edit data --}}
@endsection

@section('javascript')
    <script type="text/javascript">
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                lengthMenu: [
                    [5, 10, 25, 50, 100, -1],
                    [5, 10, 25, 50, 100, "All"]
                ],
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ baris",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data",
                    "infoFiltered": "(pencarian dari _MAX_ data)",
                },
                responsive: true,
                stateSave: true, // keep paging
                "scrollX": true
            });

            $('.btn-delete').on('click', function(event) {
                event.preventDefault();
                const url = $(this).attr('href');
                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Data akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Hapus'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                })
            });

            $('#packageIncome').on('change',function(e){
                e.preventDefault();
                var id = $(this).val();
                $.ajax({
                    url: '/daily-transactions/get-package-price/' + id,
                    method: 'GET',
                    success: function(response){
                        var quantity = $('#quantityIncome');
                        var subtotal = $('#subtotalIncome');
                        var subtotalVal = quantity.val() * response.replace(".", "");

                        subtotal.val(subtotalVal);

                        quantity.on('change',function(){
                            subtotal.val(quantity.val() * response.replace(".", ""));
                        });
                    }
                });
            });

            x = 1
            $('#btn_add_row_pengeluaran').on('click',function(e){
                x++;
                e.preventDefault();
                $('#add_form_pengeluaran').append(`
                <div class="row mb-3">
                    <input type="hidden" name="noExpense[]" value="${x}">
                    <div class="col-md-5">
                        <select class="form-control" name="itemExpense[]" id="item" required>
                            <option value="" disabled selected>--- Barang ---</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" name="quantityExpense[]" id="quantity"
                            placeholder="Jumlah" value="1" min="1" required>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold" id="basic-addon1">Rp.</span>
                            </div>
                            <input type="number" class="form-control bg-white" aria-describedby="basic-addon1"
                                id="subtotal" name="subtotalExpense[]" value="{{ old('subtotal') }}"
                                placeholder="Sub Total" required>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" id="btn_add_row_pemasukan" class="btn btn-outline-danger btn-remove-form">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                `);
            });

            i = 1;
            $('#btn_add_row_pemasukan').on('click', function(e) {
                i++;
                e.preventDefault();
                $('#add_form_pemasukan').append(`
                    <div class="row mb-3">
                        <input type="hidden" name="noIncome[]" value="${i}">
                        <div class="col-md-5">
                            <select class="form-control" name="packageIncome[]" id="packageIncome${i}" required>
                                <option value="" disabled selected>--- Paket Jasa ---</option>
                                @foreach ($packages as $package)
                                    <option value="{{ $package->id }}">{{ $package->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="quantityIncome[]" id="quantityIncome${i}"
                                placeholder="Jumlah" value="1" min="1" required>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="basic-addon1">Rp.</span>
                                </div>
                                <input type="number" class="form-control bg-white" aria-describedby="basic-addon1"
                                    id="subtotalIncome${i}" name="subtotalIncome[]" value="{{ old('subtotal') }}"
                                    placeholder="Sub Total" readonly required>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button type="button" id="btn_add_row_pemasukan" class="btn btn-outline-danger btn-remove-form">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                `);
                var j = i;
                $('#packageIncome'+j).on('change',function(e){
                    e.preventDefault();
                    var id = $(this).val();
                    $.ajax({
                        url: '/daily-transactions/get-package-price/' + id,
                        method: 'GET',
                        success: function(response){
                            var quantity = $('#quantityIncome'+j);
                            var subtotal = $('#subtotalIncome'+j);
                            var subtotalVal = quantity.val() * response.replace(".", "");

                            subtotal.val(subtotalVal);

                            quantity.on('change',function(){
                                subtotal.val(quantity.val() * response.replace(".", ""));
                            });
                        }
                    });
                });
            });
        });

        // for edit data
        @foreach ($transactions as $transaction)
        $('#packageIncome{{ $transaction->id }}').on('change',function(e){
            e.preventDefault();
            var id = $(this).val();
            $.ajax({
                url: '/daily-transactions/get-package-price/' + id,
                method: 'GET',
                success: function(response){
                    var quantity = $('#quantityIncome{{ $transaction->id }}');
                    var subtotal = $('#subtotalIncome{{ $transaction->id }}');
                    var subtotalVal = quantity.val() * response.replace(".", "");

                    subtotal.val(subtotalVal);
                    
                    quantity.on('change',function(){
                        subtotal.val(quantity.val() * response.replace(".", ""));
                    });
                }
            });
        });
        @endforeach

        @foreach ($transactions as $transaction)
        $('#quantityIncome{{ $transaction->id }}').on('change',function(e){
            e.preventDefault();
            var id = $('#packageIncome{{ $transaction->id }}').val();
            $.ajax({
                url: '/daily-transactions/get-package-price/' + id,
                method: 'GET',
                success: function(response){
                    var package = $('#packageIncome{{ $transaction->id }}');
                    var quantity = $('#quantityIncome{{ $transaction->id }}');
                    var subtotal = $('#subtotalIncome{{ $transaction->id }}');
                    var subtotalVal = quantity.val() * response.replace(".", "");

                    subtotal.val(subtotalVal);

                    package.on('change',function(){
                        subtotal.val(quantity.val() * response.replace(".", ""));
                    });
                }
            });
        })
        @endforeach
        // end of for edit data


        $(document).on('click','.btn-remove-form',function(e){
            e.preventDefault();
            $(this).parent().parent().remove();
        });

        // validation error
        var has_errors = document.querySelector('#ERROR_COPY');

        if (has_errors !== null) {
            Swal.fire({
                title: 'Gagal',
                icon: 'error',
                html: jQuery('#ERROR_COPY').html(),
                showCloseButton: true
            })
        }
        // end of validation error
    </script>
@endsection
