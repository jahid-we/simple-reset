<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
use SimpleReset\Log;

$logs = Log::get();

?>
<div class="sr-page-wrap">

    <div class="sr-page-header">
        <div class="sr-page-header__left">
            <div class="sr-page-header__icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); box-shadow: 0 4px 14px rgba(139,92,246,.25);">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 6h18"/>
                    <path d="M3 12h18"/>
                    <path d="M3 18h18"/>
                    <path d="M7 6v12"/>
                </svg>
            </div>
            <div>
                <h1 class="sr-page-header__title">Activity Logs</h1>
                <p class="sr-page-header__subtitle">Audit trail for recent user actions, security events, and system activity.</p>
            </div>
        </div>
    </div>

    <div class="sr-table-card">
        <div class="sr-table-card__header">
            <div>
                <h2 class="sr-table-card__title">Recent Events</h2>
                <p class="sr-table-card__subtitle">Showing the latest activity captured by Simple Reset.</p>
            </div>
            <span class="sr-table-card__count"><?php echo esc_html( count( $logs ) ); ?> entries</span>
        </div>

        <?php if ( empty( $logs ) ) : ?>
            <div class="sr-empty-state">
                <div class="sr-empty-state__icon" aria-hidden="true">📝</div>
                <div>
                    <h2>No activity found</h2>
                    <p>No log entries are available yet. Actions performed by the plugin will appear here.</p>
                </div>
            </div>
        <?php else : ?>
            <div class="sr-table-responsive">
                <table class="widefat striped sr-table">
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
            </div>
        <?php endif; ?>
    </div>
</div>