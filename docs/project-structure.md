# Care-Hope: Recommended Project Structure

This structure keeps shared PHP code, public pages, styles, scripts, uploads,
and database files clearly separated. It is intentionally beginner-friendly
while allowing the project to grow.

```text
Care-Hope/
├── assets/
│   ├── css/
│   │   ├── style.css                 # Shared responsive site styles
│   │   ├── auth.css                  # Login and signup page styles
│   │   ├── dashboard.css             # Patient/admin dashboard styles
│   │   └── responsive.css            # Optional focused media-query overrides
│   ├── js/
│   │   ├── main.js                   # Navigation and shared UI behavior
│   │   ├── validation.js             # Client-side form validation helpers
│   │   ├── appointment.js            # Appointment form interactions
│   │   └── dashboard.js              # Dashboard interactions
│   └── images/
│       ├── logo.svg
│       ├── doctors/
│       └── site/
├── config/
│   └── database.php                  # PDO connection settings (not committed with secrets)
├── database/
│   └── schema.sql                    # Database, tables, indexes, starter admin
├── docs/
│   └── project-structure.md
├── includes/
│   ├── auth.php                      # Session, role, and login guards
│   ├── csrf.php                      # CSRF token creation and verification
│   ├── functions.php                 # Validation and output-escaping helpers
│   ├── header.php                    # Shared page head and navigation
│   ├── footer.php                    # Shared footer and script includes
│   └── flash.php                     # One-time success/error messages
├── uploads/
│   └── doctors/                      # Doctor profile photos; protect execution here
├── admin/
│   ├── login.php
│   ├── dashboard.php
│   ├── doctors.php                   # Create, edit, remove doctors
│   ├── patients.php                  # View/manage patient records
│   └── appointments.php              # View/update appointment status
├── patient/
│   ├── dashboard.php
│   └── appointments.php
├── index.php                         # Home page
├── about.php
├── doctors.php                       # Doctor directory
├── doctor-profile.php                # Individual doctor profile (?id=)
├── book-appointment.php
├── signup.php
├── login.php
├── logout.php
├── contact.php
├── .gitignore
├── README.md
└── LICENSE
```

## Page and navigation map

### Public pages

| Page | File | Primary links/actions |
| --- | --- | --- |
| Home | `index.php` | About, doctors, booking, signup, login, contact |
| About | `about.php` | Doctors, contact, booking |
| Doctors | `doctors.php` | Individual doctor profile, booking |
| Doctor profile | `doctor-profile.php` | Booking for the selected doctor |
| Appointment booking | `book-appointment.php` | Patient login when needed; confirmation after submit |
| Patient signup | `signup.php` | Patient login after registration |
| Patient login | `login.php` | Patient dashboard; admin login |
| Contact | `contact.php` | Home and contact submission confirmation |

### Protected pages

| User | Page | File | Access rule |
| --- | --- | --- | --- |
| Patient | Dashboard | `patient/dashboard.php` | Signed-in patient only |
| Patient | My appointments | `patient/appointments.php` | Signed-in patient only |
| Admin | Login | `admin/login.php` | Redirect signed-in admins to dashboard |
| Admin | Dashboard | `admin/dashboard.php` | Signed-in administrator only |
| Admin | Manage doctors | `admin/doctors.php` | Signed-in administrator only |
| Admin | Manage patients | `admin/patients.php` | Signed-in administrator only |
| Admin | Manage appointments | `admin/appointments.php` | Signed-in administrator only |

## Implementation sequence

1. **Foundation:** add shared configuration, PDO connection, helpers, base CSS,
   JavaScript, header/footer, and responsive navigation.
2. **Public experience:** implement Home, About, Contact, Doctors directory,
   and Doctor profile pages with a consistent medical design.
3. **Patient accounts:** add secure signup, login, logout, sessions, password
   hashing, validation, and patient dashboard.
4. **Appointments:** implement booking, availability checks, My Appointments,
   and appointment status updates.
5. **Administration:** build the admin login, dashboard, and doctor, patient,
   and appointment management screens.
6. **Quality pass:** verify mobile/tablet/desktop layouts, authorization,
   validation, error states, and database constraints.

## Security rules for the implementation

- Use PDO with emulation disabled and parameterized statements for every query.
- Store all passwords with `password_hash()` and authenticate with
  `password_verify()`.
- Validate all submitted values on the server; JavaScript validation only
  improves user experience and is not a security boundary.
- Escape rendered dynamic text using `htmlspecialchars()`.
- Require a valid CSRF token for every state-changing form.
- Regenerate the session ID after successful login and enforce role checks on
  every protected route.
- Keep real database credentials in an ignored local configuration file or
  environment variables, never in version control.
