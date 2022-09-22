@extends('app/components/main')
@section('title', 'Pembukuan')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">
                        Pembukuan
                    </h6>
                </div>
                @if ($errors->count() > 0)
                    <div id="ERROR_COPY" style="display: none;">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br />
                        @endforeach
                    </div>
                @endif
                <div class="card-body">
                    <div class="row justify-content-center">

                        <table class="mb-2" border="0" cellspacing="5" cellpadding="5">
                            <tbody>
                                <tr>
                                    <td>
                                        <input class="form-control form-control-sm" type="text" id="min" name="min" placeholder="Tanggal awal" required>
                                    </td>
                                    <td>s/d</td>
                                    <td>
                                        <input class="form-control form-control-sm" type="text" id="max" name="max" placeholder="Tanggal akhir" required>
                                    </td>
                                    <td>
                                        <button class="btn btn-success" id="search_date_range">Cari</button>
                                    </td>
                                    <td>
                                        <button type="reset" class="btn btn-warning" id="reset_date_range">Reset</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
                                    <th class="notexport" style="display: none;">Waktu</th>
                                    <th class="notexport">Aksi</th>
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
                                        <td>{{ $transaction->getFormattedCreatedAtAttribute() }}</td>
                                        <td style="display: none;">{{ $transaction->created_at }}</td>
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
                            <tfoot>
                                <tr class=" border-top">
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-center">Total Pemasukan</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="income_total">Rp. {{ $formatted_income_total }}</th>
                                    <th class="expense_total">Rp. {{ $formatted_expense_total }}</th>
                                    <th colspan="2"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <script>
        // var minDate, maxDate;
 
        // Custom filtering function which will search data in column four between two values
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                let min = moment($('#min').val()).isValid() ?
                    new Date( $('#min').val() ).setUTCHours(0,0,0,0) :
                    null;

                let max = moment($('#max').val()).isValid() ?
                    new Date( $('#max').val() ).setUTCHours(23,59,59,999):
                    null;
                var date = new Date( data[10] );
        
                if (
                    ( min === null && max === null ) ||
                    ( min === null && date <= max ) ||
                    ( min <= date   && max === null ) ||
                    ( min <= date   && date <= max )
                ) {
                    return true;
                }
                return false;
            }
        );

        $(document).ready(function() {
            // Create date inputs
            minDate = new DateTime($('#min'), {
                // format: 'D-MM-YYYY hh:mm:ss'
                format: 'YYYY-MM-DD'
                // format: 'MMMM Do YYYY'
            });
            maxDate = new DateTime($('#max'), {
                // format: 'D-MM-YYYY hh:mm:ss'
                format: 'YYYY-MM-DD'
                // format: 'MMMM Do YYYY'
            });

            var table = $('#dataTable').DataTable({

                buttons: [
                    {
                        extend:'csv',
                        text:'CSV',
                        className:'btn btn-success',
                        exportOptions: {
                            columns: 'th:not(.notexport)'
                        },
                        footer: true
                    }, 
                    {
                        extend:'print',
                        text:'Print',
                        className:'btn btn-success',
                        exportOptions: {
                            columns: 'th:not(.notexport)'
                        },
                        footer: true
                    },
                    {
                        extend:'excel',
                        text:'Excel',
                        className:'btn btn-success',
                        exportOptions: {
                            columns: 'th:not(.notexport)'
                        },
                        footer: true
                    },
                    {
                        extend:'pdf',
                        text:'PDF',
                        className:'btn btn-success',
                        exportOptions: {
                            columns: 'th:not(.notexport)'
                        },
                        footer: true
                    },
                    // {
                    //     extend:'colvis',
                    //     text:'Kolom',
                    //     className:'btn btn-success',
                    // },
                ],
                dom: "<'row'<'col-md-3'l><'col-md-5'B><'col-md-4'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                lengthMenu: [
                    [5, 10, 25, 50, 100, -1],
                    [5, 10, 25, 50, 100, "All"]
                ],

                fixedColumns: true,

                language: {

                    "search": "Cari:",

                    "lengthMenu": "Tampilkan _MENU_ baris",

                    "zeroRecords": "Data tidak ditemukan",

                    "info": "Halaman _PAGE_ dari _PAGES_",

                    "infoEmpty": "Tidak ada data",

                    "infoFiltered": "(pencarian dari _MAX_ data)",

                    "buttons": {
                        "colvis": "Kolom"
                    }

                },

                responsive: true,

                stateSave: true, // keep paging

                scrollX: true
            });

            // Refilter the table
            $('#search_date_range').on('click', function (e) {
                e.preventDefault();
                var minDate = $('#min').val();
                var maxDate = $('#max').val();
                $.ajax({
                    url: '/journal/get-total-value/'+ minDate + '/' + maxDate,
                    method: 'GET',
                    success: function(response){
                        var incomeTotal = $('.income_total');
                        var expenseTotal = $('.expense_total');

                        incomeTotal.text(response.formatted_income_total);
                        expenseTotal.text(response.formatted_expense_total);
                    }
                });
                table.draw();
            });
            
            $('#reset_date_range').on('click', function () {
                $('#min').val('');
                $('#max').val('');
                $('.income_total').text('Rp. {{ $formatted_income_total }}');
                $('.expense_total').text('Rp. {{ $formatted_expense_total }}');
                table.draw();
            });

            table.buttons().container()
                .appendTo('#dataTable_wrapper .col-md-5:eq(0)');

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
        });
    </script>
@endsection
