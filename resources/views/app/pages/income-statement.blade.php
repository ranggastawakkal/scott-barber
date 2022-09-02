@extends('app/components/main')
@section('title', 'Laba / Rugi')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">
                        Laba / Rugi
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
                        <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr style="display: none;">
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                                <tbody>
                                <tr>
                                    <th class="text-right">Periode :</th>
                                    <th><span class="from_date">{{ $from_date->created_at->format('d M Y') }}</span> - <span class="to_date">{{ $to_date->created_at->format('d M Y') }}</span></th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr class="tr-pendapatan">
                                    <th>Pendapatan</th>
                                    <th></th>
                                </tr>
                                @foreach ($packages as $key => $value)
                                    <tr class="all-time-income">
                                        <td>{{ $value->package->name }}</td>
                                        <td>Rp. {{ number_format($income_subtotal[$key]->total,0,',','.') }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th>Total Pendapatan</th>
                                    <th class="income_total">Rp. {{ $formatted_income_total }}</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th>Beban</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>Pengeluaran</td>
                                    <td class="expense_subtotal">Rp. {{ $formatted_expense_subtotal }}</td>
                                </tr>
                                <tr>
                                    <td>Biaya Listrik</td>
                                    <td>Rp. {{ $formatted_biaya_listrik }}</td>
                                </tr>
                                <tr>
                                    <td>Biaya Air</td>
                                    <td>Rp. {{ $formatted_biaya_air }}</td>
                                </tr>
                                <tr>
                                    <td>Biaya Gaji</td>
                                    <td>Rp. {{ $formatted_biaya_gaji }}</td>
                                </tr>
                                <tr>
                                    <th>Total Pengeluaran</th>
                                    <th class="expense_total">Rp. {{ $formatted_expense_total }}</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Laba / Rugi Bersih</th>
                                    <th class="cash_total">Rp. {{ $formatted_cash_total }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        // var minDate, maxDate;
 

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
                "pageLength":1000,

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
                ],
                dom: "<'row justify-content-center'<'col-md-3'B>>" +
                    "<'row'<'col-md-12'tr>>",
                ordering: false,
            });

            // Refilter the table
            $('#search_date_range').on('click', function (e) {
                e.preventDefault();
                var minDate = $('#min').val();
                var maxDate = $('#max').val();
                $.ajax({
                    url: '/journal/get-income-statement-value/'+ minDate + '/' + maxDate,
                    method: 'GET',
                    success: function(response){
                        var incomeTotal = $('.income_total');
                        var expenseSubtotal = $('.expense_subtotal');
                        var expenseTotal = $('.expense_total');
                        var cashTotal = $('.cash_total');
                        var packages = $('.packages');
                        var incomeSubtotal = $('.income_subtotal');
                        var fromDate = $('.from_date');
                        var toDate = $('.to_date');
                        var allTimeIncome = $('.all-time-income');
                        
                        incomeTotal.text(response.formatted_income_total);
                        expenseSubtotal.text(response.formatted_expense_subtotal);
                        expenseTotal.text(response.formatted_expense_total);
                        cashTotal.text(response.formatted_cash_total);

                        $('.all-time-income td').replaceWith('<th class="notexport">' + $('.all-time-income td').html() + '</th>');
                        allTimeIncome.remove();

                        let text = "";
                        
                        response.income_subtotal.forEach(function(item, index){
                            text += "<tr><td>"+ JSON.stringify(response.packages[index]['name']).replace(/"/g, "") +"</td><td>"+ JSON.stringify(response.income_subtotal[index]['total']).replace(/"/g, "") +"</td></tr>";
                        });

                        $('.tr-pendapatan').after(text);

                        
                        fromDate.text(response.from_date);
                        toDate.text(response.to_date);
                    }
                });
                table.draw();
            });
            
            $('#reset_date_range').on('click', function () {
                $('#min').val('');
                $('#max').val('');
                $('.income_total').text('Rp. {{ $formatted_income_total }}');
                $('.expense_subtotal').text('Rp. {{ $formatted_expense_subtotal }}');
                $('.cash_total').text('Rp. {{ $formatted_cash_total }}');
                $('.from_date').text('{{ $from_date->created_at->format('d M Y') }}');
                $('.to_date').text('{{ $to_date->created_at->format('d M Y') }}');
                table.draw();
            });

            table.buttons().container()
                .appendTo('#dataTable_wrapper .col-md-5:eq(0)');
        });
    </script>
@endsection
