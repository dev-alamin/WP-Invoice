<div class="ads-frontend-form-submission">
    <form action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" id="ads-frontend-form-submission">
        <label for="amount">Amount:</label>
        <input type="text" name="amount" id="amount" required>

        <label for="buyer">Buyer:</label>
        <input type="text" name="buyer" id="buyer" required>

        <label for="receipt_id">Receipt ID:</label>
        <input type="text" name="receipt_id" id="receipt_id" required><br><br>

        <label for="items">Items:</label>
        <input type="text" name="items" id="items" required>

        <label for="buyer_email">Buyer Email:</label>
        <input type="email" name="buyer_email" id="buyer_email" required>

        <label for="note">Note:</label>
        <textarea name="note" id="note" rows="4" required></textarea>

        <label for="city">City:</label>
        <input type="text" name="city" id="city" required>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" required>
        
        <input type="hidden" name="action" value="handle_frontend_form_submission">
        <?php wp_nonce_field('frontend-form-submission-nonce', 'nonce'); ?>

        <input type="submit" value="Submit">
    </form>
</div>