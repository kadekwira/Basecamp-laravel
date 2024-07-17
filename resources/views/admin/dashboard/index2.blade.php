@extends('layouts.layoutAdmin')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Dashboard</h1>
    </div>
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="far fa-user"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Pelanggan</h4>
            </div>
            <div class="card-body">
              {{$customer}}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-danger">
            <i class="far fa-newspaper"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Barang Terjual</h4>
            </div>
            <div class="card-body">
              {{$totalJual}}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-warning">
            <i class="far fa-file"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Products</h4>
            </div>
            <div class="card-body">
              {{$product}}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-circle"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Order Pending</h4>
            </div>
            <div class="card-body">
              {{$order}}
            </div>
          </div>
        </div>
      </div>                  
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Statistics Transaction  </h4>
            <span class="badge badge-danger">IDR</span>
          </div>
          <div class="card-body">
            <canvas id="transactionChartBar" height="80%"></canvas>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Statistics Pengeluaran  </h4>
            <span class="badge badge-danger">IDR</span>
          </div>
          <div class="card-body">
            <canvas id="pengeluaranChartBar" height="80%"></canvas>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('addJavascript')
<script>
    var ctxTransaction = document.getElementById("transactionChartBar").getContext('2d');
    var transactionData = @json($transactionData);

    function formatRupiah(angka, prefix) {
        var number_string = angka.toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            var separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }


    var transactionChartBar = new Chart(ctxTransaction, {
        type: 'bar',
        data: {
            labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            datasets: [{
                label: 'Transaction',
                data: [transactionData[0],transactionData[1],transactionData[2],transactionData[3],transactionData[4],transactionData[5],transactionData[6],transactionData[7],transactionData[8],transactionData[9],transactionData[10],transactionData[11],],
                borderWidth: 2,
                backgroundColor: '#6777ef',
                borderColor: '#6777ef',
                borderWidth: 2.5,
                pointBackgroundColor: '#ffffff',
                pointRadius: 4
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        drawBorder: false,
                        color: '#f2f2f2',
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 200000,
                        callback: function(value) {
                            return formatRupiah(value, 'Rp');
                        }
                    }
                }],
                xAxes: [{
                    ticks: {
                        display: true
                    },
                    gridLines: {
                        display: false
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return formatRupiah(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index], 'Rp');
                    }
                }
            }
        }
    });
</script>
<script>
  var ctxTransaction = document.getElementById("pengeluaranChartBar").getContext('2d');
  var pengeluaranData = @json($pengeluaranData);

  function formatRupiah(angka, prefix) {
      var number_string = angka.toString(),
          split = number_string.split(','),
          sisa = split[0].length % 3,
          rupiah = split[0].substr(0, sisa),
          ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      if (ribuan) {
          var separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
  }


  var transactionChartBar = new Chart(ctxTransaction, {
      type: 'bar',
      data: {
          labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
          datasets: [{
              label: 'Transaction',
              data: [pengeluaranData[0],pengeluaranData[1],pengeluaranData[2],pengeluaranData[3],pengeluaranData[4],pengeluaranData[5],pengeluaranData[6],pengeluaranData[7],pengeluaranData[8],pengeluaranData[9],pengeluaranData[10],pengeluaranData[11],],
              borderWidth: 2,
              backgroundColor: '#6777ef',
              borderColor: '#6777ef',
              borderWidth: 2.5,
              pointBackgroundColor: '#ffffff',
              pointRadius: 4
          }]
      },
      options: {
          legend: {
              display: false
          },
          scales: {
              yAxes: [{
                  gridLines: {
                      drawBorder: false,
                      color: '#f2f2f2',
                  },
                  ticks: {
                      beginAtZero: true,
                      stepSize: 200000,
                      callback: function(value) {
                          return formatRupiah(value, 'Rp');
                      }
                  }
              }],
              xAxes: [{
                  ticks: {
                      display: true
                  },
                  gridLines: {
                      display: false
                  }
              }]
          },
          tooltips: {
              callbacks: {
                  label: function(tooltipItem, data) {
                      return formatRupiah(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index], 'Rp');
                  }
              }
          }
      }
  });
</script>
@endsection
