# Support Console Plugin Documentation

> WordPress admin plugin for managing Low Ox Life support tickets via Supabase.
> Last Updated: 2026-01-06

---

## Table of Contents

1. [Overview](#overview)
2. [Architecture](#architecture)
3. [Installation & Configuration](#installation--configuration)
4. [Security Model](#security-model)
5. [API Reference](#api-reference)
6. [Admin Interface](#admin-interface)
7. [Notification Flow](#notification-flow)
8. [Database Schema](#database-schema)
9. [Troubleshooting](#troubleshooting)
10. [Future Development](#future-development)

---

## Overview

The Support Console plugin enables WordPress administrators to:

- View and manage support tickets from the Low Ox Life iOS app
- Reply to user tickets with push notification delivery
- Update ticket status (open, in progress, resolved, closed)
- View user diagnostics (app version, device info)
- Upload image attachments to replies
- Use canned replies for common responses

### Tech Stack

| Component | Technology |
|-----------|------------|
| Frontend | WordPress Admin UI, jQuery, AJAX |
| Backend | PHP 7.4+, WordPress REST/AJAX API |
| Database | Supabase (PostgreSQL) |
| Authentication | HMAC-SHA256 signed requests |
| Notifications | Supabase Edge Functions → APNs |

---

## Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                    WordPress Admin                           │
├─────────────────────────────────────────────────────────────┤
│  Tickets Page  │  Ticket Detail  │  Settings  │  AJAX       │
│       ↓               ↓                ↓           ↓        │
│            SCS_Ajax_Handlers (admin-ajax.php)               │
│                          ↓                                   │
│                   SCS_Supabase_API                          │
│                          ↓                                   │
│            HMAC-signed HTTP requests                        │
└─────────────────────────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────┐
│                   Supabase Edge Functions                    │
├─────────────────────────────────────────────────────────────┤
│  support-list-tickets  │  support-get-ticket                │
│  support-reply         │  support-update-status             │
│  support-upload-attachment                                   │
└─────────────────────────────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────┐
│                    Supabase Database                         │
├─────────────────────────────────────────────────────────────┤
│  support_tickets  │  support_messages  │  support_attachments│
│  notifications    │  device_tokens     │  push_notification_log│
└─────────────────────────────────────────────────────────────┘
```

---

## Installation & Configuration

### Requirements

- WordPress 5.0+
- PHP 7.4+
- Supabase project with Edge Functions deployed
- SSL certificate (HTTPS required)

### Installation

1. Upload plugin folder to `/wp-content/plugins/support-console-supabase/`
2. Activate plugin in WordPress admin
3. Navigate to **Support Console → Settings**
4. Configure the following:

### Settings

| Setting | Description | Example |
|---------|-------------|---------|
| **Edge Functions URL** | Supabase Edge Functions base URL | `https://kuzfkhypknxfvjvgfvfd.supabase.co/functions/v1` |
| **Supabase Anon Key** | Publishable API key for Authorization header | `sb_publishable_FmCxP3...` |
| **Shared Secret** | HMAC signing secret (min 16 chars) | Generate using "Generate" button |

### Shared Secret Setup

The shared secret MUST match in both WordPress and Supabase:

1. Generate a secret in WordPress (Settings → Generate button)
2. Copy the secret
3. Set in Supabase Edge Functions:

```bash
supabase secrets set WP_SHARED_SECRET="your-generated-secret" --project-ref your-project-id
```

4. Redeploy edge functions:

```bash
supabase functions deploy support-reply --project-ref your-project-id
supabase functions deploy support-list-tickets --project-ref your-project-id
# ... deploy all support-* functions
```

---

## Security Model

### HMAC-SHA256 Request Signing

Every request from WordPress to Supabase is signed to prevent tampering and ensure authenticity.

**Signature Generation** (`class-supabase-api.php`):

```php
private static function sign_request($path, $body, $secret) {
    $timestamp = time();
    $nonce = wp_generate_uuid4();

    // Build signature payload: timestamp.nonce.path.body
    $payload = "{$timestamp}.{$nonce}.{$path}.{$body}";

    // Compute HMAC-SHA256
    $signature = hash_hmac('sha256', $payload, $secret);

    return array(
        'x-wp-timestamp' => (string) $timestamp,
        'x-wp-nonce' => $nonce,
        'x-wp-signature' => $signature,
    );
}
```

### Request Headers

| Header | Description |
|--------|-------------|
| `Authorization` | `Bearer {anon_key}` - Required by Supabase |
| `x-wp-timestamp` | Unix timestamp (seconds) |
| `x-wp-nonce` | UUID for replay protection |
| `x-wp-signature` | HMAC-SHA256 signature |
| `x-wp-agent-id` | WordPress user ID |
| `x-wp-agent-name` | WordPress display name |
| `Content-Type` | `application/json` |

### Signature Verification (Edge Function)

```typescript
// In Supabase edge function
export async function verifyWordPressSignature(
    request: Request,
    path: string,
    body: string
): Promise<{ agentId: string; agentName: string }> {
    const timestamp = request.headers.get('x-wp-timestamp');
    const nonce = request.headers.get('x-wp-nonce');
    const signature = request.headers.get('x-wp-signature');

    // Reject if timestamp is more than 5 minutes old
    const now = Math.floor(Date.now() / 1000);
    if (Math.abs(now - parseInt(timestamp)) > 300) {
        throw new Error('Request expired');
    }

    // Verify signature
    const payload = `${timestamp}.${nonce}.${path}.${body}`;
    const expectedSignature = await hmacSha256(payload, WP_SHARED_SECRET);

    if (signature !== expectedSignature) {
        throw new Error('Invalid signature');
    }

    return {
        agentId: request.headers.get('x-wp-agent-id'),
        agentName: request.headers.get('x-wp-agent-name')
    };
}
```

### Security Features

| Feature | Implementation |
|---------|----------------|
| Request Signing | HMAC-SHA256 on every request |
| Replay Protection | Timestamp + nonce combination |
| Time Window | 5-minute maximum request age |
| Agent Tracking | WordPress user ID/name in headers |
| Audit Logging | All actions logged with agent info |

---

## API Reference

### SCS_Supabase_API Class

**File**: `includes/class-supabase-api.php`

#### `request($function_name, $data)`

Make a signed request to a Supabase Edge Function.

```php
$result = SCS_Supabase_API::request('support-list-tickets', array(
    'page' => 1,
    'limit' => 20,
    'status' => 'open'
));

if (is_wp_error($result)) {
    // Handle error
    $error_message = $result->get_error_message();
} else {
    // Use result
    $tickets = $result['tickets'];
    $total = $result['total'];
}
```

#### `upload_file($ticket_id, $file, $message_id)`

Upload an attachment to a support ticket.

```php
$result = SCS_Supabase_API::upload_file(
    'ticket-uuid',
    $_FILES['attachment'],
    'message-uuid'  // Optional
);
```

#### `test_connection()`

Test connectivity to Supabase.

```php
$result = SCS_Supabase_API::test_connection();
if ($result === true) {
    // Connected successfully
} else {
    // $result is WP_Error
}
```

### AJAX Endpoints

All AJAX handlers are in `includes/class-ajax-handlers.php`.

| Action | Description | Required Params |
|--------|-------------|-----------------|
| `scs_list_tickets` | Get paginated ticket list | page, limit, status?, search? |
| `scs_get_ticket` | Get ticket with messages | ticket_id |
| `scs_send_reply` | Send support reply | ticket_id, message |
| `scs_update_status` | Change ticket status | ticket_id, status |
| `scs_upload_attachment` | Upload image | ticket_id, file |
| `scs_test_connection` | Test Supabase connection | - |

### AJAX Example

```javascript
jQuery.ajax({
    url: ajaxurl,
    method: 'POST',
    data: {
        action: 'scs_send_reply',
        nonce: scs_data.nonce,
        ticket_id: ticketId,
        message: messageText
    },
    success: function(response) {
        if (response.success) {
            // Reply sent, response.data contains the message
        } else {
            // Error, response.data contains error message
        }
    }
});
```

---

## Admin Interface

### Tickets List Page

**File**: `admin/tickets-page.php`

Features:
- Filter by status (All, Open, Awaiting User, In Progress, Resolved, Closed)
- Filter by topic and severity
- Search by subject or user email
- Pagination
- Click to view ticket detail

### Ticket Detail Page

**File**: `admin/ticket-detail-page.php`

Features:
- Full conversation thread (user and support messages)
- Diagnostics panel (collapsible)
  - App version
  - iOS version
  - Device model
  - Custom diagnostics JSON
- Status selector (updates in real-time)
- Reply form with:
  - Rich text area
  - Canned replies dropdown
  - Image attachment upload
- Attachment viewer for existing attachments

### Settings Page

**File**: `admin/settings-page.php`

Sections:
- **Supabase Connection**: URL, anon key, shared secret
- **Display Settings**: Tickets per page (10-100)
- **Canned Replies**: Pre-written responses (add/edit/delete)
- **Connection Test**: Verify connectivity

### Canned Replies

Pre-configured response templates:

| Title | Use Case |
|-------|----------|
| Greeting | Initial response to new tickets |
| Need More Info | Request additional details |
| Issue Resolved | Close out resolved tickets |
| Feature Request Noted | Acknowledge feature suggestions |
| Technical Investigation | Inform user of ongoing investigation |

Custom canned replies can be added in Settings.

---

## Notification Flow

When a support agent sends a reply, the following happens:

```
1. Agent types reply in WordPress admin
              ↓
2. WordPress creates HMAC-signed request
              ↓
3. POST to support-reply edge function
              ↓
4. Edge function verifies signature
              ↓
5. Creates support_messages row (author_type='support')
              ↓
6. Creates notifications row (category='support')
              ↓
7. Queries unread notification count
              ↓
8. Calls send-push-notification edge function
              ↓
9. APNs delivers push to user's device(s)
              ↓
10. User sees notification and badge on app icon
```

### Push Notification Payload

```json
{
    "aps": {
        "alert": {
            "title": "New Support Reply",
            "body": "Support has responded to ticket #LOL-1234: \"Your issue...\""
        },
        "badge": 3,
        "sound": "default",
        "category": "support"
    },
    "data": {
        "type": "support_reply",
        "ticket_number": "1234"
    }
}
```

### In-App Notification

```json
{
    "category": "support",
    "priority": "high",
    "title": "New Support Reply",
    "message": "Support has responded to ticket #LOL-1234",
    "metadata": {
        "ticket_id": "uuid",
        "ticket_number": 1234,
        "message_id": "uuid",
        "agent_name": "Ray - Support"
    },
    "actions": [
        {
            "type": "view_ticket",
            "label": "View Ticket"
        }
    ]
}
```

---

## Database Schema

### Enums

```sql
CREATE TYPE ticket_status AS ENUM (
    'open',
    'awaiting_user',
    'in_progress',
    'resolved',
    'closed'
);

CREATE TYPE ticket_topic AS ENUM (
    'bug_report',
    'feature_request',
    'account_issue',
    'food_data',
    'recipe_issue',
    'import_export',
    'billing',
    'general'
);

CREATE TYPE ticket_severity AS ENUM (
    'low',
    'medium',
    'high',
    'critical'
);

CREATE TYPE message_author_type AS ENUM (
    'user',
    'support',
    'system'
);
```

### support_tickets

```sql
CREATE TABLE support_tickets (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    user_id UUID NOT NULL REFERENCES auth.users(id) ON DELETE CASCADE,
    ticket_number INTEGER NOT NULL UNIQUE,
    subject TEXT NOT NULL,
    topic ticket_topic NOT NULL,
    severity ticket_severity NOT NULL DEFAULT 'medium',
    status ticket_status NOT NULL DEFAULT 'open',

    -- Diagnostics
    app_version TEXT,
    ios_version TEXT,
    device_model TEXT,
    diagnostics_json JSONB,

    -- Timestamps
    last_user_message_at TIMESTAMPTZ,
    last_support_message_at TIMESTAMPTZ,
    resolved_at TIMESTAMPTZ,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);
```

### support_messages

```sql
CREATE TABLE support_messages (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    ticket_id UUID NOT NULL REFERENCES support_tickets(id) ON DELETE CASCADE,
    author_type message_author_type NOT NULL,
    author_id UUID,           -- WordPress user ID for support agents
    author_name TEXT,         -- Display name
    body TEXT NOT NULL,
    is_read BOOLEAN NOT NULL DEFAULT false,
    read_at TIMESTAMPTZ,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

-- Trigger to auto-update ticket status on support reply
CREATE TRIGGER update_ticket_on_message
    AFTER INSERT ON support_messages
    FOR EACH ROW
    EXECUTE FUNCTION update_ticket_on_support_message();
```

### support_attachments

```sql
CREATE TABLE support_attachments (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    message_id UUID NOT NULL REFERENCES support_messages(id) ON DELETE CASCADE,
    ticket_id UUID NOT NULL REFERENCES support_tickets(id) ON DELETE CASCADE,
    file_name TEXT NOT NULL,
    file_path TEXT NOT NULL,
    file_size INTEGER,
    mime_type TEXT,  -- image/jpeg, image/png, image/heic only
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);
```

---

## Troubleshooting

### "Invalid JWT" (401) Error

**Cause**: Missing or incorrect Authorization header.

**Solution**:
1. Verify anon key is entered in Settings
2. Check anon key format: should be `sb_publishable_...` or `eyJ...` (JWT)
3. Ensure legacy API keys are enabled in Supabase dashboard

```php
// In class-supabase-api.php, ensure this line exists:
$headers['Authorization'] = 'Bearer ' . $anon_key;
```

### "Invalid Signature" Error

**Cause**: HMAC signature mismatch.

**Solution**:
1. Verify shared secret matches exactly in WordPress and Supabase
2. Check for whitespace in the secret
3. Redeploy edge functions after changing secret:

```bash
supabase functions deploy support-reply --project-ref your-project-id
```

### "Request Expired" Error

**Cause**: Server time difference > 5 minutes.

**Solution**:
1. Sync WordPress server time with NTP
2. Check Supabase edge function region

### Notifications Not Received

**Check**:
1. User has device token in `device_tokens` table
2. APNs secrets are set in Supabase
3. APNs environment matches build (sandbox/production)
4. Check `push_notification_log` for errors

```sql
SELECT * FROM push_notification_log
WHERE user_id = 'user-uuid'
ORDER BY created_at DESC LIMIT 10;
```

### Connection Test Fails

**Steps**:
1. Verify Edge Functions URL ends with `/functions/v1`
2. Check anon key is valid
3. Ensure edge functions are deployed
4. Check Supabase project is not paused

---

## Future Development

### Planned Features

#### 1. Rich Text Editor
Replace textarea with TinyMCE or similar for formatted replies.

#### 2. Ticket Assignment
Assign tickets to specific support agents:

```sql
ALTER TABLE support_tickets
ADD COLUMN assigned_to_agent_id UUID,
ADD COLUMN assigned_at TIMESTAMPTZ;
```

#### 3. Internal Notes
Add private notes visible only to support agents:

```sql
CREATE TABLE support_internal_notes (
    id UUID PRIMARY KEY,
    ticket_id UUID REFERENCES support_tickets(id),
    agent_id UUID NOT NULL,
    agent_name TEXT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMPTZ DEFAULT NOW()
);
```

#### 4. Email Notifications
Notify agents when new tickets arrive:

```php
// In edge function or via Supabase webhook
add_action('new_support_ticket', function($ticket) {
    wp_mail(
        get_option('admin_email'),
        "New Support Ticket: {$ticket['subject']}",
        "A new support ticket requires attention..."
    );
});
```

#### 5. Ticket Templates
Pre-defined templates for common issues:

```php
class SCS_Ticket_Templates {
    public static function get_templates() {
        return array(
            'password_reset' => array(
                'subject' => 'Password Reset Request',
                'initial_response' => 'To reset your password...',
                'auto_tags' => array('account', 'password')
            ),
            // ...
        );
    }
}
```

#### 6. Analytics Dashboard
Track ticket metrics:
- Average response time
- Tickets by topic/severity
- Resolution rate
- Agent performance

#### 7. Webhook Integration
Notify external systems (Slack, Discord, etc.) on ticket events:

```php
add_action('scs_ticket_created', function($ticket) {
    wp_remote_post('https://hooks.slack.com/...', array(
        'body' => json_encode(array(
            'text' => "New ticket: {$ticket['subject']}"
        ))
    ));
});
```

### Adding New Ticket Topics

1. **Add to Supabase enum**:
```sql
ALTER TYPE ticket_topic ADD VALUE 'new_topic';
```

2. **Update display mappings** in `ticket-detail-page.php`:
```php
$topic_labels = array(
    // ... existing
    'new_topic' => 'New Topic Label'
);
```

3. **Update iOS app** `TicketTopic` enum

### Adding New Status Types

1. **Add to Supabase enum**:
```sql
ALTER TYPE ticket_status ADD VALUE 'new_status';
```

2. **Update status dropdown** in admin pages

3. **Update trigger logic** if needed

4. **Update iOS app** `TicketStatus` enum

---

## File Structure

```
support-console-supabase/
├── support-console-supabase.php    # Main plugin file
├── includes/
│   ├── class-ajax-handlers.php     # AJAX endpoint handlers
│   ├── class-settings.php          # Settings management
│   ├── class-security.php          # HMAC signing, agent info
│   └── class-supabase-api.php      # API client
├── admin/
│   ├── tickets-page.php            # Ticket list UI
│   ├── ticket-detail-page.php      # Single ticket UI
│   └── settings-page.php           # Settings UI
├── assets/
│   ├── css/
│   │   └── admin-styles.css        # Admin styling
│   └── js/
│       └── admin-scripts.js        # Admin JavaScript
└── SUPPORT_CONSOLE_DOCUMENTATION.md # This file
```

---

## Related Documentation

- **iOS App**: See `NOTIFICATION_SYSTEM.md` in the Low Ox Life project
- **Supabase**: Edge functions in `supabase/functions/support-*/`
- **Database**: Migrations in `supabase/migrations/`

---

## Support

For issues with this plugin:
- Check the troubleshooting section above
- Review Supabase Edge Function logs
- Check WordPress error logs (`wp-content/debug.log`)

---

*Document Version: 1.0*
*Last Updated: 2026-01-06*
