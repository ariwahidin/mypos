<section class="content-header">
  <h1>
    Dashboard
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-shopping-cart"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Items</span>
          <span class="info-box-number"><?= $this->fungsi->count_item() ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <!-- <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-truck"></i></span> -->

        <!-- <div class="info-box-content">
          <span class="info-box-text">Suppliers</span>
          <span class="info-box-number"><?= $this->fungsi->count_supplier() ?></span>
        </div> -->
        <!-- /.info-box-content -->
      <!-- </div> -->
      <!-- /.info-box -->
    <!-- </div> -->
    <!-- /.col -->

    <!-- fix for small devices only -->
    <!-- <div class="clearfix visible-sm-block"></div> -->

    <!-- <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span> -->

        <!-- <div class="info-box-content">
          <span class="info-box-text">Customers</span>
          <span class="info-box-number"><?= $this->fungsi->count_customer() ?></span>
        </div> -->
        <!-- /.info-box-content -->
      <!-- </div> -->
      <!-- /.info-box -->
    <!-- </div> -->
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fa fa-user-plus"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Users</span>
          <span class="info-box-number"><?= $this->fungsi->count_user() ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <div class="box box-solid">
    <div class="box-header">
      <i class="fa fa-th"></i>
      <h3 class="box-title">Produk Terlaris Bulan Ini</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-sm" data-widget="collapse">
          <i class="fa fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="box-body">
      <div class="graph" id="sales-bar"></div>
    </div>
  </div>

</section>
<link rel="stylesheet" href="<?=base_url()?>/assets/bower_components/morris.js/morris.css">
<script src="<?=base_url()?>/assets/bower_components/raphael/raphael.min.js"></script>
<script src="<?=base_url()?>/assets/bower_components/morris.js/morris.min.js"></script>
<script>
  //BAR CHART
  var bar = new Morris.Bar({
    element: 'sales-bar',
    resize: true,
    data: [
      // {y: '2006', a: 100, b: 90},
      // {y: '2007', a: 75, b: 65},
      // {y: '2008', a: 50, b: 40},
      // {y: '2009', a: 75, b: 65},
      // {y: '2010', a: 50, b: 40},
      // {y: '2011', a: 75, b: 65},
      // {y: '2012', a: 100, b: 90}
      <?php foreach($row as $key => $data){
        echo "{item:'". substr($data->name,0,20)."',sold:'".$data->sold."'},";
      }?>
    ],
    barColors: ['#00a65a', '#f56954'],
    xkey: 'item',
    // ykeys: ['a', 'b'],
    ykeys: ['sold'],
    labels: ['Sold'],
    hideHover: 'auto',
    xLabelAngle: '45',
    gridTextSize: '10',
    // gridTextWeight: '150',
    // resize: true,
  });
  $('svg').height('400');
</script>