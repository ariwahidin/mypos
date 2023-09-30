<section class="content-header">
	<h1>Customers
		<small>Pelanggan</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i></a></li>
		<li class="active">Customers</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

	<div class="box">
        <div class="box-header">
            <h3 class="box-title">Data Customers</h3>
            <div class="pull-right">
                <a href="<?=site_url('customer/add')?>" class="btn btn-primary btn-flat">
                    <i class="fa fa-plus"></i> Create
                </a>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table-customer">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

</section>
<script>

$('#table-customer').DataTable({
    "processing": true,
    "serverSide": true,
    "order":[],
    "ajax":{
        "url":"<?=site_url('pelanggan/get_json')?>",
        "type":"POST"
    },
    "columns":[
        {"data" : "no", width:40},
        {"data" : "name", width:150},
        {"data" : "gender", width:70},
        {"data" : "phone", width:120},
        {"data" : "address", width:150},
        {"data" : "action", width:100},
    ],
    "columnsDefs":[
        {"targets":[0,5],"orderable":false},
        {"targets":[2,-1],"className":"text-center"}
    ]
})

</script>