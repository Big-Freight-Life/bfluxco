<?php
/**
 * Password Manager Admin UI
 *
 * Handles the admin interface rendering for the Case Study Password Manager.
 * Extracted from BFLUXCO_Case_Study_Passwords class to improve code organization.
 *
 * @package BFLUXCO
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class BFLUXCO_Password_Admin
 *
 * Manages the admin UI for the password manager, including:
 * - Admin page rendering
 * - Admin styles output
 * - Client list display
 * - History display
 * - Settings form
 * - Modal dialogs
 *
 * @since 1.0.0
 */
class BFLUXCO_Password_Admin {

    /**
     * Render the admin page
     *
     * This method outputs the complete admin interface for the password manager,
     * including tabs for Client Access, History, Email Template, and Settings.
     *
     * @since 1.0.0
     * @return void
     */
    public static function render_admin_page() {
        // Suppress PHP notices/warnings from appearing in the UI
        $original_error_reporting = error_reporting();
        error_reporting( $original_error_reporting & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED );

        $case_studies  = BFLUXCO_Case_Study_Passwords::get_protected_case_studies();
        $password_data = BFLUXCO_Case_Study_Passwords::get_password_data();
        $settings      = BFLUXCO_Case_Study_Passwords::get_settings();
        $now           = current_time( 'timestamp' );

        // Get clients from Client Access Manager
        $clients = array();
        if ( class_exists( 'BFLUXCO_Client_Access' ) ) {
            $clients = BFLUXCO_Client_Access::get_clients();
        }

        // Ensure cron is scheduled
        BFLUXCO_Case_Study_Passwords::schedule_rotation();
        ?>
        <div class="wrap bfluxco-password-manager">
            <h1><?php esc_html_e( 'Case Study PW Manager', 'bfluxco' ); ?></h1>

            <?php self::render_admin_notices(); ?>

            <!-- Tab Navigation -->
            <nav class="nav-tab-wrapper">
                <a href="#" class="nav-tab nav-tab-active" data-tab="client-access"><?php esc_html_e( 'Client Access', 'bfluxco' ); ?></a>
                <a href="#" class="nav-tab" data-tab="history"><?php esc_html_e( 'History', 'bfluxco' ); ?></a>
                <a href="#" class="nav-tab" data-tab="email-template"><?php esc_html_e( 'Email Template', 'bfluxco' ); ?></a>
                <a href="#" class="nav-tab" data-tab="settings"><?php esc_html_e( 'Settings', 'bfluxco' ); ?></a>
            </nav>

            <?php
            self::render_client_access_tab( $clients, $now );
            self::render_history_tab();
            self::render_email_template_tab( $settings );
            self::render_settings_tab( $settings );
            self::render_modals( $settings );
            self::render_admin_scripts( $settings );
            ?>
        </div><!-- /.wrap -->
        <?php
        // Restore original error reporting
        error_reporting( $original_error_reporting );
    }

    /**
     * Render admin notices
     *
     * @since 1.0.0
     * @return void
     */
    private static function render_admin_notices() {
        if ( ! isset( $_GET['message'] ) ) {
            return;
        }

        $messages = array(
            'regenerated'        => __( 'Password regenerated successfully.', 'bfluxco' ),
            'all_regenerated'    => __( 'All passwords regenerated successfully.', 'bfluxco' ),
            'initialized'        => __( 'Existing passwords initialized for tracking.', 'bfluxco' ),
            'client_regenerated' => __( 'Client password regenerated successfully.', 'bfluxco' ),
            'client_revoked'     => __( 'Client access revoked.', 'bfluxco' ),
            'client_deleted'     => __( 'Client deleted successfully.', 'bfluxco' ),
            'client_error'       => __( 'An error occurred. Please try again.', 'bfluxco' ),
        );

        $message_key = sanitize_text_field( $_GET['message'] );
        $message     = isset( $messages[ $message_key ] ) ? $messages[ $message_key ] : '';
        $is_error    = ( $message_key === 'client_error' );

        if ( $message ) :
            ?>
            <div class="notice notice-<?php echo $is_error ? 'error' : 'success'; ?> is-dismissible">
                <p><?php echo esc_html( $message ); ?></p>
            </div>
            <?php
        endif;
    }

    /**
     * Render Client Access tab
     *
     * @since 1.0.0
     * @param array $clients Array of client data.
     * @param int   $now     Current timestamp.
     * @return void
     */
    private static function render_client_access_tab( $clients, $now ) {
        // Count stats
        $active_count    = 0;
        $expiring_count  = 0;
        $protected_count = 0;

        // Count protected case studies
        $all_cs = get_posts(
            array(
                'post_type'      => 'case_study',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
            )
        );
        foreach ( $all_cs as $cs ) {
            if ( ! empty( $cs->post_password ) ) {
                $protected_count++;
            }
        }

        // Count active/expiring clients
        foreach ( $clients as $client ) {
            if ( $client['status'] === 'active' && $client['expires_at'] > $now ) {
                $active_count++;
                $days_until = floor( ( $client['expires_at'] - $now ) / DAY_IN_SECONDS );
                if ( $days_until <= 7 ) {
                    $expiring_count++;
                }
            }
        }
        ?>
        <!-- Tab: Client Access -->
        <div class="tab-content tab-client-access is-active">
            <p class="section-help" style="margin-top: 0;">
                <?php esc_html_e( 'Manage client access to protected case studies. Each client receives unique credentials that grant access to specific case studies you assign to them.', 'bfluxco' ); ?>
            </p>

            <!-- Stats Bar -->
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-value"><?php echo count( $clients ); ?></div>
                    <div class="stat-label"><?php esc_html_e( 'Total Clients', 'bfluxco' ); ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $active_count; ?></div>
                    <div class="stat-label"><?php esc_html_e( 'Active', 'bfluxco' ); ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $expiring_count; ?></div>
                    <div class="stat-label"><?php esc_html_e( 'Expiring Soon', 'bfluxco' ); ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $protected_count; ?></div>
                    <div class="stat-label"><?php esc_html_e( 'Protected Case Studies', 'bfluxco' ); ?></div>
                </div>
            </div>

            <!-- Client List -->
            <div class="settings-card">
                <div class="section-header-row <?php echo ! empty( $clients ) ? 'section-header-3col' : ''; ?>">
                    <h2 class="section-title"><?php esc_html_e( 'Client List', 'bfluxco' ); ?></h2>
                    <?php if ( ! empty( $clients ) ) : ?>
                    <div class="search-wrap search-center">
                        <input type="text" id="client-search" class="client-search-input" placeholder="<?php esc_attr_e( 'Search clients...', 'bfluxco' ); ?>">
                        <button type="button" id="client-search-clear" class="search-clear-btn">&times;</button>
                    </div>
                    <?php endif; ?>
                    <?php if ( ! empty( $clients ) ) : ?>
                    <div class="action-buttons-group">
                        <a href="<?php echo wp_nonce_url( admin_url( 'admin.php?page=case-study-passwords&action=sync' ), 'bfluxco_sync_passwords' ); ?>" class="action-icon-btn" title="<?php esc_attr_e( 'Sync Existing Passwords', 'bfluxco' ); ?>">
                            <span class="dashicons dashicons-database"></span>
                        </a>
                        <a href="<?php echo wp_nonce_url( admin_url( 'admin.php?page=case-study-passwords&action=regenerate_all' ), 'bfluxco_regenerate_all' ); ?>" class="action-icon-btn" title="<?php esc_attr_e( 'Regenerate All Passwords', 'bfluxco' ); ?>" onclick="return confirm('<?php esc_attr_e( 'Regenerate ALL passwords? This will invalidate all existing passwords.', 'bfluxco' ); ?>');">
                            <span class="dashicons dashicons-update"></span>
                        </a>
                        <button type="button" class="add-client-btn button button-primary"><?php esc_html_e( 'Add New Client', 'bfluxco' ); ?></button>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if ( empty( $clients ) ) : ?>
                    <div class="empty-state">
                        <span class="dashicons dashicons-groups"></span>
                        <p><?php esc_html_e( 'No clients yet', 'bfluxco' ); ?></p>
                        <span class="empty-state-hint"><?php esc_html_e( 'Grant someone access to your case studies.', 'bfluxco' ); ?></span>
                        <div class="empty-state-action">
                            <button type="button" class="add-client-btn button button-primary"><?php esc_html_e( 'Add New Client', 'bfluxco' ); ?></button>
                        </div>
                    </div>
                <?php else : ?>
                    <?php self::render_client_table( $clients, $now ); ?>
                <?php endif; ?>
            </div>
        </div><!-- /.tab-client-access -->
        <?php
    }

    /**
     * Render client table
     *
     * @since 1.0.0
     * @param array $clients Array of client data.
     * @param int   $now     Current timestamp.
     * @return void
     */
    private static function render_client_table( $clients, $now ) {
        ?>
        <table class="password-table">
            <thead>
                <tr>
                    <th><?php esc_html_e( 'Client', 'bfluxco' ); ?></th>
                    <th><?php esc_html_e( 'Message Type', 'bfluxco' ); ?></th>
                    <th><?php esc_html_e( 'Password', 'bfluxco' ); ?></th>
                    <th><?php esc_html_e( 'Status', 'bfluxco' ); ?></th>
                    <th><?php esc_html_e( 'Created', 'bfluxco' ); ?></th>
                    <th><?php esc_html_e( 'Expires', 'bfluxco' ); ?></th>
                    <th><?php esc_html_e( 'Actions', 'bfluxco' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ( $clients as $client_id => $client ) :
                    // Determine status
                    $status       = $client['status'];
                    $status_label = ucfirst( $status );
                    if ( $status === 'active' ) {
                        $days_until = floor( ( $client['expires_at'] - $now ) / DAY_IN_SECONDS );
                        if ( $days_until <= 0 ) {
                            $status       = 'expired';
                            $status_label = __( 'Expired', 'bfluxco' );
                        } elseif ( $days_until <= 7 ) {
                            $status       = 'expiring';
                            $status_label = sprintf( __( 'Expires in %d days', 'bfluxco' ), $days_until );
                        } else {
                            $status_label = __( 'Active', 'bfluxco' );
                        }
                    }

                    // Get case study count
                    $cs_count = count( $client['case_studies'] );
                    ?>
                    <tr>
                        <td>
                            <?php
                            $display_name   = ! empty( $client['name'] ) ? $client['name'] : $client['email'];
                            $subtitle_parts = array();
                            if ( ! empty( $client['name'] ) ) {
                                $subtitle_parts[] = $client['email'];
                            }
                            if ( ! empty( $client['company'] ) ) {
                                $subtitle_parts[] = $client['company'];
                            }
                            ?>
                            <strong><?php echo esc_html( $display_name ); ?></strong>
                            <?php if ( ! empty( $subtitle_parts ) ) : ?>
                            <div class="client-sub"><?php echo esc_html( implode( ' · ', $subtitle_parts ) ); ?></div>
                            <?php endif; ?>
                            <div class="client-sub"><?php echo esc_html( sprintf( _n( '%d case study', '%d case studies', $cs_count, 'bfluxco' ), $cs_count ) ); ?></div>
                        </td>
                        <td>
                            <?php
                            $msg_type   = isset( $client['message_type'] ) && $client['message_type'] === 'custom' ? 'custom' : 'default';
                            $msg_label  = $msg_type === 'custom' ? __( 'Custom', 'bfluxco' ) : __( 'Default', 'bfluxco' );
                            $custom_msg = isset( $client['custom_message'] ) ? $client['custom_message'] : '';
                            ?>
                            <button type="button" class="message-type-btn message-type-<?php echo esc_attr( $msg_type ); ?>"
                                data-client-id="<?php echo esc_attr( $client_id ); ?>"
                                data-message-type="<?php echo esc_attr( $msg_type ); ?>"
                                data-custom-message="<?php echo esc_attr( $custom_msg ); ?>"
                                data-client-email="<?php echo esc_attr( $client['email'] ); ?>">
                                <?php echo esc_html( $msg_label ); ?>
                            </button>
                        </td>
                        <td>
                            <span class="password-display">••••••••</span>
                        </td>
                        <td>
                            <span class="status-<?php echo esc_attr( $status ); ?>"><?php echo esc_html( $status_label ); ?></span>
                        </td>
                        <td>
                            <?php
                            if ( isset( $client['created_at'] ) ) {
                                $chicago_tz   = new DateTimeZone( 'America/Chicago' );
                                $created_date = new DateTime( '@' . $client['created_at'] );
                                $created_date->setTimezone( $chicago_tz );
                                echo esc_html( $created_date->format( 'F j, Y' ) );
                            } else {
                                echo '—';
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if ( isset( $client['expires_at'] ) ) {
                                $chicago_tz   = new DateTimeZone( 'America/Chicago' );
                                $expires_date = new DateTime( '@' . $client['expires_at'] );
                                $expires_date->setTimezone( $chicago_tz );
                                echo esc_html( $expires_date->format( 'F j, Y' ) );
                            } else {
                                echo '—';
                            }
                            ?>
                        </td>
                        <td>
                            <div class="actions-cell">
                                <button type="button" class="action-icon-btn copy-credentials-btn"
                                    data-client-id="<?php echo esc_attr( $client_id ); ?>"
                                    data-client-email="<?php echo esc_attr( $client['email'] ); ?>"
                                    data-client-name="<?php echo esc_attr( ! empty( $client['name'] ) ? $client['name'] : '' ); ?>"
                                    title="<?php esc_attr_e( 'Copy credentials (regenerates password)', 'bfluxco' ); ?>">
                                    <span class="dashicons dashicons-clipboard"></span>
                                </button>
                                <div class="action-menu-wrap">
                                    <button type="button" class="action-icon-btn action-menu-toggle" title="<?php esc_attr_e( 'More actions', 'bfluxco' ); ?>">
                                        <span class="dashicons dashicons-ellipsis"></span>
                                    </button>
                                    <div class="action-menu">
                                        <button type="button" class="action-menu-item regenerate-pw-btn"
                                            data-client-id="<?php echo esc_attr( $client_id ); ?>"
                                            data-client-email="<?php echo esc_attr( $client['email'] ); ?>"
                                            data-client-name="<?php echo esc_attr( ! empty( $client['name'] ) ? $client['name'] : '' ); ?>">
                                            <span class="dashicons dashicons-update"></span> <?php esc_html_e( 'Regenerate Password', 'bfluxco' ); ?>
                                        </button>
                                        <?php if ( $client['status'] === 'active' ) : ?>
                                        <a href="<?php echo wp_nonce_url( admin_url( 'admin.php?page=case-study-passwords&revoke_client=' . $client_id ), 'revoke_client_' . $client_id ); ?>" class="action-menu-item" onclick="return confirm('<?php esc_attr_e( 'Revoke access for this client? They will no longer be able to view protected case studies.', 'bfluxco' ); ?>');">
                                            <span class="dashicons dashicons-dismiss"></span> <?php esc_html_e( 'Revoke Access', 'bfluxco' ); ?>
                                        </a>
                                        <?php endif; ?>
                                        <a href="<?php echo wp_nonce_url( admin_url( 'admin.php?page=case-study-passwords&delete_client=' . $client_id ), 'delete_client_' . $client_id ); ?>" class="action-menu-item danger" onclick="return confirm('<?php esc_attr_e( 'Delete this client? This cannot be undone.', 'bfluxco' ); ?>');">
                                            <span class="dashicons dashicons-trash"></span> <?php esc_html_e( 'Delete Client', 'bfluxco' ); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }

    /**
     * Render History tab
     *
     * @since 1.0.0
     * @return void
     */
    private static function render_history_tab() {
        $history = BFLUXCO_Case_Study_Passwords::get_history( 100 );
        ?>
        <!-- Tab: History -->
        <div class="tab-content tab-history">
            <p class="section-help" style="margin-top: 0;">
                <?php esc_html_e( 'Recent client access activity including password regenerations, revocations, and deletions.', 'bfluxco' ); ?>
            </p>

            <div class="settings-card">
                <div class="section-header-row" style="margin-bottom: 16px;">
                    <h3 class="section-title" style="margin: 0;"><?php esc_html_e( 'Recent events', 'bfluxco' ); ?></h3>
                    <?php if ( ! empty( $history ) ) : ?>
                    <div class="action-buttons-group">
                        <button type="button" id="clear-history-btn" class="button"><?php esc_html_e( 'Clear History', 'bfluxco' ); ?></button>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if ( empty( $history ) ) : ?>
                    <div class="empty-state">
                        <span class="dashicons dashicons-clock"></span>
                        <p><?php esc_html_e( 'No events yet', 'bfluxco' ); ?></p>
                        <span class="empty-state-hint"><?php esc_html_e( 'Activity will appear here as you manage client access.', 'bfluxco' ); ?></span>
                    </div>
                <?php else : ?>
                    <?php self::render_history_table( $history ); ?>
                <?php endif; ?>
            </div>
        </div><!-- /.tab-history -->
        <?php
    }

    /**
     * Render history table
     *
     * @since 1.0.0
     * @param array $history Array of history entries.
     * @return void
     */
    private static function render_history_table( $history ) {
        ?>
        <table class="password-table history-table">
            <thead>
                <tr>
                    <th><?php esc_html_e( 'Date', 'bfluxco' ); ?></th>
                    <th><?php esc_html_e( 'Action', 'bfluxco' ); ?></th>
                    <th><?php esc_html_e( 'Client', 'bfluxco' ); ?></th>
                    <th><?php esc_html_e( 'Details', 'bfluxco' ); ?></th>
                    <th><?php esc_html_e( 'Performed by', 'bfluxco' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ( $history as $entry ) :
                    $user     = get_user_by( 'id', $entry['user_id'] );
                    $username = $user ? $user->display_name : __( 'System', 'bfluxco' );

                    // Format date in Chicago timezone
                    $chicago_tz     = new DateTimeZone( 'America/Chicago' );
                    $date           = new DateTime( '@' . $entry['timestamp'] );
                    $date->setTimezone( $chicago_tz );
                    $formatted_date = $date->format( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) );

                    // Action labels and icons
                    $action_labels = array(
                        'client_added'         => array(
                            'label' => __( 'Client Added', 'bfluxco' ),
                            'class' => 'action-added',
                        ),
                        'password_regenerated' => array(
                            'label' => __( 'Password Regenerated', 'bfluxco' ),
                            'class' => 'action-regenerated',
                        ),
                        'client_revoked'       => array(
                            'label' => __( 'Access Revoked', 'bfluxco' ),
                            'class' => 'action-revoked',
                        ),
                        'client_deleted'       => array(
                            'label' => __( 'Client Deleted', 'bfluxco' ),
                            'class' => 'action-deleted',
                        ),
                        'client_login'         => array(
                            'label' => __( 'Client Login', 'bfluxco' ),
                            'class' => 'action-login',
                        ),
                        'message_updated'      => array(
                            'label' => __( 'Message Updated', 'bfluxco' ),
                            'class' => 'action-regenerated',
                        ),
                    );
                    $action_info   = isset( $action_labels[ $entry['action'] ] )
                        ? $action_labels[ $entry['action'] ]
                        : array(
                            'label' => ucfirst( str_replace( '_', ' ', $entry['action'] ) ),
                            'class' => '',
                        );
                    ?>
                    <tr>
                        <td>
                            <span class="history-date"><?php echo esc_html( $formatted_date ); ?></span>
                        </td>
                        <td>
                            <span class="history-action <?php echo esc_attr( $action_info['class'] ); ?>"><?php echo esc_html( $action_info['label'] ); ?></span>
                        </td>
                        <td>
                            <span class="history-client"><?php echo esc_html( $entry['client_email'] ); ?></span>
                        </td>
                        <td>
                            <span class="history-details"><?php echo esc_html( $entry['details'] ); ?></span>
                        </td>
                        <td>
                            <span class="history-user"><?php echo esc_html( $username ); ?></span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    }

    /**
     * Render Email Template tab
     *
     * @since 1.0.0
     * @param array $settings Current settings.
     * @return void
     */
    private static function render_email_template_tab( $settings ) {
        ?>
        <!-- Tab: Email Template -->
        <div class="tab-content tab-email-template">
            <p class="section-help" style="margin-top: 0;">
                <?php esc_html_e( 'This template is used when copying passwords to share with clients.', 'bfluxco' ); ?>
            </p>

            <div class="settings-card">
                <div class="section-header-row" style="margin-bottom: 16px;">
                    <h3 class="section-title" style="margin: 0;"><?php esc_html_e( 'Email Template', 'bfluxco' ); ?></h3>
                    <div class="template-actions">
                        <button type="button" id="edit-template-btn" class="action-icon-btn" title="<?php esc_attr_e( 'Edit Template', 'bfluxco' ); ?>">
                            <span class="dashicons dashicons-edit"></span>
                        </button>
                    </div>
                </div>
                <textarea id="email-template" readonly rows="12" class="email-template-textarea"><?php echo esc_textarea( $settings['email_template'] ); ?></textarea>
                <div id="template-edit-actions" class="template-edit-actions" style="display: none;">
                    <button type="button" id="save-template-btn" class="button button-primary"><?php esc_html_e( 'Save Template', 'bfluxco' ); ?></button>
                    <button type="button" id="cancel-template-btn" class="button"><?php esc_html_e( 'Cancel', 'bfluxco' ); ?></button>
                    <button type="button" id="reset-template-btn" class="button" style="margin-left: auto;"><?php esc_html_e( 'Reset to Default', 'bfluxco' ); ?></button>
                </div>
                <p id="template-tip" style="margin-top: 12px; font-size: 13px; color: #6b7280;">
                    <strong><?php esc_html_e( 'Tip:', 'bfluxco' ); ?></strong> <?php esc_html_e( 'Replace the bracketed placeholders with actual values before sending.', 'bfluxco' ); ?>
                </p>
            </div>
        </div><!-- /.tab-email-template -->
        <?php
    }

    /**
     * Render Settings tab
     *
     * @since 1.0.0
     * @param array $settings Current settings.
     * @return void
     */
    private static function render_settings_tab( $settings ) {
        ?>
        <!-- Tab: Settings -->
        <div class="tab-content tab-settings">
            <div class="settings-card" style="margin-top: 0;">
                <h2 class="section-title" style="margin-top: 0;"><?php esc_html_e( 'Rotation Settings', 'bfluxco' ); ?></h2>
                <p class="section-help">
                    <?php esc_html_e( 'Configure how often passwords should automatically rotate and the complexity of generated passwords. Shorter rotation periods are more secure but require more frequent client updates.', 'bfluxco' ); ?>
                </p>
                <form method="post" action="options.php">
                    <?php settings_fields( BFLUXCO_Case_Study_Passwords::SETTINGS_OPTION ); ?>
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="rotation_days"><?php esc_html_e( 'Rotate passwords every', 'bfluxco' ); ?></label>
                            </th>
                            <td>
                                <input type="number" name="<?php echo BFLUXCO_Case_Study_Passwords::SETTINGS_OPTION; ?>[rotation_days]" id="rotation_days" value="<?php echo esc_attr( $settings['rotation_days'] ); ?>" min="1" max="365" class="small-text"> <?php esc_html_e( 'days', 'bfluxco' ); ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="password_length"><?php esc_html_e( 'Password length', 'bfluxco' ); ?></label>
                            </th>
                            <td>
                                <input type="number" name="<?php echo BFLUXCO_Case_Study_Passwords::SETTINGS_OPTION; ?>[password_length]" id="password_length" value="<?php echo esc_attr( $settings['password_length'] ); ?>" min="8" max="32" class="small-text"> <?php esc_html_e( 'characters', 'bfluxco' ); ?>
                            </td>
                        </tr>
                    </table>
                    <?php submit_button( __( 'Save Settings', 'bfluxco' ) ); ?>
                </form>
            </div>
        </div><!-- /.tab-settings -->
        <?php
    }

    /**
     * Render modal dialogs
     *
     * @since 1.0.0
     * @param array $settings Current settings.
     * @return void
     */
    private static function render_modals( $settings ) {
        self::render_add_client_modal();
        self::render_select_case_studies_modal();
        self::render_message_template_modal();
        self::render_client_success_modal( $settings );
    }

    /**
     * Render Client Success modal (shown after creating/regenerating a client)
     *
     * @since 1.0.0
     * @param array $settings Current settings.
     * @return void
     */
    private static function render_client_success_modal( $settings ) {
        ?>
        <!-- Client Success Modal -->
        <div id="client-success-modal" class="client-modal">
            <div class="client-modal-backdrop"></div>
            <div class="client-modal-content client-modal-lg">
                <div class="client-modal-header">
                    <h3><?php esc_html_e( 'Client Credentials', 'bfluxco' ); ?></h3>
                    <span class="modal-subtitle" id="success-modal-subtitle"><?php esc_html_e( 'Share these credentials with your client', 'bfluxco' ); ?></span>
                    <button type="button" class="client-modal-close">&times;</button>
                </div>
                <div class="client-modal-body">
                    <div class="credentials-display">
                        <div class="credential-row">
                            <label><?php esc_html_e( 'Email', 'bfluxco' ); ?></label>
                            <div class="credential-value" id="success-email"></div>
                        </div>
                        <div class="credential-row">
                            <label><?php esc_html_e( 'Password', 'bfluxco' ); ?></label>
                            <div class="credential-value credential-password">
                                <code id="success-password"></code>
                                <button type="button" class="copy-inline-btn" id="copy-password-btn" title="<?php esc_attr_e( 'Copy password', 'bfluxco' ); ?>">
                                    <span class="dashicons dashicons-clipboard"></span>
                                </button>
                            </div>
                        </div>
                        <div class="credential-row">
                            <label><?php esc_html_e( 'Expires', 'bfluxco' ); ?></label>
                            <div class="credential-value" id="success-expires"></div>
                        </div>
                    </div>
                    <div class="message-preview">
                        <label><?php esc_html_e( 'Message to send', 'bfluxco' ); ?></label>
                        <textarea id="success-message" rows="8" readonly></textarea>
                    </div>
                </div>
                <div class="client-modal-footer">
                    <button type="button" id="copy-message-btn" class="button button-primary">
                        <span class="dashicons dashicons-clipboard"></span>
                        <?php esc_html_e( 'Copy Message', 'bfluxco' ); ?>
                    </button>
                    <button type="button" class="button success-modal-done"><?php esc_html_e( 'Done', 'bfluxco' ); ?></button>
                </div>
            </div>
        </div>
        <style>
            #client-success-modal .credentials-display { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; margin-bottom: 16px; }
            #client-success-modal .credential-row { display: flex; align-items: center; padding: 8px 0; border-bottom: 1px solid #e5e7eb; }
            #client-success-modal .credential-row:last-child { border-bottom: none; }
            #client-success-modal .credential-row label { width: 80px; font-weight: 600; color: #374151; font-size: 13px; }
            #client-success-modal .credential-value { flex: 1; font-size: 14px; color: #1f2937; }
            #client-success-modal .credential-password { display: flex; align-items: center; gap: 8px; }
            #client-success-modal .credential-password code { background: #fff; padding: 6px 12px; border-radius: 4px; font-family: monospace; font-size: 15px; font-weight: 600; color: #059669; border: 1px solid #d1fae5; }
            #client-success-modal .copy-inline-btn { background: none; border: none; color: #6b7280; cursor: pointer; padding: 4px; }
            #client-success-modal .copy-inline-btn:hover { color: #1f2937; }
            #client-success-modal .message-preview label { display: block; font-weight: 600; color: #374151; font-size: 13px; margin-bottom: 8px; }
            #client-success-modal .message-preview textarea { width: 100%; font-family: monospace; font-size: 13px; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; background: #f9fafb; resize: none; }
            #client-success-modal .client-modal-footer { display: flex; justify-content: flex-end; gap: 8px; }
            #client-success-modal #copy-message-btn .dashicons { font-size: 16px; width: 16px; height: 16px; margin-right: 4px; vertical-align: text-bottom; }
        </style>
        <?php
    }

    /**
     * Render Add Client modal
     *
     * @since 1.0.0
     * @return void
     */
    private static function render_add_client_modal() {
        // Get all protected case studies for the selector
        $all_case_studies = get_posts(
            array(
                'post_type'      => 'case_study',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'title',
                'order'          => 'ASC',
            )
        );
        $protected_case_studies = array_filter(
            $all_case_studies,
            function ( $cs ) {
                return ! empty( $cs->post_password );
            }
        );
        ?>
        <!-- Add Client Modal -->
        <div id="add-client-modal" class="client-modal">
            <div class="client-modal-backdrop"></div>
            <div class="client-modal-content">
                <div class="client-modal-header">
                    <h3><?php esc_html_e( 'Add New Client', 'bfluxco' ); ?></h3>
                    <button type="button" class="client-modal-close">&times;</button>
                </div>
                <form id="add-client-form">
                    <div class="client-modal-body">
                        <p class="modal-help-text"><?php esc_html_e( 'Create access credentials for a new client. They will receive a unique password to view the selected case studies.', 'bfluxco' ); ?></p>
                        <div class="form-field">
                            <label for="new-client-name"><?php esc_html_e( 'Name', 'bfluxco' ); ?></label>
                            <input type="text" id="new-client-name" name="name" placeholder="John Smith">
                        </div>
                        <div class="form-row-inline">
                            <div class="form-field">
                                <label for="new-client-email"><?php esc_html_e( 'Client Email', 'bfluxco' ); ?></label>
                                <input type="email" id="new-client-email" name="email" placeholder="client@company.com" required>
                            </div>
                            <div class="form-field">
                                <label for="new-client-company"><?php esc_html_e( 'Company', 'bfluxco' ); ?></label>
                                <input type="text" id="new-client-company" name="company" placeholder="Acme Inc.">
                            </div>
                        </div>
                        <div class="form-field">
                            <label><?php esc_html_e( 'Case Study Access', 'bfluxco' ); ?></label>
                            <p class="form-help" style="margin-bottom: 8px;"><?php esc_html_e( 'By default, access is granted to all protected case studies. Click below to customize which case studies this client can access.', 'bfluxco' ); ?></p>
                            <button type="button" id="toggle-case-studies"><?php esc_html_e( 'Select Case Studies', 'bfluxco' ); ?></button>
                            <div id="selected-case-studies-summary" class="selected-summary">
                                <span id="selected-count"><?php echo count( $protected_case_studies ); ?></span> <?php esc_html_e( 'case studies selected', 'bfluxco' ); ?>
                            </div>
                        </div>
                        <div class="form-field">
                            <label><?php esc_html_e( 'Access Duration', 'bfluxco' ); ?></label>
                            <div class="duration-type-row">
                                <label class="duration-type-option">
                                    <input type="radio" name="duration_type" value="days" checked>
                                    <span><?php esc_html_e( 'By days', 'bfluxco' ); ?></span>
                                </label>
                                <label class="duration-type-option">
                                    <input type="radio" name="duration_type" value="hours">
                                    <span><?php esc_html_e( 'By time', 'bfluxco' ); ?></span>
                                </label>
                            </div>
                            <div class="duration-inputs">
                                <div class="duration-input duration-days is-active">
                                    <div class="number-input-wrap">
                                        <input type="number" id="new-client-expiry" name="expiry_days" value="30" min="1" max="365">
                                        <div class="number-stepper">
                                            <button type="button" class="stepper-up">&#9650;</button>
                                            <button type="button" class="stepper-down">&#9660;</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="duration-input duration-hours">
                                    <select id="new-client-expiry-hours" name="expiry_hours">
                                        <option value="0.5"><?php esc_html_e( '30 minutes', 'bfluxco' ); ?></option>
                                        <option value="1"><?php esc_html_e( '1 hour', 'bfluxco' ); ?></option>
                                        <option value="2"><?php esc_html_e( '2 hours', 'bfluxco' ); ?></option>
                                        <option value="6"><?php esc_html_e( '6 hours', 'bfluxco' ); ?></option>
                                        <option value="12"><?php esc_html_e( '12 hours', 'bfluxco' ); ?></option>
                                        <option value="24" selected><?php esc_html_e( '24 hours', 'bfluxco' ); ?></option>
                                        <option value="48"><?php esc_html_e( '48 hours', 'bfluxco' ); ?></option>
                                        <option value="72"><?php esc_html_e( '72 hours', 'bfluxco' ); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="client-modal-footer">
                        <button type="button" class="button client-modal-cancel"><?php esc_html_e( 'Cancel', 'bfluxco' ); ?></button>
                        <button type="submit" class="button button-primary"><?php esc_html_e( 'Create Client', 'bfluxco' ); ?></button>
                    </div>
                </form>
            </div>
        </div>
        <?php
    }

    /**
     * Render Select Case Studies modal
     *
     * @since 1.0.0
     * @return void
     */
    private static function render_select_case_studies_modal() {
        $all_case_studies = get_posts(
            array(
                'post_type'      => 'case_study',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'title',
                'order'          => 'ASC',
            )
        );
        $protected_case_studies = array_filter(
            $all_case_studies,
            function ( $cs ) {
                return ! empty( $cs->post_password );
            }
        );
        ?>
        <!-- Select Case Studies Modal -->
        <div id="select-cs-modal" class="client-modal">
            <div class="client-modal-backdrop"></div>
            <div class="client-modal-content client-modal-lg">
                <div class="client-modal-header">
                    <h3><?php esc_html_e( 'Select Case Studies', 'bfluxco' ); ?></h3>
                    <button type="button" class="client-modal-close">&times;</button>
                </div>
                <div class="client-modal-body">
                    <div class="cs-selected-tags" id="cs-selected-tags"></div>
                    <div class="cs-search-wrap">
                        <input type="text" id="cs-search" class="cs-search-input" placeholder="<?php esc_attr_e( 'Search case studies...', 'bfluxco' ); ?>">
                    </div>
                    <div class="cs-select-actions">
                        <button type="button" id="cs-select-all" class="button"><?php esc_html_e( 'Select All', 'bfluxco' ); ?></button>
                        <button type="button" id="cs-select-none" class="button"><?php esc_html_e( 'Select None', 'bfluxco' ); ?></button>
                    </div>
                    <div class="case-studies-list" id="cs-list">
                        <?php
                        foreach ( $protected_case_studies as $cs ) :
                            $industries    = get_the_terms( $cs->ID, 'industry' );
                            $industry_name = $industries && ! is_wp_error( $industries ) ? $industries[0]->name : '';
                            ?>
                        <label class="cs-list-item" data-title="<?php echo esc_attr( strtolower( $cs->post_title ) ); ?>" data-id="<?php echo esc_attr( $cs->ID ); ?>">
                            <input type="checkbox" value="<?php echo esc_attr( $cs->ID ); ?>" data-title="<?php echo esc_attr( $cs->post_title ); ?>" checked>
                            <span class="cs-item-title"><?php echo esc_html( $cs->post_title ); ?></span>
                            <?php if ( $industry_name ) : ?>
                            <span class="cs-item-industry"><?php echo esc_html( $industry_name ); ?></span>
                            <?php endif; ?>
                        </label>
                        <?php endforeach; ?>
                        <?php if ( empty( $protected_case_studies ) ) : ?>
                        <p class="no-case-studies"><?php esc_html_e( 'No protected case studies found.', 'bfluxco' ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="client-modal-footer">
                    <button type="button" class="button cs-modal-cancel"><?php esc_html_e( 'Cancel', 'bfluxco' ); ?></button>
                    <button type="button" id="cs-confirm" class="button button-primary"><?php esc_html_e( 'Confirm Selection', 'bfluxco' ); ?></button>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Render Message Template modal
     *
     * @since 1.0.0
     * @return void
     */
    private static function render_message_template_modal() {
        ?>
        <!-- Message Template Modal -->
        <div id="message-template-modal" class="client-modal">
            <div class="client-modal-backdrop"></div>
            <div class="client-modal-content client-modal-lg">
                <div class="client-modal-header">
                    <h3><?php esc_html_e( 'Client Message', 'bfluxco' ); ?></h3>
                    <button type="button" class="client-modal-close">&times;</button>
                </div>
                <div class="client-modal-body">
                    <p class="msg-edit-help"><?php esc_html_e( 'This is the default message you can copy for', 'bfluxco' ); ?> <strong id="msg-help-email"></strong>. <?php esc_html_e( 'You can customize this message by making changes directly below.', 'bfluxco' ); ?></p>
                    <textarea id="custom-message-textarea" rows="12" class="msg-edit-textarea"></textarea>
                </div>
                <div class="client-modal-footer">
                    <button type="button" id="msg-reset-btn" class="button" style="margin-right: auto;"><?php esc_html_e( 'Use Default', 'bfluxco' ); ?></button>
                    <button type="button" class="button msg-modal-cancel"><?php esc_html_e( 'Cancel', 'bfluxco' ); ?></button>
                    <button type="button" id="msg-save-btn" class="button button-primary"><?php esc_html_e( 'Apply Custom Message', 'bfluxco' ); ?></button>
                </div>
                <input type="hidden" id="msg-modal-client-id" value="">
                <input type="hidden" id="msg-modal-original-type" value="">
            </div>
        </div>
        <?php
    }

    /**
     * Render admin scripts
     *
     * @since 1.0.0
     * @param array $settings Current settings.
     * @return void
     */
    private static function render_admin_scripts( $settings ) {
        $default_template = BFLUXCO_Case_Study_Passwords::get_default_email_template();
        ?>
        <script>
        function copyToClipboard(text) {
            // Fallback method that works on HTTP (local dev)
            var textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.left = '-9999px';
            document.body.appendChild(textarea);
            textarea.select();
            try {
                document.execCommand('copy');
                return true;
            } catch (err) {
                console.error('Copy failed:', err);
                return false;
            } finally {
                document.body.removeChild(textarea);
            }
        }

        function copyMessage(postId) {
            var el = document.getElementById('pw-' + postId);
            var password = el.textContent.trim();
            var url = el.getAttribute('data-url');
            var title = el.getAttribute('data-title');
            var expiry = el.getAttribute('data-expiry');

            var message = 'Hi,\n\n';
            message += 'I\'d like to share a case study with you: "' + title + '"\n\n';
            message += 'You can view it at: ' + url + '\n\n';
            message += '—————————————————\n';
            message += 'PASSWORD:  ' + password + '\n';
            message += '—————————————————\n';
            if (expiry) {
                message += '\nThis password will expire on ' + expiry + '.\n';
            }
            message += '\nBest regards,\nRay';

            if (copyToClipboard(message)) {
                alert('Message copied!\n\nIncludes: Title, URL, Password' + (expiry ? ', Expiry' : ''));
            } else {
                alert('Copy failed. Please select and copy manually.');
            }
        }

        // Action menu dropdown toggle
        document.querySelectorAll('.action-menu-toggle').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var menu = this.nextElementSibling;
                var isOpen = menu.classList.contains('is-open');
                // Close all other menus
                document.querySelectorAll('.action-menu.is-open').forEach(function(m) {
                    m.classList.remove('is-open');
                });
                // Toggle this menu
                if (!isOpen) {
                    menu.classList.add('is-open');
                }
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.action-menu-wrap')) {
                document.querySelectorAll('.action-menu.is-open').forEach(function(m) {
                    m.classList.remove('is-open');
                });
            }
        });

        // Number stepper buttons
        document.querySelectorAll('.number-stepper .stepper-up').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var input = this.closest('.number-input-wrap').querySelector('input[type="number"]');
                var max = parseInt(input.getAttribute('max')) || 365;
                var current = parseInt(input.value) || 0;
                if (current < max) {
                    input.value = current + 1;
                }
            });
        });
        document.querySelectorAll('.number-stepper .stepper-down').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var input = this.closest('.number-input-wrap').querySelector('input[type="number"]');
                var min = parseInt(input.getAttribute('min')) || 1;
                var current = parseInt(input.value) || 0;
                if (current > min) {
                    input.value = current - 1;
                }
            });
        });

        // Duration type toggle
        document.querySelectorAll('input[name="duration_type"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                var type = this.value;
                var container = this.closest('.form-field').querySelector('.duration-inputs');
                container.querySelectorAll('.duration-input').forEach(function(input) {
                    input.classList.remove('is-active');
                });
                container.querySelector('.duration-' + type).classList.add('is-active');
            });
        });

        // Client search
        var searchInput = document.getElementById('client-search');
        if (searchInput) {
            var searchWrap = searchInput.parentElement;
            var clearBtn = document.getElementById('client-search-clear');

            function filterClients() {
                var query = searchInput.value.toLowerCase().trim();
                var rows = document.querySelectorAll('.password-table tbody tr');
                rows.forEach(function(row) {
                    var email = row.querySelector('td strong').textContent.toLowerCase();
                    if (query === '' || email.indexOf(query) !== -1) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
                // Show/hide clear button
                if (searchInput.value.length > 0) {
                    searchWrap.classList.add('has-value');
                } else {
                    searchWrap.classList.remove('has-value');
                }
            }

            searchInput.addEventListener('input', filterClients);

            clearBtn.addEventListener('click', function() {
                searchInput.value = '';
                filterClients();
                searchInput.focus();
            });
        }

        // Add Client Modal
        var modal = document.getElementById('add-client-modal');
        var addClientBtns = document.querySelectorAll('.add-client-btn');
        var modalClose = modal.querySelector('.client-modal-close');
        var modalCancel = modal.querySelector('.client-modal-cancel');
        var modalBackdrop = modal.querySelector('.client-modal-backdrop');
        var addClientForm = document.getElementById('add-client-form');
        var toggleCsBtn = document.getElementById('toggle-case-studies');
        var selectedCountEl = document.getElementById('selected-count');
        var selectedCaseStudies = [];

        // Initialize with all checked
        document.querySelectorAll('#cs-list input[type="checkbox"]:checked').forEach(function(cb) {
            selectedCaseStudies.push({ id: cb.value, title: cb.getAttribute('data-title') });
        });

        function openModal() {
            modal.classList.add('is-open');
            document.getElementById('new-client-email').focus();
        }

        function closeModal() {
            modal.classList.remove('is-open');
            addClientForm.reset();
            // Reset case studies selection to all
            selectedCaseStudies = [];
            document.querySelectorAll('#cs-list input[type="checkbox"]').forEach(function(cb) {
                cb.checked = true;
                selectedCaseStudies.push({ id: cb.value, title: cb.getAttribute('data-title') });
            });
            selectedCountEl.textContent = selectedCaseStudies.length;
        }

        addClientBtns.forEach(function(btn) {
            btn.addEventListener('click', openModal);
        });
        modalClose.addEventListener('click', closeModal);
        modalCancel.addEventListener('click', closeModal);
        modalBackdrop.addEventListener('click', closeModal);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('is-open')) {
                closeModal();
            }
        });

        // Case Studies Selection Modal
        var csModal = document.getElementById('select-cs-modal');
        var csModalClose = csModal.querySelector('.client-modal-close');
        var csModalCancel = csModal.querySelector('.cs-modal-cancel');
        var csModalBackdrop = csModal.querySelector('.client-modal-backdrop');
        var csSearch = document.getElementById('cs-search');
        var csList = document.getElementById('cs-list');
        var csSelectAll = document.getElementById('cs-select-all');
        var csSelectNone = document.getElementById('cs-select-none');
        var csConfirm = document.getElementById('cs-confirm');
        var csTagsContainer = document.getElementById('cs-selected-tags');

        function openCsModal() {
            csModal.classList.add('is-open');
            updateCsTags();
            csSearch.focus();
        }

        function closeCsModal() {
            csModal.classList.remove('is-open');
            csSearch.value = '';
            filterCsList('');
        }

        function updateCsTags() {
            csTagsContainer.innerHTML = '';
            selectedCaseStudies.forEach(function(cs) {
                var tag = document.createElement('span');
                tag.className = 'cs-tag';
                tag.innerHTML = cs.title + '<button type="button" class="cs-tag-remove" data-id="' + cs.id + '">&times;</button>';
                csTagsContainer.appendChild(tag);
            });
        }

        function updateSelectedCount() {
            selectedCountEl.textContent = selectedCaseStudies.length;
        }

        function filterCsList(query) {
            query = query.toLowerCase();
            document.querySelectorAll('#cs-list .cs-list-item').forEach(function(item) {
                var title = item.getAttribute('data-title');
                if (query === '' || title.indexOf(query) !== -1) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        toggleCsBtn.addEventListener('click', openCsModal);
        csModalClose.addEventListener('click', closeCsModal);
        csModalCancel.addEventListener('click', closeCsModal);
        csModalBackdrop.addEventListener('click', closeCsModal);

        csSearch.addEventListener('input', function() {
            filterCsList(this.value);
        });

        csSelectAll.addEventListener('click', function() {
            selectedCaseStudies = [];
            document.querySelectorAll('#cs-list input[type="checkbox"]').forEach(function(cb) {
                cb.checked = true;
                selectedCaseStudies.push({ id: cb.value, title: cb.getAttribute('data-title') });
            });
            updateCsTags();
        });

        csSelectNone.addEventListener('click', function() {
            selectedCaseStudies = [];
            document.querySelectorAll('#cs-list input[type="checkbox"]').forEach(function(cb) {
                cb.checked = false;
            });
            updateCsTags();
        });

        // Handle checkbox changes in modal
        csList.addEventListener('change', function(e) {
            if (e.target.type === 'checkbox') {
                var id = e.target.value;
                var title = e.target.getAttribute('data-title');
                if (e.target.checked) {
                    selectedCaseStudies.push({ id: id, title: title });
                } else {
                    selectedCaseStudies = selectedCaseStudies.filter(function(cs) { return cs.id !== id; });
                }
                updateCsTags();
            }
        });

        // Handle tag removal
        csTagsContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('cs-tag-remove')) {
                var id = e.target.getAttribute('data-id');
                selectedCaseStudies = selectedCaseStudies.filter(function(cs) { return cs.id !== id; });
                document.querySelector('#cs-list input[value="' + id + '"]').checked = false;
                updateCsTags();
            }
        });

        csConfirm.addEventListener('click', function() {
            updateSelectedCount();
            closeCsModal();
        });

        // Form submission
        addClientForm.addEventListener('submit', function(e) {
            e.preventDefault();

            var name = document.getElementById('new-client-name').value;
            var email = document.getElementById('new-client-email').value;
            var company = document.getElementById('new-client-company').value;
            var durationType = document.querySelector('input[name="duration_type"]:checked').value;
            var expiryDays = document.getElementById('new-client-expiry').value;
            var expiryHours = document.getElementById('new-client-expiry-hours').value;
            var submitBtn = addClientForm.querySelector('button[type="submit"]');

            submitBtn.disabled = true;
            submitBtn.textContent = '<?php echo esc_js( __( 'Creating...', 'bfluxco' ) ); ?>';

            var formData = new FormData();
            formData.append('action', 'bfluxco_add_client');
            formData.append('nonce', '<?php echo wp_create_nonce( 'bfluxco_client_access_admin' ); ?>');
            formData.append('name', name);
            formData.append('email', email);
            formData.append('company', company);
            formData.append('duration_type', durationType);
            formData.append('expiry_days', expiryDays);
            formData.append('expiry_hours', expiryHours);
            selectedCaseStudies.forEach(function(cs) {
                formData.append('case_studies[]', cs.id);
            });

            fetch('<?php echo admin_url( 'admin-ajax.php' ); ?>', {
                method: 'POST',
                credentials: 'same-origin',
                body: formData
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                submitBtn.disabled = false;
                submitBtn.textContent = '<?php echo esc_js( __( 'Create Client', 'bfluxco' ) ); ?>';

                if (data.success) {
                    closeModal();
                    showSuccessModal(data.data);
                } else {
                    alert(data.data || '<?php echo esc_js( __( 'Error creating client.', 'bfluxco' ) ); ?>');
                }
            })
            .catch(function() {
                submitBtn.disabled = false;
                submitBtn.textContent = '<?php echo esc_js( __( 'Create Client', 'bfluxco' ) ); ?>';
                alert('<?php echo esc_js( __( 'Connection error. Please try again.', 'bfluxco' ) ); ?>');
            });
        });

        // Tab navigation
        document.querySelectorAll('.nav-tab').forEach(function(tab) {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                var targetTab = this.getAttribute('data-tab');

                // Update tab buttons
                document.querySelectorAll('.nav-tab').forEach(function(t) {
                    t.classList.remove('nav-tab-active');
                });
                this.classList.add('nav-tab-active');

                // Update tab content
                document.querySelectorAll('.tab-content').forEach(function(content) {
                    content.classList.remove('is-active');
                });
                document.querySelector('.tab-' + targetTab).classList.add('is-active');
            });
        });

        // Email Template CRUD
        var emailTemplate = document.getElementById('email-template');
        var editTemplateBtn = document.getElementById('edit-template-btn');
        var templateEditActions = document.getElementById('template-edit-actions');
        var saveTemplateBtn = document.getElementById('save-template-btn');
        var cancelTemplateBtn = document.getElementById('cancel-template-btn');
        var resetTemplateBtn = document.getElementById('reset-template-btn');
        var templateTip = document.getElementById('template-tip');
        var originalTemplate = emailTemplate.value;
        var defaultTemplate = <?php echo json_encode( $default_template ); ?>;

        function enterEditMode() {
            emailTemplate.removeAttribute('readonly');
            emailTemplate.classList.add('is-editing');
            editTemplateBtn.style.display = 'none';
            templateEditActions.style.display = 'flex';
            templateTip.style.display = 'none';
            emailTemplate.focus();
        }

        function exitEditMode() {
            emailTemplate.setAttribute('readonly', 'readonly');
            emailTemplate.classList.remove('is-editing');
            editTemplateBtn.style.display = '';
            templateEditActions.style.display = 'none';
            templateTip.style.display = '';
        }

        editTemplateBtn.addEventListener('click', enterEditMode);

        cancelTemplateBtn.addEventListener('click', function() {
            emailTemplate.value = originalTemplate;
            exitEditMode();
        });

        resetTemplateBtn.addEventListener('click', function() {
            if (confirm('<?php echo esc_js( __( 'Reset template to default? Your changes will be lost.', 'bfluxco' ) ); ?>')) {
                emailTemplate.value = defaultTemplate;
            }
        });

        saveTemplateBtn.addEventListener('click', function() {
            saveTemplateBtn.disabled = true;
            saveTemplateBtn.textContent = '<?php echo esc_js( __( 'Saving...', 'bfluxco' ) ); ?>';

            var formData = new FormData();
            formData.append('action', 'bfluxco_save_email_template');
            formData.append('nonce', '<?php echo wp_create_nonce( 'bfluxco_save_template' ); ?>');
            formData.append('template', emailTemplate.value);

            fetch('<?php echo admin_url( 'admin-ajax.php' ); ?>', {
                method: 'POST',
                credentials: 'same-origin',
                body: formData
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                saveTemplateBtn.disabled = false;
                saveTemplateBtn.textContent = '<?php echo esc_js( __( 'Save Template', 'bfluxco' ) ); ?>';

                if (data.success) {
                    originalTemplate = emailTemplate.value;
                    exitEditMode();
                    alert('<?php echo esc_js( __( 'Template saved successfully!', 'bfluxco' ) ); ?>');
                } else {
                    alert(data.data || '<?php echo esc_js( __( 'Error saving template.', 'bfluxco' ) ); ?>');
                }
            })
            .catch(function() {
                saveTemplateBtn.disabled = false;
                saveTemplateBtn.textContent = '<?php echo esc_js( __( 'Save Template', 'bfluxco' ) ); ?>';
                alert('<?php echo esc_js( __( 'Connection error. Please try again.', 'bfluxco' ) ); ?>');
            });
        });

        // Clear History
        var clearHistoryBtn = document.getElementById('clear-history-btn');
        if (clearHistoryBtn) {
            clearHistoryBtn.addEventListener('click', function() {
                if (!confirm('<?php echo esc_js( __( 'Clear all history? This cannot be undone.', 'bfluxco' ) ); ?>')) {
                    return;
                }

                clearHistoryBtn.disabled = true;
                clearHistoryBtn.textContent = '<?php echo esc_js( __( 'Clearing...', 'bfluxco' ) ); ?>';

                var formData = new FormData();
                formData.append('action', 'bfluxco_clear_history');
                formData.append('nonce', '<?php echo wp_create_nonce( 'bfluxco_clear_history' ); ?>');

                fetch('<?php echo admin_url( 'admin-ajax.php' ); ?>', {
                    method: 'POST',
                    credentials: 'same-origin',
                    body: formData
                })
                .then(function(response) { return response.json(); })
                .then(function(data) {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.data || '<?php echo esc_js( __( 'Error clearing history.', 'bfluxco' ) ); ?>');
                        clearHistoryBtn.disabled = false;
                        clearHistoryBtn.textContent = '<?php echo esc_js( __( 'Clear History', 'bfluxco' ) ); ?>';
                    }
                })
                .catch(function() {
                    alert('<?php echo esc_js( __( 'Connection error. Please try again.', 'bfluxco' ) ); ?>');
                    clearHistoryBtn.disabled = false;
                    clearHistoryBtn.textContent = '<?php echo esc_js( __( 'Clear History', 'bfluxco' ) ); ?>';
                });
            });
        }

        // =====================================================
        // Message Template Modal (Custom vs Default per client)
        // =====================================================
        var msgModal = document.getElementById('message-template-modal');
        var msgModalClose = msgModal.querySelector('.client-modal-close');
        var msgModalCancel = msgModal.querySelector('.msg-modal-cancel');
        var msgModalBackdrop = msgModal.querySelector('.client-modal-backdrop');
        var msgSaveBtn = document.getElementById('msg-save-btn');
        var msgResetBtn = document.getElementById('msg-reset-btn');
        var msgClientIdInput = document.getElementById('msg-modal-client-id');
        var msgOriginalTypeInput = document.getElementById('msg-modal-original-type');
        var msgHelpEmailSpan = document.getElementById('msg-help-email');
        var customMessageTextarea = document.getElementById('custom-message-textarea');

        var settingsTemplate = <?php echo json_encode( $settings['email_template'] ); ?>;
        var currentClientId = '';
        var originalCustomMessage = '';

        function openMsgModal(clientId, clientEmail, messageType, customMessage) {
            currentClientId = clientId;
            originalCustomMessage = customMessage || '';

            msgClientIdInput.value = clientId;
            msgOriginalTypeInput.value = messageType;
            msgHelpEmailSpan.textContent = clientEmail;

            // Show custom message if exists, otherwise show default template
            if (messageType === 'custom' && customMessage) {
                customMessageTextarea.value = customMessage;
            } else {
                customMessageTextarea.value = settingsTemplate;
            }

            msgModal.classList.add('is-open');
            customMessageTextarea.focus();
        }

        function closeMsgModal() {
            msgModal.classList.remove('is-open');
            currentClientId = '';
            originalCustomMessage = '';
            customMessageTextarea.value = '';
        }

        // Open modal when clicking message type button
        document.querySelectorAll('.message-type-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var clientId = this.getAttribute('data-client-id');
                var clientEmail = this.getAttribute('data-client-email');
                var messageType = this.getAttribute('data-message-type');
                var customMessage = this.getAttribute('data-custom-message');
                openMsgModal(clientId, clientEmail, messageType, customMessage);
            });
        });

        // Close modal handlers
        msgModalClose.addEventListener('click', closeMsgModal);
        msgModalCancel.addEventListener('click', closeMsgModal);
        msgModalBackdrop.addEventListener('click', closeMsgModal);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && msgModal.classList.contains('is-open')) {
                closeMsgModal();
            }
        });

        // Use Default button - resets to default template
        msgResetBtn.addEventListener('click', function() {
            if (!currentClientId) return;

            if (!confirm('<?php echo esc_js( __( 'Reset to default template? Any custom message for this client will be removed.', 'bfluxco' ) ); ?>')) {
                return;
            }

            msgResetBtn.disabled = true;
            msgResetBtn.textContent = '<?php echo esc_js( __( 'Resetting...', 'bfluxco' ) ); ?>';

            var formData = new FormData();
            formData.append('action', 'bfluxco_save_client_message');
            formData.append('nonce', '<?php echo wp_create_nonce( 'bfluxco_save_client_message' ); ?>');
            formData.append('client_id', currentClientId);
            formData.append('message_type', 'default');
            formData.append('custom_message', '');

            fetch('<?php echo admin_url( 'admin-ajax.php' ); ?>', {
                method: 'POST',
                credentials: 'same-origin',
                body: formData
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                msgResetBtn.disabled = false;
                msgResetBtn.textContent = '<?php echo esc_js( __( 'Use Default', 'bfluxco' ) ); ?>';

                if (data.success) {
                    // Update the button in the table row
                    var btn = document.querySelector('.message-type-btn[data-client-id="' + currentClientId + '"]');
                    if (btn) {
                        btn.setAttribute('data-message-type', 'default');
                        btn.setAttribute('data-custom-message', '');
                        btn.textContent = '<?php echo esc_js( __( 'Default', 'bfluxco' ) ); ?>';
                        btn.className = 'message-type-btn message-type-default';
                    }
                    closeMsgModal();
                } else {
                    alert(data.data || '<?php echo esc_js( __( 'Error resetting template.', 'bfluxco' ) ); ?>');
                }
            })
            .catch(function() {
                msgResetBtn.disabled = false;
                msgResetBtn.textContent = '<?php echo esc_js( __( 'Use Default', 'bfluxco' ) ); ?>';
                alert('<?php echo esc_js( __( 'Connection error. Please try again.', 'bfluxco' ) ); ?>');
            });
        });

        // Apply Custom Message button
        msgSaveBtn.addEventListener('click', function() {
            if (!currentClientId) return;

            var customMsg = customMessageTextarea.value.trim();

            if (!customMsg) {
                alert('<?php echo esc_js( __( 'Please enter a message or click "Use Default" to reset.', 'bfluxco' ) ); ?>');
                customMessageTextarea.focus();
                return;
            }

            // Check if message is same as default - treat as default
            var isDefault = (customMsg === settingsTemplate.trim());

            msgSaveBtn.disabled = true;
            msgSaveBtn.textContent = '<?php echo esc_js( __( 'Applying...', 'bfluxco' ) ); ?>';

            var formData = new FormData();
            formData.append('action', 'bfluxco_save_client_message');
            formData.append('nonce', '<?php echo wp_create_nonce( 'bfluxco_save_client_message' ); ?>');
            formData.append('client_id', currentClientId);
            formData.append('message_type', isDefault ? 'default' : 'custom');
            formData.append('custom_message', isDefault ? '' : customMsg);

            fetch('<?php echo admin_url( 'admin-ajax.php' ); ?>', {
                method: 'POST',
                credentials: 'same-origin',
                body: formData
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                msgSaveBtn.disabled = false;
                msgSaveBtn.textContent = '<?php echo esc_js( __( 'Apply Custom Message', 'bfluxco' ) ); ?>';

                if (data.success) {
                    var newType = isDefault ? 'default' : 'custom';
                    // Update the button in the table row
                    var btn = document.querySelector('.message-type-btn[data-client-id="' + currentClientId + '"]');
                    if (btn) {
                        btn.setAttribute('data-message-type', newType);
                        btn.setAttribute('data-custom-message', isDefault ? '' : customMsg);
                        btn.textContent = isDefault ? '<?php echo esc_js( __( 'Default', 'bfluxco' ) ); ?>' : '<?php echo esc_js( __( 'Custom', 'bfluxco' ) ); ?>';
                        btn.className = 'message-type-btn message-type-' + newType;
                    }
                    closeMsgModal();
                } else {
                    alert(data.data || '<?php echo esc_js( __( 'Error saving message.', 'bfluxco' ) ); ?>');
                }
            })
            .catch(function() {
                msgSaveBtn.disabled = false;
                msgSaveBtn.textContent = '<?php echo esc_js( __( 'Apply Custom Message', 'bfluxco' ) ); ?>';
                alert('<?php echo esc_js( __( 'Connection error. Please try again.', 'bfluxco' ) ); ?>');
            });
        });

        // =====================================================
        // SUCCESS MODAL (shown after creating/regenerating client)
        // =====================================================
        var successModal = document.getElementById('client-success-modal');
        var successEmail = document.getElementById('success-email');
        var successPassword = document.getElementById('success-password');
        var successExpires = document.getElementById('success-expires');
        var successMessage = document.getElementById('success-message');
        var copyPasswordBtn = document.getElementById('copy-password-btn');
        var copyMessageBtn = document.getElementById('copy-message-btn');
        var successModalClose = successModal.querySelector('.client-modal-close');
        var successModalDone = successModal.querySelector('.success-modal-done');
        var successModalBackdrop = successModal.querySelector('.client-modal-backdrop');

        function showSuccessModal(data) {
            // Populate credentials using textContent for safety
            successEmail.textContent = data.email || '';
            successPassword.textContent = data.password || '';
            successExpires.textContent = data.expires || '';

            // Build message with placeholders replaced
            var template = settingsTemplate;
            var clientName = data.name || data.email.split('@')[0] || 'Client';
            var message = template
                .replace(/\[CLIENT NAME\]/g, clientName)
                .replace(/\[PASSWORD\]/g, data.password || '')
                .replace(/\[EXPIRY DATE\]/g, data.expires || '');
            successMessage.value = message;

            // Show modal
            successModal.classList.add('is-open');
        }

        function closeSuccessModal() {
            successModal.classList.remove('is-open');
            // Reload page to show new client in list
            location.reload();
        }

        if (successModalClose) successModalClose.addEventListener('click', closeSuccessModal);
        if (successModalDone) successModalDone.addEventListener('click', closeSuccessModal);
        if (successModalBackdrop) successModalBackdrop.addEventListener('click', closeSuccessModal);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && successModal.classList.contains('is-open')) {
                closeSuccessModal();
            }
        });

        // Copy password button
        if (copyPasswordBtn) {
            copyPasswordBtn.addEventListener('click', function() {
                var pw = successPassword.textContent;
                if (copyToClipboard(pw)) {
                    var icon = this.querySelector('.dashicons');
                    icon.classList.remove('dashicons-clipboard');
                    icon.classList.add('dashicons-yes');
                    setTimeout(function() {
                        icon.classList.remove('dashicons-yes');
                        icon.classList.add('dashicons-clipboard');
                    }, 1500);
                }
            });
        }

        // Copy message button
        if (copyMessageBtn) {
            copyMessageBtn.addEventListener('click', function() {
                var msg = successMessage.value;
                if (copyToClipboard(msg)) {
                    var icon = this.querySelector('.dashicons');
                    var originalText = this.childNodes[1];
                    icon.classList.remove('dashicons-clipboard');
                    icon.classList.add('dashicons-yes');
                    if (originalText && originalText.nodeType === 3) {
                        originalText.textContent = ' <?php echo esc_js( __( 'Copied!', 'bfluxco' ) ); ?>';
                    }
                    setTimeout(function() {
                        icon.classList.remove('dashicons-yes');
                        icon.classList.add('dashicons-clipboard');
                        if (originalText && originalText.nodeType === 3) {
                            originalText.textContent = ' <?php echo esc_js( __( 'Copy Message', 'bfluxco' ) ); ?>';
                        }
                    }, 2000);
                }
            });
        }

        // =====================================================
        // REGENERATE PASSWORD (via AJAX, shows success modal)
        // =====================================================
        function regenerateAndShowCredentials(clientId, clientEmail, clientName, skipConfirm) {
            if (!skipConfirm && !confirm('<?php echo esc_js( __( 'This will generate a new password. The old password will no longer work. Continue?', 'bfluxco' ) ); ?>')) {
                return;
            }

            var formData = new FormData();
            formData.append('action', 'bfluxco_regenerate_client_password');
            formData.append('nonce', '<?php echo wp_create_nonce( 'bfluxco_client_access_admin' ); ?>');
            formData.append('client_id', clientId);

            fetch('<?php echo admin_url( 'admin-ajax.php' ); ?>', {
                method: 'POST',
                credentials: 'same-origin',
                body: formData
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.success) {
                    // Show success modal with new password
                    showSuccessModal({
                        email: clientEmail,
                        password: data.data.password,
                        expires: data.data.expires,
                        name: clientName
                    });
                } else {
                    alert(data.data || '<?php echo esc_js( __( 'Error regenerating password.', 'bfluxco' ) ); ?>');
                }
            })
            .catch(function() {
                alert('<?php echo esc_js( __( 'Connection error. Please try again.', 'bfluxco' ) ); ?>');
            });
        }

        // Regenerate button in dropdown menu
        document.querySelectorAll('.regenerate-pw-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                var clientId = this.getAttribute('data-client-id');
                var clientEmail = this.getAttribute('data-client-email');
                var clientName = this.getAttribute('data-client-name');

                // Close the action menu
                var menu = this.closest('.action-menu');
                if (menu) menu.classList.remove('is-open');

                regenerateAndShowCredentials(clientId, clientEmail, clientName, false);
            });
        });

        // Copy credentials button (clipboard icon)
        document.querySelectorAll('.copy-credentials-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                var clientId = this.getAttribute('data-client-id');
                var clientEmail = this.getAttribute('data-client-email');
                var clientName = this.getAttribute('data-client-name');

                regenerateAndShowCredentials(clientId, clientEmail, clientName, false);
            });
        });
        </script>
        <?php
    }

    /**
     * Output admin styles
     *
     * This method outputs all CSS for the password manager admin interface.
     *
     * @since 1.0.0
     * @return void
     */
    public static function admin_styles() {
        echo '<style>
            .bfluxco-password-manager { max-width: 100%; }
            .bfluxco-password-manager .password-table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.1); table-layout: auto; }
            .bfluxco-password-manager .password-table th,
            .bfluxco-password-manager .password-table td { padding: 12px 16px; text-align: left; border-bottom: 1px solid #e5e7eb; }
            .bfluxco-password-manager .password-table td:not(:last-child) { overflow: hidden; text-overflow: ellipsis; }
            .bfluxco-password-manager .password-table td:last-child { overflow: visible; }
            .bfluxco-password-manager .password-table th { background: #f9fafb; font-weight: 600; color: #374151; }
            .bfluxco-password-manager .password-table th:nth-child(7),
            .bfluxco-password-manager .password-table td:nth-child(7) { width: 1%; white-space: nowrap; }
            .bfluxco-password-manager .password-table tr:hover { background: #f9fafb; }
            .bfluxco-password-manager .password-display { font-family: monospace; font-size: 14px; background: #f3f4f6; padding: 6px 12px; border-radius: 4px; display: inline-block; }
            .bfluxco-password-manager .status-active { color: #059669; }
            .bfluxco-password-manager .status-expiring { color: #d97706; }
            .bfluxco-password-manager .status-expired { color: #dc2626; }
            .bfluxco-password-manager .settings-card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 24px; overflow: visible; }
            .bfluxco-password-manager .actions-bar { margin-bottom: 20px; display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
            .bfluxco-password-manager .notice { margin: 0 0 20px 0; }
            .bfluxco-password-manager .section-help { color: #6b7280; font-size: 14px; margin: 4px 0 16px 0; line-height: 1.5; max-width: 600px; }
            .bfluxco-password-manager .section-title { margin-bottom: 4px; }
            .bfluxco-password-manager .actions-help { flex-basis: 100%; color: #6b7280; font-size: 13px; margin-top: 4px; }
            .bfluxco-password-manager .intro-text { background: #eff6ff; border-left: 4px solid #3b82f6; padding: 16px 20px; margin-bottom: 24px; border-radius: 0 8px 8px 0; }
            .bfluxco-password-manager .intro-text p { margin: 0; color: #1e40af; font-size: 14px; line-height: 1.6; }
            .bfluxco-password-manager .status-revoked { color: #6b7280; }
            .bfluxco-password-manager .client-sub { font-size: 12px; color: #6b7280; margin-top: 2px; }
            .bfluxco-password-manager .action-icon-btn { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid #d1d5db; border-radius: 4px; background: #fff; color: #374151; text-decoration: none; margin-right: 4px; }
            .bfluxco-password-manager .action-icon-btn:hover { background: #f3f4f6; border-color: #9ca3af; }
            .bfluxco-password-manager .action-icon-btn.danger { color: #dc2626; border-color: #fecaca; }
            .bfluxco-password-manager .action-icon-btn.danger:hover { background: #fef2f2; }
            .bfluxco-password-manager .action-icon-btn .dashicons { font-size: 16px; width: 16px; height: 16px; }
            .bfluxco-password-manager .actions-cell { display: flex; align-items: center; gap: 4px; }
            .bfluxco-password-manager .action-menu-wrap { position: relative; }
            .bfluxco-password-manager .action-menu { display: none; position: absolute; top: 100%; right: 0; margin-top: 4px; background: #fff; border: 1px solid #d1d5db; border-radius: 6px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 180px; z-index: 100; }
            .bfluxco-password-manager .action-menu.is-open { display: block; }
            .bfluxco-password-manager .action-menu-item { display: flex; align-items: center; gap: 8px; padding: 10px 14px; color: #374151; text-decoration: none; font-size: 13px; white-space: nowrap; }
            .bfluxco-password-manager .action-menu-item:hover { background: #f3f4f6; }
            .bfluxco-password-manager .action-menu-item:first-child { border-radius: 6px 6px 0 0; }
            .bfluxco-password-manager .action-menu-item:last-child { border-radius: 0 0 6px 6px; }
            .bfluxco-password-manager .action-menu-item.danger { color: #dc2626; }
            .bfluxco-password-manager .action-menu-item.danger:hover { background: #fef2f2; }
            .bfluxco-password-manager .action-menu-item .dashicons { font-size: 16px; width: 16px; height: 16px; }
            .bfluxco-password-manager button.action-menu-item { background: none; border: none; width: 100%; text-align: left; cursor: pointer; }
            .bfluxco-password-manager .message-type-btn { padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 500; cursor: pointer; border: none; transition: all 0.2s; }
            .bfluxco-password-manager .message-type-btn:hover { opacity: 0.8; }
            .bfluxco-password-manager .message-type-default { background: #e5e7eb; color: #374151; }
            .bfluxco-password-manager .message-type-custom { background: #dbeafe; color: #1d4ed8; }
            .bfluxco-password-manager .section-header-row { display: flex; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 16px; }
            .bfluxco-password-manager .section-header-row .section-title { margin: 0; }
            .bfluxco-password-manager .section-header-row .section-help { margin: 4px 0 0 0; }
            .bfluxco-password-manager .section-header-actions { display: flex; align-items: center; gap: 12px; }
            .bfluxco-password-manager .section-header-3col { position: relative; display: flex; justify-content: space-between; align-items: center; }
            .bfluxco-password-manager .section-header-3col .search-center { position: absolute; left: 50%; transform: translateX(-50%); }
            .bfluxco-password-manager .action-buttons-group { display: flex; align-items: center; gap: 8px; }
            .bfluxco-password-manager .search-wrap { position: relative; display: inline-block; }
            .bfluxco-password-manager .client-search-input { width: 300px; padding: 8px 32px 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; }
            .bfluxco-password-manager .client-search-input:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
            .bfluxco-password-manager .search-clear-btn { position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #9ca3af; font-size: 18px; cursor: pointer; padding: 0; line-height: 1; display: none; }
            .bfluxco-password-manager .search-clear-btn:hover { color: #374151; }
            .bfluxco-password-manager .search-wrap.has-value .search-clear-btn { display: block; }
            .client-modal { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 100000; }
            .client-modal.is-open { display: block; }
            .client-modal-backdrop { position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); }
            .client-modal-content { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); width: 90%; max-width: 650px; }
            .client-modal-header { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid #e5e7eb; }
            .client-modal-header h3 { margin: 0; font-size: 18px; }
            .client-modal-close { background: none; border: none; font-size: 24px; color: #9ca3af; cursor: pointer; line-height: 1; padding: 0; }
            .client-modal-close:hover { color: #374151; }
            .client-modal-body { padding: 20px; }
            .client-modal-body .modal-help-text { margin: 0 0 20px 0; padding: 12px 16px; background: #f0f9ff; border-radius: 6px; font-size: 14px; color: #0369a1; line-height: 1.5; }
            .client-modal-body .form-row-inline { display: flex; gap: 16px; margin-bottom: 16px; }
            .client-modal-body .form-row-inline .form-field { flex: 1; margin-bottom: 0; }
            .client-modal-body .form-field { margin-bottom: 16px; }
            .client-modal-body .form-field label { display: block; font-weight: 500; margin-bottom: 6px; }
            .client-modal-body .form-field input { width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; box-sizing: border-box; }
            .client-modal-body .form-field input#new-client-name { max-width: 50%; }
            .client-modal-body .form-field input:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
            .client-modal-body .form-field input[type="number"] { -moz-appearance: textfield; }
            .client-modal-body .form-field input[type="number"]::-webkit-outer-spin-button,
            .client-modal-body .form-field input[type="number"]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
            .client-modal-body .number-input-wrap { position: relative; display: flex; align-items: center; }
            .client-modal-body .number-input-wrap input { flex: 1; padding-right: 44px; }
            .client-modal-body .number-stepper { position: absolute; right: 4px; display: flex; flex-direction: column; gap: 1px; }
            .client-modal-body .number-stepper button { width: 26px; height: 18px; border: 1px solid #d1d5db; background: #f9fafb; border-radius: 3px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #374151; padding: 0; line-height: 1; }
            .client-modal-body .number-stepper button:hover { background: #e5e7eb; border-color: #9ca3af; }
            .client-modal-body .duration-type-row { display: flex; gap: 20px; margin-bottom: 12px; }
            .client-modal-body .duration-type-option { display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 14px; font-weight: 400; color: #374151; }
            .client-modal-body .duration-type-option input[type="radio"] { width: 16px; height: 16px; margin: 0; cursor: pointer; accent-color: #3b82f6; }
            .client-modal-body .duration-input { display: none; max-width: 50%; }
            .client-modal-body .duration-input.is-active { display: block; }
            .client-modal-body .duration-hours select { width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; box-sizing: border-box; background: #fff; cursor: pointer; }
            .client-modal-body .duration-hours select:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
            .client-modal-body .form-help { margin: 0; font-size: 13px; color: #6b7280; }
            .client-modal-footer { display: flex; justify-content: flex-end; gap: 12px; padding: 16px 20px; border-top: 1px solid #e5e7eb; background: #f9fafb; border-radius: 0 0 8px 8px; }
            .client-modal-body .case-studies-list { margin-top: 12px; max-height: 200px; overflow-y: auto; border: 1px solid #e5e7eb; border-radius: 6px; background: #f9fafb; }
            .client-modal-body .case-study-item { display: flex; align-items: center; gap: 8px; padding: 10px 12px; border-bottom: 1px solid #e5e7eb; cursor: pointer; }
            .client-modal-body .case-study-item:last-child { border-bottom: none; }
            .client-modal-body .case-study-item:hover { background: #f3f4f6; }
            .client-modal-body .case-study-item input { margin: 0; }
            .client-modal-body .case-study-item span { font-size: 14px; }
            .client-modal-body .no-case-studies { padding: 16px; text-align: center; color: #6b7280; margin: 0; }
            #toggle-case-studies { border: none; background: none; color: #2563eb; padding: 0; cursor: pointer; text-decoration: underline; }
            #toggle-case-studies:hover { color: #1d4ed8; }
            .selected-summary { margin-top: 8px; font-size: 13px; color: #059669; }
            .client-modal-lg { max-width: 550px; }
            .cs-selected-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 12px; min-height: 28px; }
            .cs-selected-tags:empty { display: none; }
            .cs-tag { display: inline-flex; align-items: center; gap: 6px; background: #eff6ff; color: #1d4ed8; padding: 4px 8px 4px 10px; border-radius: 4px; font-size: 13px; }
            .cs-tag-remove { background: none; border: none; color: #1d4ed8; cursor: pointer; font-size: 16px; line-height: 1; padding: 0; opacity: 0.7; }
            .cs-tag-remove:hover { opacity: 1; }
            .cs-search-wrap { margin-bottom: 12px; }
            .cs-search-input { width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; box-sizing: border-box; }
            .cs-search-input:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
            .cs-select-actions { display: flex; gap: 8px; margin-bottom: 12px; }
            #cs-list { max-height: 250px; overflow-y: auto; border: 1px solid #e5e7eb; border-radius: 6px; }
            .cs-list-item { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-bottom: 1px solid #e5e7eb; cursor: pointer; }
            .cs-list-item:last-child { border-bottom: none; }
            .cs-list-item:hover { background: #f9fafb; }
            .cs-list-item input { margin: 0; width: 16px; height: 16px; }
            .cs-list-item .cs-item-title { flex: 1; font-size: 14px; color: #1f2937; }
            .cs-list-item .cs-item-industry { font-size: 12px; color: #6b7280; }
            .bfluxco-password-manager { padding-top: 90px; }
            .wrap.bfluxco-password-manager h1 { position: fixed !important; top: 32px !important; left: 160px !important; right: 0 !important; z-index: 101; background: #f0f0f1; margin: 0 !important; padding: 15px 20px 10px !important; font-size: 23px; font-weight: 400; line-height: 1.3; }
            .bfluxco-password-manager .nav-tab-wrapper { position: fixed; top: 77px; left: 160px; right: 0; z-index: 100; background: #f0f0f1; padding: 0 20px; border-bottom: 1px solid #c3c4c7; }
            @media screen and (max-width: 782px) { .wrap.bfluxco-password-manager h1 { top: 46px !important; left: 0 !important; } .bfluxco-password-manager .nav-tab-wrapper { top: 86px; left: 0; } }
            .folded .wrap.bfluxco-password-manager h1, .folded .bfluxco-password-manager .nav-tab-wrapper { left: 36px !important; }
            .bfluxco-password-manager .nav-tab { padding: 10px 16px; font-size: 14px; font-weight: 500; color: #50575e; text-decoration: none; border: 1px solid transparent; border-bottom: none; margin-bottom: -1px; background: transparent; }
            .bfluxco-password-manager .nav-tab:hover { color: #1d2327; }
            .bfluxco-password-manager .nav-tab-active { background: #fff; border-color: #c3c4c7; border-bottom-color: #fff; color: #1d2327; }
            .bfluxco-password-manager .tab-content { display: none; }
            .bfluxco-password-manager .tab-content.is-active { display: block; }
            .bfluxco-password-manager .email-template-textarea { width: 100%; font-family: monospace; font-size: 13px; padding: 12px; border-radius: 4px; border: 1px solid #d1d5db; background: #f9fafb; box-sizing: border-box; }
            .bfluxco-password-manager .email-template-textarea.is-editing { background: #fff; border-color: #3b82f6; }
            .bfluxco-password-manager .template-edit-actions { display: flex; align-items: center; gap: 8px; margin-top: 12px; }
            .bfluxco-password-manager .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 20px; }
            .bfluxco-password-manager .stat-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px 20px; text-align: center; }
            .bfluxco-password-manager .stat-value { font-size: 28px; font-weight: 600; color: #1f2937; line-height: 1.2; }
            .bfluxco-password-manager .stat-label { font-size: 13px; color: #6b7280; margin-top: 4px; }
            .bfluxco-password-manager .history-table .history-date { font-size: 13px; color: #6b7280; white-space: nowrap; }
            .bfluxco-password-manager .history-table .history-action { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500; }
            .bfluxco-password-manager .history-table .action-added { background: #ecfdf5; color: #065f46; }
            .bfluxco-password-manager .history-table .action-regenerated { background: #eff6ff; color: #1e40af; }
            .bfluxco-password-manager .history-table .action-revoked { background: #fef3c7; color: #92400e; }
            .bfluxco-password-manager .history-table .action-deleted { background: #fef2f2; color: #991b1b; }
            .bfluxco-password-manager .history-table .action-login { background: #f3f4f6; color: #374151; }
            .bfluxco-password-manager .history-table .history-client { font-weight: 500; color: #1f2937; }
            .bfluxco-password-manager .history-table .history-details { font-size: 13px; color: #6b7280; }
            .bfluxco-password-manager .history-table .history-user { font-size: 13px; color: #6b7280; }
            .bfluxco-password-manager .empty-state { text-align: center; padding: 64px 32px 56px; background: #f6f7f7; border: 1px dashed #dcdcde; border-radius: 4px; }
            .bfluxco-password-manager .empty-state .dashicons { font-size: 52px; width: 52px; height: 52px; color: #d1d5db; margin: 0 auto 16px; display: block; }
            .bfluxco-password-manager .empty-state p { margin: 0 0 6px 0; font-size: 17px; font-weight: 600; color: #4b5563; }
            .bfluxco-password-manager .empty-state-hint { font-size: 15px; color: #9ca3af; display: block; line-height: 1.5; }
            .bfluxco-password-manager .empty-state-action { margin-top: 20px; }
            #message-template-modal .client-modal-body { padding-top: 12px; }
            .bfluxco-password-manager .msg-edit-help { margin: 0 0 12px 0; font-size: 13px; color: #6b7280; line-height: 1.5; }
            .bfluxco-password-manager .client-modal-body textarea#custom-message-textarea,
            #message-template-modal textarea#custom-message-textarea { display: block; width: 100% !important; max-width: 100% !important; min-height: 220px; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-family: monospace; font-size: 13px; line-height: 1.6; resize: vertical; box-sizing: border-box !important; background: #f9fafb; }
            .bfluxco-password-manager .client-modal-body textarea#custom-message-textarea:focus,
            #message-template-modal textarea#custom-message-textarea:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); background: #fff; }
            .bfluxco-password-manager .modal-subtitle { font-size: 13px; color: #6b7280; margin-left: 12px; }
            .bfluxco-password-manager .client-modal-header { display: flex; align-items: center; }
            .bfluxco-password-manager .client-modal-header h3 { flex-shrink: 0; }
            .bfluxco-password-manager .client-modal-header .modal-subtitle { flex: 1; }
            .bfluxco-password-manager .client-modal-header .client-modal-close { margin-left: auto; }
        </style>';
    }
}
