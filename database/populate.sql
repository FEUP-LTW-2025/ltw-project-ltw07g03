PRAGMA FOREIGN_KEYS = ON;

INSERT INTO User (name, username, email, password, isAdmin, profilePictureURL, status)
VALUES ('admin', 'administrator', 'admin@gmail.com', 'cbfdac6008f9cab4083784cbd1874f76618d2a97', 1,
        'https://picsum.photos/id/237/1024', 'active'),
       ('John Doe', 'JohnDoe', 'john@gmail.com', 'cbfdac6008f9cab4083784cbd1874f76618d2a97', 0,
        'https://picsum.photos/id/237/1024', 'active'),
       ('Mary Joe', 'MaryJoe', 'mary@gmail.com', 'cbfdac6008f9cab4083784cbd1874f76618d2a97', 0,
        'https://picsum.photos/id/237/1024', 'active'),
       ('Alice Wonder', 'AliceWonder', 'alice@gmail.com', 'cbfdac6008f9cab4083784cbd1874f76618d2a97', 0,
        'https://picsum.photos/id/101/1024', 'active'),
       ('Bob Smith', 'Bobby', 'bob@gmail.com', 'cbfdac6008f9cab4083784cbd1874f76618d2a97', 0,
        'https://picsum.photos/id/102/1024', 'inactive'),
       ('Charlie Brown', 'CharlieB', 'charlie@gmail.com', 'cbfdac6008f9cab4083784cbd1874f76618d2a97', 0,
        'https://picsum.photos/id/103/1024', 'active'),
       ('David Miller', 'DavidM', 'david@gmail.com', 'cbfdac6008f9cab4083784cbd1874f76618d2a97', 0,
        'https://picsum.photos/id/104/1024', 'active'),
       ('Eve Adams', 'EveA', 'eve@gmail.com', 'cbfdac6008f9cab4083784cbd1874f76618d2a97', 0,
        'https://picsum.photos/id/105/1024', 'active'),
       ('Frank White', 'FrankW', 'frank@gmail.com', 'cbfdac6008f9cab4083784cbd1874f76618d2a97', 0,
        'https://picsum.photos/id/106/1024', 'inactive'),
       ('Grace Hopper', 'GraceH', 'grace@gmail.com', 'cbfdac6008f9cab4083784cbd1874f76618d2a97', 0,
        'https://picsum.photos/id/107/1024', 'inactive');

INSERT INTO ServiceCategory (name)
VALUES ('Design'),
       ('Web Development'),
       ('Digital Marketing'),
       ('Writing & Translation'),
       ('Photography'),
       ('Video Editing');

INSERT INTO Service (freelancerId, categoryId, title, price, deliveryTime, description, status)
VALUES (2, 2, 'Dynamic webpages using PHP', 150, 2, 'Contact me!', 'active'),
       (4, 1, 'Logo Design', 50, 1, 'Professional logo design service', 'active'),
       (5, 3, 'SEO Optimization', 200, 3, 'Boost your search rankings', 'active'),
       (2, 4, 'Article Writing', 75, 2, 'Quality articles for your blog', 'active'),
       (6, 1, 'Illustration Design', 80, 3, 'Custom illustrations for your projects', 'active'),
       (7, 2, 'Responsive Web Design', 120, 2, 'Modern and responsive website design', 'active'),
       (8, 5, 'Portrait Photography', 200, 4, 'Professional portrait photography service', 'active'),
       (9, 6, 'Video Editing Service', 250, 5, 'High quality video editing for your content', 'active'),
       (10, 3, 'Social Media Marketing', 100, 1, 'Boost your online presence with targeted ads', 'active');

INSERT INTO ServiceMedia (serviceId, mediaURL)
VALUES (1, 'https://picsum.photos/id/237/1024'),
       (2, 'https://picsum.photos/id/238/1024'),
       (3, 'https://picsum.photos/id/239/1024'),
       (4, 'https://picsum.photos/id/240/1024'),
       (5, 'https://picsum.photos/id/241/1024'),
       (6, 'https://picsum.photos/id/242/1024'),
       (7, 'https://picsum.photos/id/243/1024'),
       (8, 'https://picsum.photos/id/244/1024'),
       (9, 'https://picsum.photos/id/245/1024');

INSERT INTO Purchase (serviceId, clientId, date, status)
VALUES (1, 3, '2025-03-31 12:34:56', 'pending'),
       (2, 5, '2025-03-31 13:00:00', 'closed'),
       (3, 3, '2025-03-31 13:30:00', 'pending'),
       (4, 4, '2025-03-31 14:00:00', 'closed'),
       (5, 4, '2025-04-01 10:00:00', 'pending'),
       (6, 3, '2025-04-01 10:15:00', 'closed'),
       (7, 8, '2025-04-01 10:30:00', 'pending'),
       (8, 2, '2025-04-01 10:45:00', 'closed'),
       (9, 7, '2025-04-01 11:00:00', 'pending'),
       (9, 6, '2025-04-01 11:15:00', 'closed');

INSERT INTO Message (senderId, receiverId, serviceId, content, date)
VALUES (3, 2, 1, 'Please give me a discount.', '2025-03-31 12:35:00'),
       (2, 3, 1, 'No.', '2025-03-31 12:35:30'),
       (5, 4, 2, 'I love your designs!', '2025-03-31 13:05:00'),
       (4, 5, 2, 'Thank you!', '2025-03-31 13:05:30'),
       (3, 5, 3, 'Can you optimize my site?', '2025-03-31 13:35:00'),
       (5, 3, 3, 'Sure, let’s discuss details.', '2025-03-31 13:35:30'),
       (4, 2, 4, 'Need an article on tech trends.', '2025-03-31 14:05:00'),
       (2, 4, 4, 'I can help.', '2025-03-31 14:05:30'),
       (4, 6, 5, 'Can you create a custom illustration?', '2025-04-01 10:05:00'),
       (6, 4, 5, 'Sure, I will send you the draft soon.', '2025-04-01 10:06:00'),
       (3, 7, 6, 'I need a website redesign.', '2025-04-01 10:20:00'),
       (7, 3, 6, 'I have some ideas; let me know your requirements.', '2025-04-01 10:22:00'),
       (8, 9, 7, 'Interested in your photography service.', '2025-04-01 10:35:00'),
       (9, 8, 7, 'I will schedule a session soon.', '2025-04-01 10:36:00'),
       (2, 10, 8, 'Looking for video editing, can you help?', '2025-04-01 10:50:00'),
       (10, 2, 8, 'Yes, I can edit your video professionally.', '2025-04-01 10:52:00'),
       (5, 7, 9, 'Do you offer social media marketing packages?', '2025-04-01 11:05:00'),
       (7, 5, 9, 'Yes, let me send you the details.', '2025-04-01 11:06:00');

INSERT INTO Feedback (purchaseId, rating, review, date)
VALUES (1, 2.1, 'Very good', '2025-03-31 12:40:00'),
       (2, 4.5, 'Excellent work', '2025-03-31 13:10:00'),
       (3, 3.0, 'Satisfactory', '2025-03-31 13:40:00'),
       (4, 4.0, 'Great job', '2025-03-31 14:10:00'),
       (5, 4.2, 'Very creative illustrations!', '2025-04-01 10:10:00'),
       (6, 3.8, 'Website design met my expectations.', '2025-04-01 10:25:00'),
       (7, 5.0, 'Amazing portrait photography!', '2025-04-01 10:40:00'),
       (8, 4.7, 'Video editing was top-notch.', '2025-04-01 10:55:00'),
       (9, 3.5, 'Social media marketing showed good results.', '2025-04-01 11:10:00'),
       (9, 4.0, 'Service was professional and prompt.', '2025-04-01 11:20:00');
