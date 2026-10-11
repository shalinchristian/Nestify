# Nestify – restructure notes

Same pages, same features, same database schema (`database/nestify.sql` is byte-identical
to the old root `nestify.sql`). Old URLs such as `/User/Home.php` and `/Agent/AgentDashboard.php`
still work through the front router, so every existing link, form `action` and redirect is unchanged.

## Layout

```
config/
  bootstrap.php     path constants, .env loader, Composer autoload
  database.php      creates $conn (replaces the uncommitted Agent/db.php, User/db.php, User/fdb.php)
  mail.php          nestify_mailer(): one SMTP config for every email
app/
  Controllers/
    Agent/          form/AJAX handlers: Agent_Login, Agent_Signup, AddProperty, update_property,
                    delete_property, reply_message, send_chat_message, Otp_verify
    User/           Login, Signup, Otp_verify, resend_otp, verify_forgot_otp, add_to_cart,
                    add_to_favorites, remove_from_*, process_payment, send_message, send_chat,
                    fetch_messages, Feedback, Check_login
    Logout.php      shared logout for both roles (was two copies)
  Models/
    Database.php    db_query(): prepared-statement helper
  Views/
    agent/          agent pages (+ partials/Header.php)
    user/           user pages (+ partials/Header.php, partials/Footer.php)
    shared/         OtpPage.php (was identical in Agent/ and User/)
public/             web root
  index.php         front router
  .htaccess         Apache rewrite to index.php
  assets/agent/     Style.css, images/
  assets/user/      Style.css, images/
  assets/shared/    AP.css, AP.js (were identical copies)
  uploads/          property photos uploaded at runtime (git-ignored, .gitkeep only)
database/nestify.sql
composer.json       phpmailer/phpmailer ^6.9 (replaces the two vendored PHPMailer folders)
.env.example
```

## How routing works
`/{Agent|User}/<file>.php` is resolved, case-insensitively, against
`app/Controllers/<Role>/`, then `app/Views/<role>/`, then `app/Views/shared/`, then `app/Controllers/`.
Other files under `/{Agent|User}/` (CSS, JS, images) come from `public/assets/<role>/` or `public/assets/shared/`.
`/uploads/*` is served straight from `public/uploads/`. `/` redirects to `/User/Home.php`.
Case-insensitive lookup matters because the old code mixes `header.php`/`Header.php` and `style.css`/`Style.css`,
which only worked on Windows.

## Setup
```
composer install
cp .env.example .env            # fill DB_* and EMAIL_USER / EMAIL_PASS (Gmail app password)
mysql -u root -e "CREATE DATABASE nestify"
mysql -u root nestify < database/nestify.sql
php -S localhost:8000 -t public public/index.php      # or point Apache's DocumentRoot at public/
```
On Linux, MySQL/MariaDB needs `lower_case_table_names=1`, because the code queries both
`Users` and `users`, and both `Properties` and `properties`. XAMPP on Windows already behaves this way.

## Code changes
- Every query that built SQL by string interpolation now uses prepared statements: dashboards,
  cart/favorites, chats, messages, payments, property detail, and the agent reply/update queries.
  The Home/Properties search filters bind their location/bedrooms/price parameters.
- `reply_message.php` no longer calls `mysqli_real_escape_string`, since binding the value makes it unnecessary.
- SMTP settings live in `config/mail.php`, read from `.env`. `forget_password.php` used the placeholder
  `smtp.example.com` / `your-email@example.com` and now sends through the same config as signup.
- `session_start()` is now guarded with `session_status()`, which removes the "session already active" notices
  that appeared when pages included the header.
- Uploads: `AddProperty` and `update_property` both write to `public/uploads/`. Before, `update_property` saved into
  `Agent/uploads/`, where the pages never looked. That is where the stray `Agent/uploadsproperty_*.jpeg` files came from.
- The dashboards' "Forgot Password?" button links to `forgot_password.php`, which never existed, so the router aliases it to `forget_password.php`.

## Removed from the tree
- `Agent/PHPMailer/` and `User/PHPMailer/` (Composer installs PHPMailer now)
- the root `uploads/*.jpeg`, `Agent/uploads/`, `Agent/uploads*_property_*.jpeg`, and the uploaded `property_*` photos in `Agent/images/`
- `Agent/Logout.php`, `User/Logout.php` and `User/OtpPage.php`, merged into the shared versions

## Known issues carried over unchanged (schema kept identical on purpose)
- `payments` has no PRIMARY KEY or AUTO_INCREMENT in the dump, so any insert into it fails ("Field 'id' doesn't have a default value"),
  and payment checkout has never worked against this dump. Fix: `ALTER TABLE payments ADD PRIMARY KEY (id), MODIFY id INT NOT NULL AUTO_INCREMENT;`
- `dealers.verified` is an int, but the agent OTP code compares and writes `'Verified'`.
- `User/Otp_verify.php` redirects to `SignupPage.php` and `AuthentificationPage.php`, neither of which exists.
- `nestify.sql` contains real-looking user emails and password hashes. Consider scrubbing it before publishing.
