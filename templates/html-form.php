<div class="ads-frontend-form-submission">
    <form action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" id="ads-frontend-form-submission">
        <label for="amount"><?php _e('Amount:', 'ads-frontend-form-submission'); ?></label>
        <input type="text" name="amount" id="amount">

        <label for="buyer"><?php _e('Buyer:', 'ads-frontend-form-submission'); ?></label>
        <input type="text" name="buyer" id="buyer">

        <label for="receipt_id"><?php _e('Receipt ID:', 'ads-frontend-form-submission'); ?></label>
        <input type="text" name="receipt_id" id="receipt_id"><br><br>

        <label for="items"><?php _e('Items:', 'ads-frontend-form-submission'); ?></label>
        <input type="text" name="items" id="items">

        <label for="buyer_email"><?php _e('Buyer Email:', 'ads-frontend-form-submission'); ?></label>
        <input type="email" name="buyer_email" id="buyer_email">

        <label for="note"><?php _e('Note:', 'ads-frontend-form-submission'); ?></label>
        <textarea name="note" id="note" rows="4"></textarea>

        <label for="city"><?php _e('City:', 'ads-frontend-form-submission'); ?></label>
        <input type="text" name="city" id="city">

        <label for="phone"><?php _e('Phone:', 'ads-frontend-form-submission'); ?></label>
        <input type="text" name="phone" id="phone">
        
        <input type="hidden" name="action" value="handle_frontend_form_submission">
        <?php wp_nonce_field('frontend-form-submission-nonce', 'nonce'); ?>
        
        <!-- Error container -->
        <div id="error-container"></div>
        <div id="thankYou"></div>

        <input type="submit" value="<?php _e('Submit', 'ads-frontend-form-submission'); ?>">
    </form>
</div>
