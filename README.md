# ltw-project-ltw07g03

## Features

**User:**

- [x] Register a new account.
- [x] Log in and out.
- [x] Edit their profile, including their name, username, password, and email.

**Freelancers:**

- [x] List new services, providing details such as category, pricing, delivery time, and service description, along with images or videos.
- [x] Track and manage their offered services.
- [x] Respond to inquiries from clients regarding their services and provide custom offers if needed.
- [x] Mark services as completed once delivered.

**Clients:**

- [x] Browse services using filters like category, price, and rating.
- [x] Engage with freelancers to ask questions or request custom orders.
- [x] Hire freelancers and proceed to checkout (simulate payment process).
- [x] Leave ratings and reviews for completed services.

**Admins:**

- [x] Elevate a user to admin status.
- [x] Introduce new service categories and other pertinent entities.
- [x] Oversee and ensure the smooth operation of the entire system.

**Security:**

- [x] Protect against SQL injection by using prepared statements with PDO.
- [x] Mitigate Cross-Site Scripting (XSS) attacks by sanitizing user input and output.
- [x] Prevent Cross-Site Request Forgery (CSRF) by implementing anti-CSRF tokens.
- [x] Implement secure password storage with proper hashing and salting techniques.

**Extra:**

- [x] API Integration: Develop a robust API to allow third-party applications to interact with the platform.

## Running

    sqlite3 database/database.db < database/database.sql
    php -S localhost:9000

## Credentials

- administrator/password123
- JohnDoe/password123
