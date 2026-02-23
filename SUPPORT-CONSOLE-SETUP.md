# Support Console (Supabase) - Complete Setup Guide

A WordPress wp-admin plugin for managing in-app support tickets stored in Supabase. This console allows support agents to view, reply to, and manage support tickets from your mobile app users.

## Architecture Overview

```
WordPress (PHP) ──HMAC-signed requests──> Supabase Edge Functions ──> Supabase DB/Storage
```

- **WordPress** stores only the Edge Functions URL and shared secret
- **All data** lives in Supabase (tickets, messages, attachments)
- **HMAC-SHA256** signing prevents unauthorized API access
- **No Supabase keys** are exposed to the browser

---

## Prerequisites

- Supabase project with Edge Functions enabled
- WordPress 5.0+ installation
- PHP 7.4+
- Supabase CLI installed (`npm install -g supabase`)

---

## Part 1: Supabase Setup

### Step 1: Run Database Migration

Copy the migration file to your Supabase project:

```
supabase/migrations/20260105000001_create_support_system.sql
```

Then apply it:

```bash
cd /path/to/your/supabase/project
supabase db push
```

**What this creates:**
- `support_tickets` - Main tickets table
- `support_messages` - Conversation thread
- `support_attachments` - File metadata
- Row Level Security policies
- Triggers for `updated_at` and `last_message_at`

### Step 2: Create Storage Bucket

Run this SQL in the Supabase SQL Editor:

```sql
INSERT INTO storage.buckets (id, name, public, file_size_limit, allowed_mime_types)
VALUES (
    'support-attachments',
    'support-attachments',
    false,
    10485760, -- 10MB max file size
    ARRAY['image/png', 'image/jpeg', 'image/gif', 'image/webp',
          'application/pdf', 'text/plain', 'text/csv']
) ON CONFLICT (id) DO NOTHING;
```

### Step 3: Deploy Edge Functions

Copy the Edge Functions to your Supabase project:

```
supabase/functions/_shared/support-auth.ts
supabase/functions/support-list-tickets/index.ts
supabase/functions/support-get-ticket/index.ts
supabase/functions/support-reply/index.ts
supabase/functions/support-update-status/index.ts
supabase/functions/support-upload-attachment/index.ts
supabase/functions/support-get-signed-url/index.ts
```

Deploy all functions:

```bash
supabase functions deploy support-list-tickets
supabase functions deploy support-get-ticket
supabase functions deploy support-reply
supabase functions deploy support-update-status
supabase functions deploy support-upload-attachment
supabase functions deploy support-get-signed-url
```

### Step 4: Set Shared Secret

Generate a secure 32-character secret and set it:

```bash
# Generate a secret (example)
openssl rand -base64 32

# Set it in Supabase
supabase secrets set WP_SHARED_SECRET="your-generated-secret-here"
```

**IMPORTANT:** Save this secret! You'll need the exact same value for WordPress.

---

## Part 2: WordPress Setup

### Step 1: Install the Plugin

Copy the plugin folder to your WordPress installation:

```bash
cp -r wordpress-plugins/support-console-supabase /path/to/wordpress/wp-content/plugins/
```

Or manually upload via SFTP/FTP:
- Upload the entire `support-console-supabase` folder to `wp-content/plugins/`

### Step 2: Activate the Plugin

1. Go to WordPress Admin → Plugins
2. Find "Support Console (Supabase)"
3. Click "Activate"

This will:
- Create the `support_agent` role
- Add `support_console_access` capability to administrators
- Initialize default settings

### Step 3: Configure Connection

1. Go to **Support Console → Settings** (left sidebar)
2. Enter your settings:

| Setting | Value |
|---------|-------|
| **Edge Functions URL** | `https://YOUR-PROJECT-ID.supabase.co/functions/v1` |
| **Shared Secret** | The same secret you set in Supabase |
| **Tickets Per Page** | 10-100 (default: 20) |

3. Click **Save Settings**
4. Click **Test Connection** to verify

### Step 4: Grant User Access (Optional)

By default, only Administrators can access the Support Console. To grant access to other users:

1. Go to **Users → All Users**
2. Edit the user you want to grant access
3. Change their role to **Support Agent**

Or add the `support_console_access` capability to an existing role using a plugin like "User Role Editor".

---

## Part 3: Testing

### Create a Test Ticket

Run this SQL in Supabase to create a test ticket:

```sql
-- Replace 'USER-UUID-HERE' with an actual user ID from auth.users
INSERT INTO support_tickets (user_id, title, description, topic, severity)
VALUES (
    'USER-UUID-HERE',
    'Test Support Ticket',
    'This is a test ticket to verify the support console is working.',
    'general',
    'medium'
);

-- Add a test message
INSERT INTO support_messages (ticket_id, author_type, author_id, author_name, content)
SELECT
    id,
    'user',
    user_id,
    'Test User',
    'Hello, I need help with something.'
FROM support_tickets
WHERE title = 'Test Support Ticket'
LIMIT 1;
```

### Verify in WordPress

1. Go to **Support Console → Tickets**
2. You should see the test ticket
3. Click on it to view details
4. Try sending a reply
5. Change the status

---

## Features

### Tickets List Page
- Filter by status, topic, severity
- Search by title
- Sort by any column
- Pagination
- Click row to view details

### Ticket Detail Page
- View full conversation thread
- Collapsible diagnostics panel (device info, app version, etc.)
- Status dropdown (auto-saves)
- Reply with canned responses
- File attachments (images, PDFs, text files)
- Keyboard shortcut: Ctrl+Enter to send

### Settings Page (Admin only)
- Configure Supabase connection
- Test connection
- Set page size
- Manage canned replies

### Security Features
- HMAC-SHA256 signed requests
- WordPress nonce verification
- Capability-based access control
- Rate limiting (100 req/min per user)
- Input sanitization
- UUID validation

---

## File Structure

```
support-console-supabase/
├── support-console-supabase.php      # Plugin bootstrap
├── includes/
│   ├── class-security.php            # Nonces, capabilities, rate limiting
│   ├── class-supabase-api.php        # HMAC signing, API requests
│   ├── class-settings.php            # Settings management
│   └── class-ajax-handlers.php       # 6 AJAX endpoints
├── admin/
│   ├── tickets-page.php              # Tickets list view
│   ├── ticket-detail-page.php        # Single ticket view
│   ├── settings-page.php             # Settings form
│   ├── js/
│   │   ├── admin-common.js           # Shared utilities
│   │   ├── tickets-list.js           # List functionality
│   │   └── ticket-detail.js          # Detail + reply
│   └── css/
│       └── admin.css                 # Admin styling
└── readme.txt
```

---

## Ticket Statuses

| Status | Color | Description |
|--------|-------|-------------|
| `open` | Red | New ticket, needs attention |
| `needs_info` | Yellow | Waiting for user response |
| `in_progress` | Blue | Agent is working on it |
| `resolved` | Green | Issue resolved |
| `closed` | Gray | Ticket archived |

---

## Topics

| Topic | Description |
|-------|-------------|
| `general` | General questions |
| `technical` | Technical issues, bugs |
| `billing` | Payment, subscription |
| `feature` | Feature requests |
| `bug` | Bug reports |

---

## Severity Levels

| Severity | Description |
|----------|-------------|
| `low` | Minor issue, no rush |
| `medium` | Normal priority |
| `high` | Important, needs quick attention |
| `critical` | Urgent, blocking issue |

---

## API Reference

### Edge Functions

| Function | Method | Description |
|----------|--------|-------------|
| `support-list-tickets` | POST | List tickets with filters/pagination |
| `support-get-ticket` | POST | Get ticket with messages & attachments |
| `support-reply` | POST | Create agent reply |
| `support-update-status` | POST | Update ticket status |
| `support-upload-attachment` | POST | Upload file attachment |
| `support-get-signed-url` | POST | Refresh expired attachment URL |

### Request Signing

All requests include these headers:
```
x-wp-timestamp: Unix timestamp (seconds)
x-wp-nonce: UUID for replay protection
x-wp-signature: HMAC-SHA256(secret, "timestamp.nonce.path.body")
x-wp-agent-id: WordPress user ID
x-wp-agent-name: Agent display name
```

---

## Troubleshooting

### "Connection failed" error
- Verify the Edge Functions URL is correct (no trailing slash)
- Ensure the shared secret matches exactly in both places
- Check that Edge Functions are deployed: `supabase functions list`

### "Unauthorized" error
- The shared secret doesn't match
- Request timestamp is more than 5 minutes old (server time sync issue)

### Tickets not loading
- Check browser console for errors
- Verify RLS policies are correct
- Check Supabase Edge Function logs: `supabase functions logs support-list-tickets`

### File uploads failing
- Verify storage bucket exists: `support-attachments`
- Check file size (max 10MB)
- Verify file type is allowed

### User can't access console
- User needs `support_console_access` capability
- Assign "Support Agent" role or add capability manually

---

## Canned Replies

Default canned replies are created on activation. You can customize them in Settings:

1. **Greeting** - Welcome message
2. **Need More Info** - Request for details
3. **Issue Resolved** - Closing message
4. **Feature Request Noted** - Acknowledgment
5. **Technical Investigation** - Working on it

---

## Database Schema

### support_tickets
```sql
id              UUID PRIMARY KEY
user_id         UUID NOT NULL (FK → auth.users)
title           TEXT NOT NULL
description     TEXT
status          TEXT ('open', 'needs_info', 'in_progress', 'resolved', 'closed')
topic           TEXT ('general', 'technical', 'billing', 'feature', 'bug')
severity        TEXT ('low', 'medium', 'high', 'critical')
diagnostics     JSONB
created_at      TIMESTAMPTZ
updated_at      TIMESTAMPTZ
resolved_at     TIMESTAMPTZ
last_message_at TIMESTAMPTZ
last_message_preview TEXT
```

### support_messages
```sql
id              UUID PRIMARY KEY
ticket_id       UUID NOT NULL (FK → support_tickets)
author_type     TEXT ('user', 'support_agent')
author_id       UUID NOT NULL
author_name     TEXT
content         TEXT NOT NULL
created_at      TIMESTAMPTZ
```

### support_attachments
```sql
id              UUID PRIMARY KEY
ticket_id       UUID NOT NULL (FK → support_tickets)
message_id      UUID (FK → support_messages)
file_name       TEXT NOT NULL
file_type       TEXT NOT NULL
file_size       INTEGER NOT NULL
storage_path    TEXT NOT NULL
uploaded_by_type TEXT ('user', 'support_agent')
uploaded_by_id  UUID NOT NULL
created_at      TIMESTAMPTZ
```

---

## Security Considerations

1. **Never share the shared secret** - It's the only thing protecting your API
2. **Use HTTPS** - Both WordPress and Supabase should use HTTPS
3. **Rotate secrets periodically** - Update both places simultaneously
4. **Monitor Edge Function logs** - Watch for suspicious activity
5. **Rate limiting** - Built-in 100 req/min per user

---

## Future Enhancements (Not Implemented)

- [ ] Email notifications to agents on new tickets
- [ ] Email notifications to users on agent replies
- [ ] Ticket assignment to specific agents
- [ ] Internal notes (agent-only messages)
- [ ] Ticket merging
- [ ] Analytics dashboard
- [ ] iOS app integration for ticket creation

---

## Support

For issues with this plugin, contact the development team or check the project documentation.

**Plugin Version:** 1.0.0
**Last Updated:** January 2026
