/*================================================================================
	Item Name: Materialize - Material Design Admin Template
	Version: 3.0
	Author: GeeksLabs
	Author URL: http://www.themeforest.net/user/geekslabs
================================================================================

NOTE:
------
PLACE HERE YOUR OWN JS CODES AND IF NEEDED.
WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR CUSTOM SCRIPT IT'S BETTER LIKE THIS. */

function logout(e) {
	swal({
		title: "Keluar Aplikasi",
		text: "Apakah anda yakin ingin keluar dari Sistem ?",
		icon: "warning",
		buttons: true,
	}).then((willDelete) => {
		if (willDelete) {
		  document.getElementById('logout-form').submit();
		}
	});
}