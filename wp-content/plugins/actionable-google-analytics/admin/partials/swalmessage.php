<?php
if($response == true){
echo "<script>
		swal({
			title: 'Success',
			text: 'Purchase code verification successfully completed',
			icon: 'success',
			buttons: {
				confirm: {
					text:'Go to Settings',
					visible:true,
					value: true,
					closeModal: true,
					className:'swal',
				},
			},
		}).then((ok) => {
			window.location ='". admin_url('admin.php?page=actionable-google-analytics-admin-display') ."' ;
		});
	</script>";
}else{
		echo '<script>
			swal({
			title: "Alert!",
			text: "'. $e->getMessage() .'",
			icon: "error",
			buttons: {
				confirm: {
					text:"Ok",
					visible:true,
					value: true,
					closeModal: true,
					className:"swal",
				},
			}
			});
		</script>';
}
?>