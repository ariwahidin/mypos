<section class="content-header">
    <h1>Add Stock
        <small>Add Stock From Excel File</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
        <li class="active">Add Stock From Excel</li>
    </ol>
</section>
<section class="content">
    <?php $this->view('messages') ?>
    <div class="row">
        <div class="col-md-4">
            <div class="box">
                <div class="box-header">
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>File Excel</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <form method="POST" action="<?= base_url('item/uploadExcel') ?>" enctype="multipart/form-data">
                                    <td>
                                        <input type="file" id="fileInput" name="fileInput" accept=".xls,.xlsx">
                                    </td>

                                    <td>
                                        <button name="submitBtn" class="btn btn-primary btn-flat btn-sm">
                                            Upload
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="tableContainer"></div>
<script>
    function readFile() {
        const file = document.getElementById("fileInput").files[0];
        const reader = new FileReader();
        reader.onload = function(event) {
            const data = event.target.result;
            const workbook = XLSX.read(data, {
                type: "binary"
            });
            const sheetName = workbook.SheetNames[0];
            const sheet = workbook.Sheets[sheetName];
            const html = XLSX.utils.sheet_to_html(sheet);
            document.getElementById("tableContainer").innerHTML = html;
        };
        reader.readAsBinaryString(file);
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/xlsx.full.min.js"></script>