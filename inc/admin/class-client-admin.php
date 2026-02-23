<?php
/**
 * Client Access Admin UI
 *
 * Handles the admin interface rendering for the Client Access Manager.
 * Extracted from BFLUXCO_Client_Access class to improve code organization.
 *
 * @package BFLUXCO
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class BFLUXCO_Client_Admin
 *
 * Manages the admin UI for client access management, including:
 * - Admin page rendering
 * - Admin styles output
 * - Client list display
 * - Add client form
 *
 * @since 1.0.0
 */
class BFLUXCO_Client_Admin {

    /**
     * Output admin styles
     *
     * @since 1.0.0
     * @return void
     */
    public static function admin_styles() {
        ?>
        <style>
            .bfluxco-client-access { max-width: 1600px; }
            .bfluxco-client-access .card { background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 24px; }
            .bfluxco-client-access .card-title { margin: 0 0 8px 0; font-size: 18px; font-weight: 600; }
            .bfluxco-client-access .card-desc { color: #6b7280; font-size: 14px; margin: 0 0 20px 0; max-width: 700px; }
            .bfluxco-client-access .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
            .bfluxco-client-access .stat-card { background: #fff; padding: 16px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); text-align: center; }
            .bfluxco-client-access .stat-value { font-size: 28px; font-weight: 700; color: #1f2937; }
            .bfluxco-client-access .stat-label { font-size: 13px; color: #6b7280; margin-top: 4px; }

            /* Single column layout like password manager */
            .bfluxco-client-access .add-client-card { margin-bottom: 24px; }
            .bfluxco-client-access .add-client-card .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
            .bfluxco-client-access .add-client-card .form-grid .form-col { }
            @media (max-width: 900px) { .bfluxco-client-access .add-client-card .form-grid { grid-template-columns: 1fr; } }

            .bfluxco-client-access .form-row { margin-bottom: 16px; }
            .bfluxco-client-access .form-row label { display: block; font-weight: 500; margin-bottom: 6px; }
            .bfluxco-client-access .form-row input[type="email"],
            .bfluxco-client-access .form-row input[type="number"] { width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; box-sizing: border-box; }
            .bfluxco-client-access .case-studies-grid { display: flex; flex-direction: column; gap: 8px; max-height: 240px; overflow-y: auto; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; background: #f9fafb; }
            .bfluxco-client-access .case-study-checkbox { display: flex; align-items: flex-start; gap: 10px; padding: 10px; background: #fff; border-radius: 6px; border: 1px solid #e5e7eb; cursor: pointer; transition: border-color 0.2s; }
            .bfluxco-client-access .case-study-checkbox:hover { border-color: #3b82f6; }
            .bfluxco-client-access .case-study-checkbox input { margin-top: 2px; }
            .bfluxco-client-access .case-study-checkbox .cs-title { font-weight: 500; font-size: 14px; }
            .bfluxco-client-access .case-study-checkbox .cs-meta { font-size: 12px; color: #6b7280; }
            .bfluxco-client-access .success-box { background: #ecfdf5; border: 1px solid #10b981; border-radius: 8px; padding: 20px; margin-top: 20px; display: none; }
            .bfluxco-client-access .success-box.show { display: block; }
            .bfluxco-client-access .success-box h4 { margin: 0 0 12px 0; color: #065f46; }
            .bfluxco-client-access .password-display { font-family: monospace; font-size: 16px; background: #fff; padding: 10px 14px; border-radius: 6px; border: 1px solid #d1d5db; display: inline-block; margin-right: 12px; }

            /* Search bar */
            .bfluxco-client-access .search-bar { margin-bottom: 16px; }
            .bfluxco-client-access .search-bar input { width: 100%; padding: 10px 12px 10px 36px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; box-sizing: border-box; background: #fff url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="%236b7280" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>') 10px center no-repeat; }
            .bfluxco-client-access .search-bar input:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }

            /* Client table */
            .bfluxco-client-access .client-table { width: 100%; border-collapse: collapse; }
            .bfluxco-client-access .client-table th { text-align: left; padding: 12px 16px; font-weight: 600; color: #6b7280; font-size: 13px; border-bottom: 2px solid #e5e7eb; white-space: nowrap; }
            .bfluxco-client-access .client-table td { padding: 16px; border-bottom: 1px solid #e5e7eb; vertical-align: top; }
            .bfluxco-client-access .client-table tr:hover td { background: #f9fafb; }
            .bfluxco-client-access .client-table .client-email { font-weight: 600; color: #2563eb; text-decoration: none; display: block; }
            .bfluxco-client-access .client-table .client-email:hover { text-decoration: underline; }
            .bfluxco-client-access .client-table .client-sub { font-size: 12px; color: #6b7280; margin-top: 2px; }
            .bfluxco-client-access .client-table .case-study-list { font-size: 13px; color: #374151; line-height: 1.5; }
            .bfluxco-client-access .status-active { color: #059669; font-weight: 500; }
            .bfluxco-client-access .status-expiring { color: #d97706; font-weight: 500; }
            .bfluxco-client-access .status-expired { color: #dc2626; font-weight: 500; }
            .bfluxco-client-access .status-revoked { color: #6b7280; font-weight: 500; }
            .bfluxco-client-access .client-table .actions-cell { white-space: nowrap; }
            .bfluxco-client-access .action-btn { padding: 6px 12px; border: 1px solid #d1d5db; background: #fff; border-radius: 4px; cursor: pointer; font-size: 13px; margin-right: 4px; }
            .bfluxco-client-access .action-btn:hover { background: #f9fafb; border-color: #9ca3af; }
            .bfluxco-client-access .action-btn.danger { color: #dc2626; border-color: #fecaca; }
            .bfluxco-client-access .action-btn.danger:hover { background: #fef2f2; }
            .bfluxco-client-access .intro-banner { background: #eff6ff; border-left: 4px solid #3b82f6; padding: 16px 20px; margin-bottom: 24px; border-radius: 0 8px 8px 0; }
            .bfluxco-client-access .intro-banner p { margin: 0; color: #1e40af; font-size: 14px; }
            .bfluxco-client-access .empty-state { text-align: center; padding: 40px; color: #6b7280; }
            .bfluxco-client-access .no-results { text-align: center; padding: 30px; color: #6b7280; display: none; }

            /* Responsive */
            @media (max-width: 900px) {
                .bfluxco-client-access .stats-row { grid-template-columns: repeat(2, 1fr); }
            }
        </style>
        <?php
    }

    /**
     * Render the admin page
     *
     * @since 1.0.0
     * @return void
     */
    public static function render_admin_page() {
        $clients  = BFLUXCO_Client_Access::get_clients();
        $settings = BFLUXCO_Client_Access::get_settings();

        // Get all case studies for the form
        $case_studies = get_posts(
            array(
                'post_type'      => 'case_study',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'title',
                'order'          => 'ASC',
            )
        );

        // Get protected case studies count
        $protected_count = 0;
        foreach ( $case_studies as $cs ) {
            if ( ! empty( $cs->post_password ) ) {
                $protected_count++;
            }
        }

        // Count stats
        $now            = current_time( 'timestamp' );
        $active_count   = 0;
        $expiring_count = 0;
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
        <div class="wrap bfluxco-client-access">
            <h1><?php esc_html_e( 'Client Access Manager', 'bfluxco' ); ?></h1>

            <div class="intro-banner">
                <p><?php esc_html_e( 'Manage client access to protected case studies. Each client receives unique credentials (email + password) that grant access to specific case studies you assign to them.', 'bfluxco' ); ?></p>
            </div>

            <!-- Stats -->
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-value"><?php echo count( $clients ); ?></div>
                    <div class="stat-label"><?php esc_html_e( 'Total Clients', 'bfluxco' ); ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $active_count; ?></div>
                    <div class="stat-label"><?php esc_html_e( 'Active Clients', 'bfluxco' ); ?></div>
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

            <?php
            self::render_add_client_form( $case_studies, $settings );
            self::render_client_list( $clients, $now );
            self::render_admin_scripts();
            ?>
        </div>
        <?php
    }

    /**
     * Render add client form
     *
     * @since 1.0.0
     * @param array $case_studies Array of case study posts.
     * @param array $settings     Current settings.
     * @return void
     */
    private static function render_add_client_form( $case_studies, $settings ) {
        ?>
        <!-- Add Client Card -->
        <div class="card add-client-card">
            <h2 class="card-title"><?php esc_html_e( 'Add New Client', 'bfluxco' ); ?></h2>
            <p class="card-desc"><?php esc_html_e( 'Create access credentials for a new client. Select which case studies they can access.', 'bfluxco' ); ?></p>

            <form id="add-client-form">
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'bfluxco_client_access_admin' ); ?>">

                <div class="form-grid">
                    <div class="form-col">
                        <div class="form-row">
                            <label for="client-email"><?php esc_html_e( 'Client Email', 'bfluxco' ); ?></label>
                            <input type="email" id="client-email" name="email" placeholder="client@company.com" required>
                        </div>

                        <div class="form-row">
                            <label for="expiry-days"><?php esc_html_e( 'Access Duration (days)', 'bfluxco' ); ?></label>
                            <input type="number" id="expiry-days" name="expiry_days" value="<?php echo esc_attr( $settings['default_expiry_days'] ); ?>" min="1" max="365">
                        </div>

                        <button type="submit" class="button button-primary" id="add-client-btn">
                            <?php esc_html_e( 'Generate Access', 'bfluxco' ); ?>
                        </button>
                    </div>

                    <div class="form-col">
                        <div class="form-row">
                            <label><?php esc_html_e( 'Case Studies', 'bfluxco' ); ?></label>
                            <div class="case-studies-grid">
                                <?php if ( empty( $case_studies ) ) : ?>
                                    <p><?php esc_html_e( 'No case studies found.', 'bfluxco' ); ?></p>
                                <?php else : ?>
                                    <?php
                                    foreach ( $case_studies as $cs ) :
                                        $is_protected  = ! empty( $cs->post_password );
                                        $industries    = get_the_terms( $cs->ID, 'industry' );
                                        $industry_name = $industries ? $industries[0]->name : '';
                                        ?>
                                        <label class="case-study-checkbox">
                                            <input type="checkbox" name="case_studies[]" value="<?php echo esc_attr( $cs->ID ); ?>">
                                            <div>
                                                <div class="cs-title"><?php echo esc_html( $cs->post_title ); ?></div>
                                                <div class="cs-meta">
                                                    <?php echo esc_html( $industry_name ); ?>
                                                    <?php if ( $is_protected ) : ?>
                                                        <span style="color: #059669;">● Protected</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </label>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="success-box" id="success-box">
                    <h4><?php esc_html_e( 'Client Access Created!', 'bfluxco' ); ?></h4>
                    <p><strong><?php esc_html_e( 'Email:', 'bfluxco' ); ?></strong> <span id="created-email"></span></p>
                    <p><strong><?php esc_html_e( 'Password:', 'bfluxco' ); ?></strong> <span class="password-display" id="created-password"></span></p>
                    <p><strong><?php esc_html_e( 'Expires:', 'bfluxco' ); ?></strong> <span id="created-expires"></span></p>
                    <button type="button" class="button" id="copy-credentials-btn">
                        <?php esc_html_e( 'Copy Message', 'bfluxco' ); ?>
                    </button>
                </div>
            </form>
        </div>
        <?php
    }

    /**
     * Render client list
     *
     * @since 1.0.0
     * @param array $clients Array of client data.
     * @param int   $now     Current timestamp.
     * @return void
     */
    private static function render_client_list( $clients, $now ) {
        ?>
        <!-- Client List Card -->
        <div class="card">
            <h2 class="card-title"><?php esc_html_e( 'Client List', 'bfluxco' ); ?></h2>
            <p class="card-desc"><?php esc_html_e( 'All clients with access to protected case studies. Click Regenerate to create a new password.', 'bfluxco' ); ?></p>

            <!-- Search Bar -->
            <div class="search-bar">
                <input type="text" id="client-search" placeholder="<?php esc_attr_e( 'Search clients...', 'bfluxco' ); ?>">
            </div>

            <?php if ( empty( $clients ) ) : ?>
                <div class="empty-state">
                    <p><?php esc_html_e( 'No clients yet. Add your first client using the form above.', 'bfluxco' ); ?></p>
                </div>
            <?php else : ?>
                <table class="client-table" id="client-table">
                    <thead>
                        <tr>
                            <th><?php esc_html_e( 'Client', 'bfluxco' ); ?></th>
                            <th><?php esc_html_e( 'Case Studies', 'bfluxco' ); ?></th>
                            <th><?php esc_html_e( 'Status', 'bfluxco' ); ?></th>
                            <th><?php esc_html_e( 'Expires', 'bfluxco' ); ?></th>
                            <th><?php esc_html_e( 'Actions', 'bfluxco' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ( $clients as $client_id => $client ) :
                        // Determine status
                        $status       = $client['status'];
                        $status_class = 'status-' . $status;
                        $status_label = ucfirst( $status );

                        if ( $status === 'active' ) {
                            $days_until = floor( ( $client['expires_at'] - $now ) / DAY_IN_SECONDS );
                            if ( $days_until <= 0 ) {
                                $status       = 'expired';
                                $status_class = 'status-expired';
                                $status_label = __( 'Expired', 'bfluxco' );
                            } elseif ( $days_until <= 7 ) {
                                $status_class = 'status-expiring';
                                $status_label = sprintf( __( 'Expiring (%dd)', 'bfluxco' ), $days_until );
                            } else {
                                $status_label = __( 'Active', 'bfluxco' );
                            }
                        }

                        // Get case study titles
                        $cs_titles = array();
                        foreach ( $client['case_studies'] as $cs_id ) {
                            $cs_post = get_post( $cs_id );
                            if ( $cs_post ) {
                                $cs_titles[] = $cs_post->post_title;
                            }
                        }
                        ?>
                        <tr data-client-id="<?php echo esc_attr( $client_id ); ?>" data-email="<?php echo esc_attr( strtolower( $client['email'] ) ); ?>">
                            <td>
                                <span class="client-email"><?php echo esc_html( $client['email'] ); ?></span>
                                <div class="client-sub"><?php echo esc_html( sprintf( _n( '%d case study', '%d case studies', count( $cs_titles ), 'bfluxco' ), count( $cs_titles ) ) ); ?></div>
                            </td>
                            <td>
                                <div class="case-study-list">
                                    <?php echo esc_html( implode( ', ', array_slice( $cs_titles, 0, 3 ) ) ); ?>
                                    <?php if ( count( $cs_titles ) > 3 ) : ?>
                                        <em>+<?php echo count( $cs_titles ) - 3; ?> more</em>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <span class="<?php echo esc_attr( $status_class ); ?>"><?php echo esc_html( $status_label ); ?></span>
                            </td>
                            <td>
                                <?php echo esc_html( date_i18n( 'F j, Y', $client['expires_at'] ) ); ?>
                            </td>
                            <td class="actions-cell">
                                <button type="button" class="action-btn btn-regenerate" data-client-id="<?php echo esc_attr( $client_id ); ?>"><?php esc_html_e( 'Regenerate', 'bfluxco' ); ?></button>
                                <?php if ( $client['status'] === 'active' ) : ?>
                                <button type="button" class="action-btn btn-revoke" data-client-id="<?php echo esc_attr( $client_id ); ?>"><?php esc_html_e( 'Revoke', 'bfluxco' ); ?></button>
                                <?php endif; ?>
                                <button type="button" class="action-btn danger btn-delete" data-client-id="<?php echo esc_attr( $client_id ); ?>"><?php esc_html_e( 'Delete', 'bfluxco' ); ?></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="no-results" id="no-results">
                    <p><?php esc_html_e( 'No clients match your search.', 'bfluxco' ); ?></p>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * Render admin scripts
     *
     * @since 1.0.0
     * @return void
     */
    private static function render_admin_scripts() {
        ?>
        <script>
        (function($) {
            var nonce = '<?php echo wp_create_nonce( 'bfluxco_client_access_admin' ); ?>';
            var ajaxUrl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
            var createdClient = null;

            // Add client form
            $('#add-client-form').on('submit', function(e) {
                e.preventDefault();

                var $btn = $('#add-client-btn');
                var email = $('#client-email').val();
                var caseStudies = [];
                $('input[name="case_studies[]"]:checked').each(function() {
                    caseStudies.push($(this).val());
                });
                var expiryDays = $('#expiry-days').val();

                if (caseStudies.length === 0) {
                    alert('<?php echo esc_js( __( 'Please select at least one case study.', 'bfluxco' ) ); ?>');
                    return;
                }

                $btn.prop('disabled', true).text('<?php echo esc_js( __( 'Creating...', 'bfluxco' ) ); ?>');

                $.post(ajaxUrl, {
                    action: 'bfluxco_add_client',
                    nonce: nonce,
                    email: email,
                    case_studies: caseStudies,
                    expiry_days: expiryDays
                }, function(response) {
                    $btn.prop('disabled', false).text('<?php echo esc_js( __( 'Generate Access', 'bfluxco' ) ); ?>');

                    if (response.success) {
                        createdClient = response.data;
                        $('#created-email').text(response.data.email);
                        $('#created-password').text(response.data.password);
                        $('#created-expires').text(response.data.expires);
                        $('#success-box').addClass('show');

                        // Reset form
                        $('#add-client-form')[0].reset();
                        $('input[name="case_studies[]"]').prop('checked', false);

                        // Reload after 3 seconds to show new client
                        setTimeout(function() {
                            location.reload();
                        }, 5000);
                    } else {
                        alert(response.data);
                    }
                });
            });

            // Copy credentials
            $('#copy-credentials-btn').on('click', function() {
                if (!createdClient) return;

                var message = 'Hi,\n\n';
                message += 'ACCESS DETAILS\n';
                message += '-----------------------------------\n';
                message += 'Email: ' + createdClient.email + '\n';
                message += 'Password: ' + createdClient.password + '\n';
                message += 'Expires: ' + createdClient.expires + '\n';
                message += '-----------------------------------\n\n';
                message += 'CASE STUDIES\n';

                createdClient.case_studies.forEach(function(cs) {
                    message += '- ' + cs.title + '\n';
                    message += '  ' + cs.url + '\n\n';
                });

                message += 'Simply visit any of the URLs above, enter your email and password when prompted, and you\'ll have access.\n\n';
                message += 'Best regards,\nRay';

                copyToClipboard(message);
                alert('<?php echo esc_js( __( 'Message copied to clipboard!', 'bfluxco' ) ); ?>');
            });

            // Regenerate password
            $('.btn-regenerate').on('click', function() {
                var clientId = $(this).data('client-id');
                var $btn = $(this);

                if (!confirm('<?php echo esc_js( __( 'Regenerate password for this client? Their current password will stop working.', 'bfluxco' ) ); ?>')) {
                    return;
                }

                $btn.prop('disabled', true).text('...');

                $.post(ajaxUrl, {
                    action: 'bfluxco_regenerate_client_password',
                    nonce: nonce,
                    client_id: clientId
                }, function(response) {
                    if (response.success) {
                        alert('<?php echo esc_js( __( 'New password:', 'bfluxco' ) ); ?> ' + response.data.password);
                        location.reload();
                    } else {
                        alert(response.data);
                        $btn.prop('disabled', false).text('<?php echo esc_js( __( 'Regenerate', 'bfluxco' ) ); ?>');
                    }
                });
            });

            // Revoke
            $('.btn-revoke').on('click', function() {
                var clientId = $(this).data('client-id');

                if (!confirm('<?php echo esc_js( __( 'Revoke access for this client?', 'bfluxco' ) ); ?>')) {
                    return;
                }

                $.post(ajaxUrl, {
                    action: 'bfluxco_revoke_client',
                    nonce: nonce,
                    client_id: clientId
                }, function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.data);
                    }
                });
            });

            // Delete
            $('.btn-delete').on('click', function() {
                var clientId = $(this).data('client-id');

                if (!confirm('<?php echo esc_js( __( 'Delete this client? This cannot be undone.', 'bfluxco' ) ); ?>')) {
                    return;
                }

                $.post(ajaxUrl, {
                    action: 'bfluxco_delete_client',
                    nonce: nonce,
                    client_id: clientId
                }, function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.data);
                    }
                });
            });

            // Client search functionality
            $('#client-search').on('input', function() {
                var query = $(this).val().toLowerCase().trim();
                var $rows = $('#client-table tbody tr');
                var visibleCount = 0;

                $rows.each(function() {
                    var email = $(this).data('email') || '';
                    if (query === '' || email.indexOf(query) !== -1) {
                        $(this).show();
                        visibleCount++;
                    } else {
                        $(this).hide();
                    }
                });

                // Show/hide no results message
                if (visibleCount === 0 && query !== '') {
                    $('#no-results').show();
                } else {
                    $('#no-results').hide();
                }
            });

            // Copy to clipboard helper
            function copyToClipboard(text) {
                var textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.style.position = 'fixed';
                textarea.style.left = '-9999px';
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    document.execCommand('copy');
                } catch (err) {
                    console.error('Copy failed:', err);
                }
                document.body.removeChild(textarea);
            }
        })(jQuery);
        </script>
        <?php
    }
}
