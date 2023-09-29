<section class="content-header">
    <h1>Version
        <small>Versi aplikasi</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <button id="btnCekUpdate" onclick="checkUpdate()" class="btn btn-primary">Check update</button>
        </div>
    </div>
</section>

<script>
    async function checkUpdate() {
        try {
            const url = "<?=base_url('Version/cekVersion')?>"
            const response = await fetch(url); // Ganti 'URL_API_ANDA' dengan URL server Anda.
            console.log(response);

            if (!response.ok) {
                throw new Error('Gagal mengambil data.'); // Tangani jika permintaan tidak berhasil.
            }

            const data = await response.json(); // Mengambil data JSON dari respons.

            // Lakukan logika pembaruan di sini berdasarkan data yang diterima.

            console.log('Data berhasil diambil:', data);
        } catch (error) {
            console.error('Terjadi kesalahan:', error.message);
        }
    }
</script>