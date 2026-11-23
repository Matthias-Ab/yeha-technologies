# YEHA GROUP — Combined XAMPP Project
Extract to `C:\xampp\htdocs\YEHA-GROUP`. Start Apache/MySQL, import `database/yeha_group.sql` in phpMyAdmin, check `app/Config/database.php`, then visit `http://localhost/YEHA-GROUP/public/`.

Create the first admin at `/public/setup_admin.php`, then DELETE that file immediately.

Includes corporate pages, six sectors, service catalogue, customer registration/login, service request submission, technician application form, four role dashboard entry points, and a MySQL foundation for bookings, assignments, tracking, payments, commission, wallets, withdrawals, invoices, support, messages, notifications, corporate content and audit logs.

This is a development foundation, not a fully production-ready platform. Real Telebirr/CBE Birr/Amole payment APIs, payout processing, live GPS workflows, advanced CRUD screens, messaging delivery, file verification, production security testing and deployment still require implementation and provider credentials. No live payments are enabled. Uses native PHP 8+, MySQL, HTML, CSS and vanilla JS; Bootstrap 5 is a supporting CSS library.

## Admin dashboard (v2)
Import `database/002_admin_products.sql` after `yeha_group.sql`. Admin pages: `/public/admin/` (live statistics + activity log), `products.php` (create/edit/delete, validation, CSRF, audit log), `messages.php` (status updates). Not yet run against a live PHP/MySQL server by the author: test in XAMPP first.

## v4
Import `database/003_blog_images.sql`. Adds: admin quotations/blog pages, product image upload (JPG/PNG/WebP, 2 MB, random names, PHP blocked in uploads/), public blog and solutions pages, printable datasheet (`datasheet.php`), sitemap.php, robots.txt, theme toggle, quotation rate limit. Untested against a live server.

## v8 admin features
Admin > Service requests (approve/reject/assign technician), Applications (approve technician -> creates account with a one-time temporary password), Users (create accounts, set role, suspend, reset password), Categories, Projects (also shown on the public Projects page), Company info (shown in footer incl. WhatsApp link). No new SQL needed beyond 002 and 003.

## v9
Import `database/004_features.sql` (after 002 and 003). Adds: quotation replies with price (admin/staff), customer documents (private, stored in storage/documents, served by download.php with owner/admin/staff check), My profile + change password, admin Services manager, technician My jobs (accept/decline/on my way/arrived/start/complete), staff access to requests, quotations and messages. Suspended users and role changes now apply immediately.

## v10
Admin > Commission (default / per technician / per category rates), Payments (admin records received payments, commission is calculated and held pending, admin can edit the % of a pending commission or release it to the technician wallet). Requests page now shows assigned technicians. No new SQL. No online payment gateway or withdrawal flow.

## v11
Admin > Service requests now ranks technicians per request by skills match (their specialization vs service/category), availability (free / working now / busy / unavailable, set by the technician and derived from active jobs) and workload. Technicians set availability and skills on My jobs.
