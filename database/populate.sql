INSERT INTO User
VALUES (1, 'admin', 'administrator', 'admin@gmail.com', '123', 1),
       (2, 'john', 'John Doe', 'john@gmail.com', '123', 0),
       (3, 'mary', 'Mary Joe', 'mary@gmail.com', '123', 0);

INSERT INTO ServiceCategory
VALUES (1, 'Design'),
       (2, 'Web Development');

INSERT INTO Service
VALUES (1, 2, 2, 'Dynamic webpages using PHP', 150, 2, 'Contact me!', 'active');

INSERT INTO ServiceMedia
VALUES (1, 1, 'https://picsum.photos/id/237/1024');

INSERT INTO Purchase
VALUES (1, 1, 3, 1743439908, 'pending');

INSERT INTO Message
VALUES (1, 3, 2, 1, 'Please give me a discount.', 1743439970),
       (2, 2, 3, 1, 'No.', 1743439993);
