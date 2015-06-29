<div class="alert alert-error">
	<?php 
		if (is_array($_mesaj)) {
			foreach ($_mesaj as $_m) {
				echo '<p>'. $_m . '</p>';
			}
		} else {
			echo '<p>'. $_mesaj .'</p>';
		}
	
	?>
</div>