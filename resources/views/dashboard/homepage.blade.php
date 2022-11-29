@extends('dashboard.base')

@section('content')

          <div class="container-fluid">
            <div class="fade-in">
              <div class="row">
                @if($role != 'user')
                <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-primary">
                    <div class="card-body pb-0">
                      <div class="text-value-lg">{{ count($data_konsumen) }}</div>
                      <div>Total Konsumen</div>
                    </div>
                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                      <canvas class="chart" id="card-chart1" height="70"></canvas>
                    </div>
                  </div>
                </div>
                @endif
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-info">
                    <div class="card-body pb-0">
                      <div class="text-value-lg">{{ count($data_reservasi) }}</div>
                      <div>Total Booking Tempat</div>
                    </div>
                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                      <canvas class="chart" id="card-chart2" height="70"></canvas>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-warning">
                    <div class="card-body pb-0">
                      <div class="text-value-lg">{{ count($data_pesanan) }}</div>
                      <div>Total Pemesanan Makanan</div>
                    </div>
                    <div class="c-chart-wrapper mt-3" style="height:70px;">
                      <canvas class="chart" id="card-chart3" height="70"></canvas>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-danger">
                    <div class="card-body pb-0">
                      <div class="text-value-lg">{{ count($data_pembayaran) }}</div>
                      <div>Total Pembayaran</div>
                    </div>
                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                      <canvas class="chart" id="card-chart4" height="70"></canvas>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
              </div>
              <!-- /.row-->
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-5">
                      <h4 class="card-title mb-0">Dashboard Pemesanan {{ $month }} {{ $year }}</h4>
                      <div class="small text-muted"></div>
                    </div>
                  </div>
                  <!-- /.row-->
                  <br>
                  <div class="c-chart-wrapper">
                    <figure class="highcharts-figure">
                        <div id="container"></div>
                    </figure>
                  </div>
                </div>
              </div>
              <!-- /.row-->
            </div>
          </div>

@endsection

@push('javascript')
    <script>
      pemesanan_tanggal = @json($pesanan->pluck('tanggal_pesanan'));
      pemesanan_count = @json($pesanan->pluck('id'));

      var pemesananCount = pemesanan_count.map(function (y) { 
          return parseInt(y); 
      });
      Highcharts.chart('container', {
                chart: {
                    backgroundColor: null,
                    style: {
                        color: "#4361ee"
                    }
                },
                title: {
                    text: '',
                    align: 'left',
                    style: {
                        color: "#4361ee"
                    }
                },
                xAxis: {
                    categories: pemesanan_tanggal,
                    labels:{
                        style: {
                            color: "#4361ee"
                        }
                    }
                },
                yAxis: {
                    title: {
                        text: 'Total Pemesanan',
                        style: {
                            color: "#4361ee"
                        }
                    },
                    labels:{
                        style: {
                            color: "#4361ee"
                        }
                    }
                },
                legend: {
                    itemStyle: {
                        color: '#4361ee',
                    },
                },
                exporting: { 
                    enabled: false 
                },
                credits: {
                    enabled: false
                },
                labels: {
                    items: [{
                        html: '',
                        style: {
                            left: '50px',
                            top: '18px',
                            color: ( // theme
                                Highcharts.defaultOptions.title.style &&
                                Highcharts.defaultOptions.title.style.color
                            ) || 'black'
                        }
                    }]
                },
                series: [{
                    type: 'column',
                    name: 'Column',
                    data: pemesananCount,
                }, {
                    type: 'spline',
                    name: 'Line',
                    data: pemesananCount,
                    marker: {
                        lineWidth: 2,
                        lineColor: Highcharts.getOptions().colors[3],
                        fillColor: 'white'
                    }
                }]
            });
    </script>
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
@endpush
