<footer class="main-footer">
	<strong>Copyright &copy; <?php echo date("Y"); ?>
		<a href="<?php echo base_url() ?>">Jorgi Fatwa Ambia</a>.
	</strong>
	All rights reserved.
	<div class="float-right d-none d-sm-inline-block">
		<b>Version</b> 0.0.1
	</div>
</footer>
<script>
    $('#fileupload').fileupload({
        url: "<?php echo base_url() ?>/motor/upload", // Your server-side upload handler
        dataType: 'json',
        done: function (e, data) {
            console.log("File uploaded:", data.result);
        },
        fail: function (e, data) {
            console.error("Error uploading file:", data.errorThrown);
        }
    });
</script>