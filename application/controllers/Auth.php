<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function login()
	{
		check_already_login();
		$this->load->view('login');
	}

	public function process()
	{
		$post = $this->input->post(null, TRUE);
?>
		<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2/sweetalert2.min.css">
		<script src="<?= base_url() ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
		<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert2/animate.min.css">
		<style>
			body {
				font-family: "Helvetica Neue", Helvetica, Arial, Helvetica, sans-serif;
				font-size: 1.124em;
				font-weight: normal;
			}
		</style>

		<body></body>
		<?php
		if (isset($post['login'])) {
			$this->load->model('user_m');
			$query = $this->user_m->login($post);
			if ($query->num_rows() > 0) {
				$row = $query->row();
				$params = array(
					'userid' => $row->user_id,
					'level' => $row->level,
					'username' =>$row->username
				);
				$this->session->set_userdata($params);
		?>
				<script>
					Swal.fire({
						// position: 'top-end',
						icon: 'success',
						title: 'Selamat, login berhasil',
						showConfirmButton: false,
						timer: 1500
					}).then((result) => {
						window.location = "<?= site_url('dashboard') ?>"
					})
				</script>
			<?php
			} else {
			?>
				<script>
					Swal.fire({
						icon: 'error',
						title: 'Failure',
						text: 'Login gagal, username / password salah',
						showClass: {
							popup: 'animate__animated animate__swing'
						},
					}).then((result) => {
						window.location = "<?= site_url('auth/login') ?>"
					})
				</script>
<?php
			}
		}
	}

	public function logout()
	{
		$params = array('userid', 'level','username');
		$this->session->unset_userdata($params);
		redirect('auth/login');
	}
}
