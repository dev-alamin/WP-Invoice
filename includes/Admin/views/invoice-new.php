<div class="wrap">
    <h2><?php _e('Add Invoice', 'frontend-form-submission'); ?></h2>
    <form method="post" action="">
        <table class="form-table">
            <tbody>
                <tr class="row">
                    <th scope="row"><label for="amount">Amount:</label></th>
                    <td>
                        <input class="regular-text" type="text" name="amount" id="amount">
                        <?php if (isset($this->errors['amount'])) : ?>
                            <p class="description error"><?php echo esc_html($this->errors['amount']); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr class="row">
                    <th scope="row"><label for="buyer">Buyer:</label></th>
                    <td>
                        <input class="regular-text" type="text" name="buyer" id="buyer">
                        <?php if (isset($this->errors['buyer'])) : ?>
                            <p class="description error"><?php echo esc_html($this->errors['buyer']); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr class="row">
                    <th scope="row"><label for="receipt_id">Receipt ID:</label></th>
                    <td>
                        <input class="regular-text" type="text" name="receipt_id" id="receipt_id">
                        <?php if (isset($this->errors['receipt_id'])) : ?>
                            <p class="description error"><?php echo esc_html($this->errors['receipt_id']); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr class="row">
                    <th scope="row"><label for="items">Items:</label></th>
                    <td>
                        <input class="regular-text" type="text" name="items" id="items">
                        <?php if (isset($this->errors['items'])) : ?>
                            <p class="description error"><?php echo esc_html($this->errors['items']); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr class="row">
                    <th scope="row"><label for="buyer_email">Buyer Email:</label></th>
                    <td>
                        <input class="regular-text" type="email" name="buyer_email" id="buyer_email">
                        <?php if (isset($this->errors['buyer_email'])) : ?>
                            <p class="description error"><?php echo esc_html($this->errors['buyer_email']); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr class="row">
                    <th scope="row"><label for="note">Note:</label></th>
                    <td>
                        <textarea class="regular-text" name="note" id="note" rows="4"></textarea>
                        <?php if (isset($this->errors['note'])) : ?>
                            <p class="description error"><?php echo esc_html($this->errors['note']); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr class="row">
                    <th scope="row"><label for="city">City:</label></th>
                    <td>
                        <input class="regular-text" type="text" name="city" id="city">
                        <?php if (isset($this->errors['city'])) : ?>
                            <p class="description error"><?php echo esc_html($this->errors['city']); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr class="row">
                    <th scope="row"><label for="phone">Phone:</label></th>
                    <td>
                        <input class="regular-text" type="text" name="phone" id="phone">
                        <?php if (isset($this->errors['phone'])) : ?>
                            <p class="description error"><?php echo esc_html($this->errors['phone']); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <?php wp_nonce_field('invoice-nonce'); ?>
        <?php submit_button(__('Add new invoice', 'frontend-form-submission'), 'primary', 'add_invoice'); ?>
    </form>
</div>
