<div class="wrap">
    <h2>Edit Invoice</h2>
    <form method="post" action="">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="amount">Amount:</label></th>
                    <td>
                        <?php if (isset($invoice->amount)) : ?>
                            <input class="regular-text" type="text" name="amount" id="amount" value="<?php echo esc_attr($invoice->amount); ?>" required>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="buyer">Buyer:</label></th>
                    <td>
                        <?php if (isset($invoice->buyer)) : ?>
                            <input class="regular-text" type="text" name="buyer" id="buyer" value="<?php echo esc_attr($invoice->buyer); ?>" required>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="receipt_id">Receipt ID:</label></th>
                    <td>
                        <?php if (isset($invoice->receipt_id)) : ?>
                            <input class="regular-text" type="text" name="receipt_id" id="receipt_id" value="<?php echo esc_attr($invoice->receipt_id); ?>" required>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="items">Items:</label></th>
                    <td>
                        <?php if (isset($invoice->items)) : ?>
                            <input class="regular-text" type="text" name="items" id="items" value="<?php echo esc_attr($invoice->items); ?>" required>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="buyer_email">Buyer Email:</label></th>
                    <td>
                        <?php if (isset($invoice->buyer_email)) : ?>
                            <input class="regular-text" type="email" name="buyer_email" id="buyer_email" value="<?php echo esc_attr($invoice->buyer_email); ?>" required>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="note">Note:</label></th>
                    <td>
                        <?php if (isset($invoice->note)) : ?>
                            <textarea class="regular-text" name="note" id="note" rows="4" required><?php echo esc_textarea($invoice->note); ?></textarea>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="city">City:</label></th>
                    <td>
                        <?php if (isset($invoice->city)) : ?>
                            <input  class="regular-text"type="text" name="city" id="city" value="<?php echo esc_attr($invoice->city); ?>" required>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="phone">Phone:</label></th>
                    <td>
                        <?php if (isset($invoice->phone)) : ?>
                            <input class="regular-text" type="text" name="phone" id="phone" value="<?php echo esc_attr($invoice->phone); ?>" required>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <?php wp_nonce_field('invoice-nonce'); ?>
        <?php submit_button(__( 'Update Invoice', 'frontend-form-submission', 'primary', 'add_invoice' ) ); ?>
    </form>
</div>
