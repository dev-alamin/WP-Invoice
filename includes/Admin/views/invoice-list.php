<div class="wrap">
      <form method="POST" action="<?php esc_url(admin_url('admin-post.php')) ?>">
      <h1><?php esc_html__( 'Invoice Page', 'frontend-form-submission' ) ?></h1>
      <?php 
        $table = new ADS\Admin\Invoice_List_Table();
        $table->prepare_items();
        $table->search_box( 'search', 'search_id' );
        $table->display();
        ?>
      <form>
      </div>