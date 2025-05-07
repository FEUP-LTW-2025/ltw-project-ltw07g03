PRAGMA FOREIGN_KEYS = ON;

INSERT INTO User (name, username, email, password, isAdmin, profilePictureURL, status)
VALUES ('admin', 'administrator', 'admin@gmail.com', '$2y$10$5sl/h1piBAoz7vWJBdebhetb2hRwzg0MuOrgHASyvcbFN0f/OSxRG', 1,
        'https://picsum.photos/id/98/1024', 'active'),
       ('John Doe', 'JohnDoe', 'john@gmail.com', '$2y$10$5sl/h1piBAoz7vWJBdebhetb2hRwzg0MuOrgHASyvcbFN0f/OSxRG', 0,
        'https://picsum.photos/id/99/1024', 'active'),
       ('Mary Joe', 'MaryJoe', 'mary@gmail.com', '$2y$10$5sl/h1piBAoz7vWJBdebhetb2hRwzg0MuOrgHASyvcbFN0f/OSxRG', 0,
        'https://picsum.photos/id/100/1024', 'active'),
       ('Alice Wonder', 'AliceWonder', 'alice@gmail.com',
        '$2y$10$5sl/h1piBAoz7vWJBdebhetb2hRwzg0MuOrgHASyvcbFN0f/OSxRG', 0,
        'https://picsum.photos/id/101/1024', 'active'),
       ('Bob Smith', 'Bobby', 'bob@gmail.com', '$2y$10$5sl/h1piBAoz7vWJBdebhetb2hRwzg0MuOrgHASyvcbFN0f/OSxRG', 0,
        'https://picsum.photos/id/102/1024', 'inactive'),
       ('Charlie Brown', 'CharlieB', 'charlie@gmail.com',
        '$2y$10$5sl/h1piBAoz7vWJBdebhetb2hRwzg0MuOrgHASyvcbFN0f/OSxRG', 0,
        'https://picsum.photos/id/103/1024', 'active'),
       ('David Miller', 'DavidM', 'david@gmail.com', '$2y$10$5sl/h1piBAoz7vWJBdebhetb2hRwzg0MuOrgHASyvcbFN0f/OSxRG', 0,
        'https://picsum.photos/id/104/1024', 'active'),
       ('Eve Adams', 'EveA', 'eve@gmail.com', '$2y$10$5sl/h1piBAoz7vWJBdebhetb2hRwzg0MuOrgHASyvcbFN0f/OSxRG', 0,
        'https://picsum.photos/id/106/1024', 'active'),
       ('Frank White', 'FrankW', 'frank@gmail.com', '$2y$10$5sl/h1piBAoz7vWJBdebhetb2hRwzg0MuOrgHASyvcbFN0f/OSxRG', 0,
        'https://picsum.photos/id/107/1024', 'inactive'),
       ('Grace Hopper', 'GraceH', 'grace@gmail.com', '$2y$10$5sl/h1piBAoz7vWJBdebhetb2hRwzg0MuOrgHASyvcbFN0f/OSxRG', 0,
        'https://picsum.photos/id/108/1024', 'inactive');

INSERT INTO ServiceCategory (name, icon)
VALUES ('Programming & Tech', '🖥️'),
       ('Graphics and Design', '🎨'),
       ('Digital Marketing', '📈'),
       ('Video & Animation', '🎬'),
       ('Music & Audio', '🎧'),
       ('Business', '💼');

INSERT INTO Service (freelancerId, categoryId, title, price, deliveryTime, description, status)
VALUES (2, 1, 'Dynamic Webpages with PHP', 150, 2, 'I will build dynamic PHP-based websites tailored to your needs.',
        'active'),
       (4, 2, 'Logo Design', 50, 1, 'Unique and professional logo designs delivered fast.', 'active'),
       (5, 3, 'SEO Optimization', 200, 3, 'Increase your visibility on search engines with my SEO services.', 'active'),
       (2, 6, 'Article Writing', 75, 2, 'High-quality blog or website articles written just for you.', 'active'),
       (6, 2, 'Illustration Design', 80, 3, 'Beautiful hand-drawn or digital illustrations for any project.', 'active'),
       (7, 1, 'Responsive Web Design', 120, 2, 'Clean and modern web design that works on any device.', 'active'),
       (8, 4, 'Portrait Photography', 200, 4, 'Studio-quality portrait photography at your convenience.', 'active'),
       (9, 4, 'Video Editing Service', 250, 5, 'Professional editing with transitions, effects, and audio sync.',
        'active'),
       (10, 6, 'Social Media Marketing', 100, 1, 'Grow your audience with strategic ad campaigns.', 'active'),
       (1, 5, 'Podcast Editing', 180, 3, 'Clean, edit, and mix your podcast for publishing.', 'active'),
       (2, 5, 'Voice Over in English', 90, 2, 'Professional male voice over for your video or ad.', 'active'),
       (3, 1, 'Full Stack Development', 300, 5, 'Complete web app built with React and Node.js.', 'active'),
       (4, 2, 'Business Card Design', 45, 1, 'Custom business card with print-ready files.', 'active'),
       (5, 3, 'Email Marketing Campaigns', 130, 2, 'Reach your clients with beautiful emails and strategy.', 'active');

UPDATE Service
SET about =
        'If you are looking for someone to build a custom dynamic PHP website with critical functionality and responsive design to support your business operations effectively, you are in the right place. I ensure that the final product is secure, easy to use, and scalable.

        What you''ll get:

        • Responsive and attractive frontend.
        • Fully dynamic and custom CMS backend.
        • No 3rd party frameworks.
        • Unlimited Revision.
        • Anytime customer support.
        • Quality and Security ensured.
        • 1 month free maintenance support (After delivery).'
WHERE serviceId = 1;

UPDATE Service
SET about =
        'Need a unique and professional logo? I offer minimalist logo design that helps you stand out. Modern, clean and tailored to your brand identity.

        What you''ll get:

        • Reliable and Quick communication.
        • Printable and HQ File size.
        • High-resolution files.
        • Multiple design concepts.
        • Fast delivery.
        • Minimalist Logo and Flat Logo Expert.'
WHERE serviceId = 2;

UPDATE Service
SET about =
        'Boost your search engine rankings with optimized content, improved metadata, and strategic keyword use. I will help you grow your online presence.

        What you''ll get:

        • Fixing 404 Errors and Dead Links.
        • Website Progressive Deeply Analysis.
        • Perfecting Keyword Research and Targeting.
        • Meta Tags Optimization with profitable keywords and Brand.
        • Keywords Density Optimization.
        • Performance Reports.'
WHERE serviceId = 3;


UPDATE Service
SET about =
        'Need high quality articles tailored to your audiance? I provide original content that is well-researched, engaging, and optimized for SEO.

        What you''ll get:

        • Internal and external links.
        • Original, plagiarism-free content.
        • Topic search.
        • SEO best practices.
        • Revisions included.'
WHERE serviceId = 4;


UPDATE Service
SET about =
        'Custom illustrations for your brand, book, or campaign. I offer vibrant, detailed visuals that match your vision and style.

        What you''ll get:

        • Unique Hand drawing illustration.
        • Awesome Illustration and professional work.
        • Source File on .ai, .eps, .pdf, .psd.
        • SEO best practices.
        • Get full ownership of the artwork.
        • Personal and commercial Use'
WHERE serviceId = 5;

UPDATE Service
SET about =
        'I will design a moder, responsive website that looks great on all devices. Clean code and attention to UX/UI garanteed.

        What you''ll get:

        • WordPress Installation and Setup.
        • E-commerce Functionality.
        • SEO, Speed, Security Optimization.
        • Complete Control panel.
        • Fully Responsive (Mobile+Tablet+Desktop).
        • Redesign Existing Site.'
WHERE serviceId = 6;

UPDATE Service
SET about =
        'Capture your best self with professional portrait photography. Ideal for business profiles, personal branding, or creative use.

        What you''ll get:

        • High-resolution images.
        • Editing and retouching.
        • Flexible packages.
        • Fast delivery.
        • Studio or on-location shoots.'
WHERE serviceId = 7;

UPDATE Service
SET about =
        'Transform your raw footage into professional content with effect, transitions, music, and more. Perfect for Youtube, events, and adds.

        What you''ll get:

        • Sync with audio/music.
        • Professional Editing.
        • Custom Transitions & Effects.
        • Attention to Detail.
        • Color correction and grading.
        • Fast Turnaround.'
WHERE serviceId = 8;


UPDATE Service
SET about =
        'I will help you grow your business through targeted social media marketing, ads, and strategic content planning.

        What you''ll get:

        • Scheduled Posts tailored to your audience.
        • Help with creating and managing ad campaigns.
        • Creation and Optimization of your Social Media Profiles.
        • Branded posts designed to promote your project and create leads.
        • Hashtag-Optimized Text+Image Posts created by a Content Writer.'
WHERE serviceId = 9;

UPDATE Service
SET about =
        'Polish your podcast  with professional editing, noise reduction, and mastering. Your voice, clearer and cleaner than ever.

        What you''ll get:

        • Professional editing & color grading.
        • Custom graphics & motion elements.
        • Clean, noise-free sound.
        • Smart content editing.
        • Engaging teaser/hook.
        • Professional mixing & mastering.'
WHERE serviceId = 10;

UPDATE Service
SET about =
        'Need a voice for your project? I will deliver clear, professional audio recordings for videos, ads and more.

        What you''ll get:

        • Commercial rights.
        • Different tones/styles available.
        • Fast delivery.
        • High-quality WAV/MP3.
        • Multiple revisions.'
WHERE serviceId = 11;

UPDATE Service
SET about =
        'End-to-end development of web applications using the latest tech stack. I build scalable, secure, and well-documented systems.

        What you''ll get:

        • Front-end and back-end development.
        • Complex Problem Solving.
        • Custom Web Applications.
        • Data Security & Performance Optimization.
        • RESTful APIs: Development & seamless integration.
        • Database integration.'
WHERE serviceId = 12;

UPDATE Service
SET about =
        'I will create a sleek, printable business card that captures your brand identity and makes a lasting impression.

        What you''ll get:

        • High-quality business card and logo.
        • Compliment Slip.
        • Source File.
        • Vertical and horizontal design.
        • Free QR Code (If you need).
        • Envelop design.'
WHERE serviceId = 13;

UPDATE Service
SET about =
        'Launch successful email marketing campaigns with custom designs and proven strategy to engage your audiance and increase conversions.

        What you''ll get:

        • Custom HTML email template.
        • A/B testing strategy.
        • Analytics and reporting.
        • Responsive design.
        • Mailchimp or platform setup.'
WHERE serviceId = 14;

INSERT INTO ServiceMedia (serviceId, mediaURL)
VALUES (1, 'https://picsum.photos/id/1011/1024'),
       (2, 'https://picsum.photos/id/1012/1024'),
       (3, 'https://picsum.photos/id/1013/1024'),
       (4, 'https://picsum.photos/id/1014/1024'),
       (5, 'https://picsum.photos/id/1015/1024'),
       (6, 'https://picsum.photos/id/1016/1024'),
       (7, 'https://picsum.photos/id/1025/1024'),
       (8, 'https://picsum.photos/id/1018/1024'),
       (9, 'https://picsum.photos/id/1019/1024'),
       (10, 'https://picsum.photos/id/1020/1024'),
       (11, 'https://picsum.photos/id/1021/1024'),
       (12, 'https://picsum.photos/id/1022/1024'),
       (13, 'https://picsum.photos/id/1023/1024'),
       (14, 'https://picsum.photos/id/1024/1024');

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
       (10, 6, '2025-04-01 11:15:00', 'closed'),
       (11, 9, '2025-04-01 11:30:00', 'pending'),
       (12, 4, '2025-04-01 11:45:00', 'closed'),
       (13, 1, '2025-04-01 12:00:00', 'pending'),
       (14, 10, '2025-04-01 12:15:00', 'closed'),
       (4, 8, '2025-04-01 12:30:00', 'pending');

INSERT INTO Message (senderId, receiverId, content, date)
VALUES (3, 2, 'Please give me a discount.', '2025-03-31 12:35:00'),
       (2, 3, 'No.', '2025-03-31 12:35:30'),
       (5, 4, 'I love your designs!', '2025-03-31 13:05:00'),
       (4, 5, 'Thank you!', '2025-03-31 13:05:30'),
       (3, 5, 'Can you optimize my site?', '2025-03-31 13:35:00'),
       (5, 3, 'Sure, let’s discuss details.', '2025-03-31 13:35:30'),
       (4, 2, 'Need an article on tech trends.', '2025-03-31 14:05:00'),
       (2, 4, 'I can help.', '2025-03-31 14:05:30'),
       (4, 6, 'Can you create a custom illustration?', '2025-04-01 10:05:00'),
       (6, 4, 'Sure, I will send you the draft soon.', '2025-04-01 10:06:00'),
       (3, 7, 'I need a website redesign.', '2025-04-01 10:20:00'),
       (7, 3, 'I have some ideas; let me know your requirements.', '2025-04-01 10:22:00'),
       (8, 9, 'Interested in your photography service.', '2025-04-01 10:35:00'),
       (9, 8, 'I will schedule a session soon.', '2025-04-01 10:36:00'),
       (2, 10, 'Looking for video editing, can you help?', '2025-04-01 10:50:00'),
       (10, 2, 'Yes, I can edit your video professionally.', '2025-04-01 10:52:00'),
       (5, 7, 'Do you offer social media marketing packages?', '2025-04-01 11:05:00'),
       (7, 5, 'Yes, let me send you the details.', '2025-04-01 11:06:00');

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
       (9, 4.0, 'Service was professional and prompt.', '2025-04-01 11:20:00'),
       (10, 4.0, 'Podcast editing was clear and concise.', '2025-04-01 11:20:00'),
       (11, 4.3, 'Voice over was professional and engaging.', '2025-04-01 11:30:00'),
       (12, 4.8, 'Full stack development exceeded expectations.', '2025-04-01 11:40:00'),
       (13, 3.9, 'Business card design was neat and creative.', '2025-04-01 11:50:00'),
       (14, 4.2, 'The email campaign delivered excellent ROI.', '2025-04-01 12:00:00'),
       (15, 4.5, 'The article writing provided insightful content.', '2025-04-01 12:10:00');
