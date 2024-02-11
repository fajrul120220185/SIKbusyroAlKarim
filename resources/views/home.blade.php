@extends('partial.main')

@section('content')

    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- AREA CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Pemasukan dan Pengeluaran</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- DONUT CHART -->
            
            <!-- /.card -->

           

          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-6">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Pemasukan</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>

          <div class="col-md-6">
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Gaji</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="donutChartpengeluaran" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
      <!-- /.container-fluid -->
@endsection

@section('custom_js')

<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
 

    // Bar Chart
    var barChartCanvas = $('#barChart').get(0).getContext('2d');
var barChartData = <?php echo json_encode($areaChartData); ?>; // Ganti dengan variabel yang sesuai
var temp0 = barChartData.datasets[0];
var temp1 = barChartData.datasets[1];
barChartData.datasets[0] = temp1;
barChartData.datasets[1] = temp0;

var barChartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  datasetFill: false
}

new Chart(barChartCanvas, {
  type: 'bar',
  data: barChartData,
  options: barChartOptions
})

    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData = <?php echo json_encode($donutChartData); ?>;
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })

    var donutChartCanvas = $('#donutChartpengeluaran').get(0).getContext('2d')
    var donutData = <?php echo json_encode($donutChartPengeluaran); ?>;
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })
  })
  
</script>

@endsection