<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo esc_html__( 'Invoice Page', 'frontend-form-submission' ) ?></h1>
    <a href="<?php echo admin_url('admin.php?page=wp-invoice&action=new'); ?>" class="page-title-action"><?php echo _e( 'Add new', 'frontend-form-submission' ); ?></a>
      <form method="POST" action="<?php esc_url(admin_url('admin-post.php')) ?>">
        <?php 
            $table = new ADS\Admin\Invoice_List_Table();
            $table->prepare_items();
            $table->search_box( 'search', 'search_id' );
            $table->display();
            ?>
        <form>
      </div>