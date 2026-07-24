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
                    <polyline points="4 17 10 11 4 5"></polyline>
                    <line x1="12" y1="19" x2="20" y2="19"></line>
                </svg>
            </div>
            <div>
                <h1 class="sr-page-header__title">Activity Logs</h1>
                <p class="sr-page-header__subtitle">Audit trail for recent user actions, security events, and system activity.</p>
            </div>
        </div>
    </div>

    <!-- Dark Code Block Logs Card -->
    <div class="sr-code-card">
        <div class="sr-code-card__header">
            <div class="sr-code-card__header-left">
                <div class="sr-code-card__dots">
                    <span class="sr-code-card__dot sr-code-card__dot--red"></span>
                    <span class="sr-code-card__dot sr-code-card__dot--yellow"></span>
                    <span class="sr-code-card__dot sr-code-card__dot--green"></span>
                </div>
                <div class="sr-code-card__filename">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                    activity.log
                </div>
            </div>
            <div class="sr-code-card__header-right">
                <span class="sr-code-card__count"><?php echo esc_html( count( $logs ) ); ?> entries</span>
                <?php if ( ! empty( $logs ) ) : ?>
                    <button type="button" class="sr-code-card__copy-btn" id="sr-copy-logs-btn">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                        </svg>
                        Copy Raw Logs
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <?php if ( empty( $logs ) ) : ?>
            <div class="sr-code-empty">
                <div class="sr-code-empty__prompt">
                    <span>$</span> simple-reset --status<br>
                    <span style="color:#8b949e;">[INFO] No log entries recorded yet. Recent activity will appear here.</span>
                </div>
            </div>
        <?php else : ?>
            <div class="sr-code-body">
                <table class="sr-code-table" id="sr-logs-table">
                    <thead>
                        <tr>
                            <th class="sr-code-line-num">#</th>
                            <th>Timestamp</th>
                            <th>Action</th>
                            <th>Description</th>
                            <th>User &amp; IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $logs as $index => $log ) : ?>
                            <tr>
                                <td class="sr-code-line-num"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></td>
                                <td class="sr-code-time">[<?php echo esc_html( $log['created_at'] ); ?>]</td>
                                <td>
                                    <span class="sr-code-tag"><?php echo esc_html( $log['action'] ); ?></span>
                                </td>
                                <td class="sr-code-desc"><?php echo esc_html( $log['description'] ); ?></td>
                                <td class="sr-code-meta">
                                    <?php echo esc_html( $log['username'] ); ?>@<?php echo esc_html( $log['ip_address'] ); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
(function() {
    function initCopyLogs() {
        const copyBtn = document.getElementById("sr-copy-logs-btn");
        if (!copyBtn || copyBtn.dataset.srBound) return;
        copyBtn.dataset.srBound = "true";

        copyBtn.addEventListener("click", function (e) {
            e.preventDefault();
            const table = document.getElementById("sr-logs-table");
            if (!table) return;

            let rawText = "";
            const rows = table.querySelectorAll("tbody tr");
            rows.forEach(function (row) {
                const cells = row.querySelectorAll("td");
                if (cells.length >= 5) {
                    const time = cells[1].innerText.trim();
                    const action = cells[2].innerText.trim();
                    const desc = cells[3].innerText.trim();
                    const userIp = cells[4].innerText.trim();
                    rawText += `${time} [${action}] ${desc} (${userIp})\n`;
                }
            });

            if (!rawText) return;

            function showSuccess() {
                const origHtml = copyBtn.innerHTML;
                copyBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg> Copied!';
                setTimeout(function () {
                    copyBtn.innerHTML = origHtml;
                }, 2000);
            }

            function fallbackCopy(text) {
                const textArea = document.createElement("textarea");
                textArea.value = text;
                textArea.style.position = "fixed";
                textArea.style.left = "-999999px";
                textArea.style.top = "-999999px";
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    const successful = document.execCommand("copy");
                    if (successful) {
                        showSuccess();
                    }
                } catch (err) {
                    console.error("Fallback copy error:", err);
                }
                document.body.removeChild(textArea);
            }

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(rawText).then(showSuccess).catch(function () {
                    fallbackCopy(rawText);
                });
            } else {
                fallbackCopy(rawText);
            }
        });
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initCopyLogs);
    } else {
        initCopyLogs();
    }
})();
</script>