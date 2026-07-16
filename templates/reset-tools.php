<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// $counts is injected by Admin::reset_tools_page() via Statistics — no need to recompute here.

$deleted = isset( $_GET['deleted'] )
    ? sanitize_text_field( wp_unslash( $_GET['deleted'] ) )
    : '';

$total_items = array_sum( array_map( 'intval', $counts ) );
?>

<?php if ( '1' === $deleted ) : ?>
<div class="sr-toast sr-toast--success" id="sr-toast">
    <span class="sr-toast__icon">✓</span>
    <span>Reset operation completed successfully.</span>
    <button class="sr-toast__close" onclick="this.parentElement.remove()">✕</button>
</div>
<?php endif; ?>

<div class="sr-page-wrap">

    <!-- Page Header -->
    <div class="sr-page-header">
        <div class="sr-page-header__left">
            <div class="sr-page-header__icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
            </div>
            <div>
                <h1 class="sr-page-header__title">Reset Tools</h1>
                <p class="sr-page-header__subtitle">Permanently remove WordPress content. These actions cannot be undone.</p>
            </div>
        </div>
        <div class="sr-danger-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L1 21h22L12 2zm0 3.5L20.5 19h-17L12 5.5zM11 10v4h2v-4h-2zm0 6v2h2v-2h-2z"/></svg>
            Destructive Actions
        </div>
    </div>

    <!-- Stats Summary Bar -->
    <div class="sr-stats-bar">
        <div class="sr-stats-bar__item">
            <span class="sr-stats-bar__num"><?php echo number_format( $total_items ); ?></span>
            <span class="sr-stats-bar__label">Total Items</span>
        </div>
        <div class="sr-stats-bar__divider"></div>
        <div class="sr-stats-bar__item">
            <span class="sr-stats-bar__num sr-stats-bar__num--red"><?php echo number_format( $counts['posts'] ); ?></span>
            <span class="sr-stats-bar__label">Posts</span>
        </div>
        <div class="sr-stats-bar__divider"></div>
        <div class="sr-stats-bar__item">
            <span class="sr-stats-bar__num sr-stats-bar__num--orange"><?php echo number_format( $counts['pages'] ); ?></span>
            <span class="sr-stats-bar__label">Pages</span>
        </div>
        <div class="sr-stats-bar__divider"></div>
        <div class="sr-stats-bar__item">
            <span class="sr-stats-bar__num sr-stats-bar__num--purple"><?php echo number_format( $counts['media'] ); ?></span>
            <span class="sr-stats-bar__label">Media</span>
        </div>
        <div class="sr-stats-bar__divider"></div>
        <div class="sr-stats-bar__item">
            <span class="sr-stats-bar__num sr-stats-bar__num--blue"><?php echo number_format( $counts['comments'] ); ?></span>
            <span class="sr-stats-bar__label">Comments</span>
        </div>
        <div class="sr-stats-bar__divider"></div>
        <div class="sr-stats-bar__item">
            <span class="sr-stats-bar__num sr-stats-bar__num--teal"><?php echo number_format( $counts['categories'] ); ?></span>
            <span class="sr-stats-bar__label">Categories</span>
        </div>
        <div class="sr-stats-bar__divider"></div>
        <div class="sr-stats-bar__item">
            <span class="sr-stats-bar__num sr-stats-bar__num--pink"><?php echo number_format( $counts['tags'] ); ?></span>
            <span class="sr-stats-bar__label">Tags</span>
        </div>
    </div>

    <!-- Warning Banner -->
    <div class="sr-warning-banner">
        <svg class="sr-warning-banner__icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L1 21h22L12 2zm0 3.5L20.5 19h-17L12 5.5zM11 10v4h2v-4h-2zm0 6v2h2v-2h-2z"/></svg>
        <p><strong>Warning:</strong> All deletions below are permanent and irreversible. Please back up your database before proceeding.</p>
    </div>

    <!-- Cards Grid -->
    <div class="sr-grid">

        <!-- Delete Posts -->
        <div class="sr-card" data-type="posts">
            <div class="sr-card__header">
                <div class="sr-card__icon sr-card__icon--red">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                </div>
                <span class="sr-card__badge">Posts</span>
            </div>
            <div class="sr-card__body">
                <div class="sr-card__counter sr-card__counter--red">
                    <span class="sr-card__counter-num"><?php echo number_format( $counts['posts'] ); ?></span>
                    <span class="sr-card__counter-label"><?php echo 1 === $counts['posts'] ? 'post' : 'posts'; ?> found</span>
                </div>
                <h3 class="sr-card__title">Delete All Posts</h3>
                <p class="sr-card__desc">Permanently removes all blog posts from your WordPress site, including drafts, scheduled, and trashed posts.</p>
            </div>
            <div class="sr-card__footer">
                <form method="post">
                    <?php wp_nonce_field( 'sr_delete_posts', 'sr_delete_posts_nonce' ); ?>
                    <button type="submit" name="sr_delete_posts" value="1" class="sr-btn sr-btn--danger sr-delete-trigger"<?php echo 0 === $counts['posts'] ? ' disabled title="Nothing to delete"' : ''; ?>>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                        <?php echo 0 === $counts['posts'] ? 'Nothing to Delete' : 'Delete All Posts'; ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- Delete Pages -->
        <div class="sr-card" data-type="pages">
            <div class="sr-card__header">
                <div class="sr-card__icon sr-card__icon--orange">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <span class="sr-card__badge">Pages</span>
            </div>
            <div class="sr-card__body">
                <div class="sr-card__counter sr-card__counter--orange">
                    <span class="sr-card__counter-num"><?php echo number_format( $counts['pages'] ); ?></span>
                    <span class="sr-card__counter-label"><?php echo 1 === $counts['pages'] ? 'page' : 'pages'; ?> found</span>
                </div>
                <h3 class="sr-card__title">Delete All Pages</h3>
                <p class="sr-card__desc">Permanently removes all static pages from your WordPress site, including your homepage and all subpages.</p>
            </div>
            <div class="sr-card__footer">
                <form method="post">
                    <?php wp_nonce_field( 'sr_delete_pages', 'sr_delete_pages_nonce' ); ?>
                    <button type="submit" name="sr_delete_pages" value="1" class="sr-btn sr-btn--danger sr-delete-trigger"<?php echo 0 === $counts['pages'] ? ' disabled title="Nothing to delete"' : ''; ?>>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                        <?php echo 0 === $counts['pages'] ? 'Nothing to Delete' : 'Delete All Pages'; ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- Delete Media -->
        <div class="sr-card" data-type="media">
            <div class="sr-card__header">
                <div class="sr-card__icon sr-card__icon--purple">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </div>
                <span class="sr-card__badge">Media</span>
            </div>
            <div class="sr-card__body">
                <div class="sr-card__counter sr-card__counter--purple">
                    <span class="sr-card__counter-num"><?php echo number_format( $counts['media'] ); ?></span>
                    <span class="sr-card__counter-label"><?php echo 1 === $counts['media'] ? 'file' : 'files'; ?> found</span>
                </div>
                <h3 class="sr-card__title">Delete All Media</h3>
                <p class="sr-card__desc">Permanently removes all uploaded images, videos, documents, and other files from your media library.</p>
            </div>
            <div class="sr-card__footer">
                <form method="post">
                    <?php wp_nonce_field( 'sr_delete_media', 'sr_delete_media_nonce' ); ?>
                    <button type="submit" name="sr_delete_media" value="1" class="sr-btn sr-btn--danger sr-delete-trigger"<?php echo 0 === $counts['media'] ? ' disabled title="Nothing to delete"' : ''; ?>>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                        <?php echo 0 === $counts['media'] ? 'Nothing to Delete' : 'Delete All Media'; ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- Delete Comments -->
        <div class="sr-card" data-type="comments">
            <div class="sr-card__header">
                <div class="sr-card__icon sr-card__icon--blue">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <span class="sr-card__badge">Comments</span>
            </div>
            <div class="sr-card__body">
                <div class="sr-card__counter sr-card__counter--blue">
                    <span class="sr-card__counter-num"><?php echo number_format( $counts['comments'] ); ?></span>
                    <span class="sr-card__counter-label"><?php echo 1 === $counts['comments'] ? 'comment' : 'comments'; ?> found</span>
                </div>
                <h3 class="sr-card__title">Delete All Comments</h3>
                <p class="sr-card__desc">Permanently removes all comments from your site, including approved, pending, spam, and trashed comments.</p>
            </div>
            <div class="sr-card__footer">
                <form method="post">
                    <?php wp_nonce_field( 'sr_delete_comments', 'sr_delete_comments_nonce' ); ?>
                    <button type="submit" name="sr_delete_comments" value="1" class="sr-btn sr-btn--danger sr-delete-trigger"<?php echo 0 === $counts['comments'] ? ' disabled title="Nothing to delete"' : ''; ?>>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                        <?php echo 0 === $counts['comments'] ? 'Nothing to Delete' : 'Delete All Comments'; ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- Delete Categories -->
        <div class="sr-card" data-type="categories">
            <div class="sr-card__header">
                <div class="sr-card__icon sr-card__icon--teal">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                </div>
                <span class="sr-card__badge">Categories</span>
            </div>
            <div class="sr-card__body">
                <div class="sr-card__counter sr-card__counter--teal">
                    <span class="sr-card__counter-num"><?php echo number_format( $counts['categories'] ); ?></span>
                    <span class="sr-card__counter-label"><?php echo 1 === $counts['categories'] ? 'category' : 'categories'; ?> found</span>
                </div>
                <h3 class="sr-card__title">Delete All Categories</h3>
                <p class="sr-card__desc">Permanently removes all custom categories. The default WordPress category will be automatically preserved.</p>
                <div class="sr-card__note">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                    Default category will be preserved
                </div>
            </div>
            <div class="sr-card__footer">
                <form method="post">
                    <?php wp_nonce_field( 'sr_delete_categories', 'sr_delete_categories_nonce' ); ?>
                    <button type="submit" name="sr_delete_categories" value="1" class="sr-btn sr-btn--danger sr-delete-trigger"<?php echo 0 === $counts['categories'] ? ' disabled title="Nothing to delete"' : ''; ?>>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                        <?php echo 0 === $counts['categories'] ? 'Nothing to Delete' : 'Delete All Categories'; ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- Delete Tags -->
        <div class="sr-card" data-type="tags">
            <div class="sr-card__header">
                <div class="sr-card__icon sr-card__icon--pink">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                </div>
                <span class="sr-card__badge">Tags</span>
            </div>
            <div class="sr-card__body">
                <div class="sr-card__counter sr-card__counter--pink">
                    <span class="sr-card__counter-num"><?php echo number_format( $counts['tags'] ); ?></span>
                    <span class="sr-card__counter-label"><?php echo 1 === $counts['tags'] ? 'tag' : 'tags'; ?> found</span>
                </div>
                <h3 class="sr-card__title">Delete All Tags</h3>
                <p class="sr-card__desc">Permanently removes all post tags from your WordPress site. Tagged posts will remain but become untagged.</p>
            </div>
            <div class="sr-card__footer">
                <form method="post">
                    <?php wp_nonce_field( 'sr_delete_tags', 'sr_delete_tags_nonce' ); ?>
                    <button type="submit" name="sr_delete_tags" value="1" class="sr-btn sr-btn--danger sr-delete-trigger"<?php echo 0 === $counts['tags'] ? ' disabled title="Nothing to delete"' : ''; ?>>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                        <?php echo 0 === $counts['tags'] ? 'Nothing to Delete' : 'Delete All Tags'; ?>
                    </button>
                </form>
            </div>
        </div>

    </div><!-- .sr-grid -->

</div><!-- .sr-page-wrap -->

<!-- Confirmation Modal -->
<div id="sr-modal" class="sr-modal" role="dialog" aria-modal="true" aria-labelledby="sr-modal-title">
    <div class="sr-modal-box">

        <div class="sr-modal-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>

        <h2 id="sr-modal-title" class="sr-modal-title">Confirm Permanent Deletion</h2>

        <p class="sr-modal-desc">This action is <strong>irreversible</strong>. The selected content will be permanently erased from your database.</p>

        <div class="sr-modal-input-wrap">
            <label for="sr-confirm-input" class="sr-modal-label">Type <strong>DELETE</strong> to confirm</label>
            <input
                type="text"
                id="sr-confirm-input"
                class="sr-modal-input"
                placeholder="DELETE"
                autocomplete="off"
                spellcheck="false"
            >
        </div>

        <div class="sr-modal-buttons">
            <button type="button" id="sr-modal-cancel" class="sr-btn sr-btn--ghost">
                Cancel
            </button>
            <button type="button" id="sr-modal-confirm" class="sr-btn sr-btn--danger" disabled>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                Delete Permanently
            </button>
        </div>

    </div>
</div>