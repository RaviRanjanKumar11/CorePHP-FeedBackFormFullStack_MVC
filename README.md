# PHP Feedback Submission System (Core PHP, MVC)
A minimal feedback app following MVC principles. Users can submit feedback; an admin can log in and approve/reject. Approved feedback is publicly visible.

## Tech & Versions
- PHP: 8.1+ recommended
- MySQL: 8.x (MariaDB works too)
- Web server: Apache with mod_rewrite
- Frontend: Vanilla JS (inline validation)

## Structure
(see repository tree)

## Setup
1) Import `sql/schema.sql` into MySQL and create an admin:
- Generate a password hash in PHP:
```php
<?php echo password('admin123', PASSWORD_DEFAULT);
```
- Insert:
```sql
INSERT INTO admins (username, password) VALUES ('admin', '<paste_hash_here>');
```

2) Edit `config/config.php` for DB creds and `base_url`.

3) Point your web server to `public/`. For PHP built-in server:
```bash
cd public
php -S localhost:8000
```

Visit:
- /feedback/form — submit feedback
- /feedback/approved — see approved list
- /admin/login — admin area

## Validation Rules
- Full Name: required, min 3, letters & spaces only
- Email: required, valid, unique in `feedbacks`
- Rating: required, 1–5
- Message: required, max 250, letters/numbers/spaces/punctuation

## Notes
- All submissions are `pending` by default.
- Admin dashboard shows all feedback with Approve/Reject actions (CSRF-protected).
- MVC: controllers call models; views render HTML; a simple front controller routes requests.

## License
MIT
"# CorePHP-FeedBackFormFullStack_MVC" 
