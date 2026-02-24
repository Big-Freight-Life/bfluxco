# Deployment Guide

## Pipeline

```
Local Edit → Git Push → WP Pusher → LiteSpeed Cache Purge
```

### 1. Local Development

- Working directory: `/Users/raybutler/development/bfluxco-master`
- This is a WordPress theme (`bfluxco`)

### 2. Git

- Remote: `https://github.com/Big-Freight-Life/bfluxco.git`
- Branch: `master`
- Push with: `git push origin master`

### 3. WP Pusher (Live Server)

WP Pusher is installed on bflux.co and configured to track `Big-Freight-Life/bfluxco` on the `master` branch.

- **Push-to-Deploy**: Enabled, but may not trigger automatically on every push
- **Manual update**: WP Admin > WP Pusher > Themes > "Update theme" button
- **Webhook URL**: Available under "Show Push-to-Deploy URL" on the themes page
- **License**: No paid license is active (free tier)

### 4. Cache

The site uses **LiteSpeed Cache**. After deploying, purge the cache:

- WP Admin toolbar > LiteSpeed Cache > **Purge All**

This ensures visitors see the latest changes immediately.

## Troubleshooting

- **Changes not showing after push**: Click "Update theme" manually in WP Pusher
- **Still not showing after update**: Purge LiteSpeed Cache (Purge All)
- **WP Pusher spinner stuck**: Refresh the page and try again — the first attempt sometimes times out
