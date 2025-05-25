# ltw-project-ltw07g03

## Features

**User:**

- [x] Register a new account.
- [x] Log in and out.
- [x] Edit their profile, including their name, username, password, email, and profile pictures.
- [x] View and manage account status (active/inactive).
- [x] Access real-time messaging system with conversation history and chat interface.

**Freelancers:**

- [x] List new services, providing details such as category, pricing, delivery time, and service description, along with images or videos.
- [x] Track and manage their offered services.
- [x] Edit and update existing services with new information, pricing, or media galleries.
- [x] Respond to inquiries from clients and provide custom offers through real-time messaging system.
- [x] Mark services as completed once delivered.

**Clients:**

- [x] Browse services using filters like category, price, and rating.
- [x] Engage with freelancers to ask questions or request custom orders.
- [x] Hire freelancers and proceed to checkout (simulate payment process).
- [x] Leave ratings and reviews for completed services.
- [x] Track purchase history and order status with detailed order management (pending/closed).
- [x] Leave ratings and reviews for completed services.

**Admins:**

- [x] Elevate a user to admin status.
- [x] Introduce new service categories.

**Security:**

- [x] Protect against SQL injection by using prepared statements with PDO.
- [x] Mitigate Cross-Site Scripting (XSS) attacks by sanitizing user input and output.
- [x] Prevent Cross-Site Request Forgery (CSRF) by implementing anti-CSRF tokens.
- [x] Implement secure password storage with proper hashing and salting techniques.

**Extra:**

- [x] API Integration: Develop a robust API to allow third-party applications to interact with the platform.
- [x] Real-time Messaging: Complete chat system with conversation history.

## Running

### Database Setup

The database is already included in this repository with sample data. However, if you need to recreate it from scratch, just run the following command:

```bash
sqlite3 database/database.db < database/create.sql && \
sqlite3 database/database.db < database/populate.sql
```

### Starting the Development Server

Start the PHP development server:

```bash
php -S localhost:9000
```

The website will be available at `http://localhost:9000`

## Credentials

All users in the sample database use the same password: `password123`

**Regular Users:**

- Username: `JohnDoe` / Password: `password123`
- Username: `MaryJoe` / Password: `password123`
- And so on...

**Administrator Account:**

- Username: `administrator` / Password: `password123`
