<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
use SimpleReset\Log;

$logs = Log::get();

?>
<table class="widefat striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Action</th>
            <th>Description</th>
            <th>User</th>
            <th>IP</th>
            <th>Date</th>
        </tr>
    </thead>

    <tbody>

    <?php foreach ( $logs as $log ) : ?>

        <tr>

            <td><?php echo esc_html( $log['id'] ); ?></td>

            <td><?php echo esc_html( $log['action'] ); ?></td>

            <td><?php echo esc_html( $log['description'] ); ?></td>

            <td><?php echo esc_html( $log['username'] ); ?></td>

            <td><?php echo esc_html( $log['ip_address'] ); ?></td>

            <td><?php echo esc_html( $log['created_at'] ); ?></td>

        </tr>

    <?php endforeach; ?>

    </tbody>

</table>