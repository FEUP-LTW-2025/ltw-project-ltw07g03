INSERT INTO User (name, username, email, password, isAdmin)
VALUES ('admin', 'administrator', 'admin@gmail.com', '123', 1),
       ('john', 'John Doe', 'john@gmail.com', '123', 0),
       ('mary', 'Mary Joe', 'mary@gmail.com', '123', 0);

INSERT INTO ServiceCategory (name)
VALUES ('Design'),
       ('Web Development');

INSERT INTO Service (freelancerId, categoryId, title, price, deliveryTime, description, status)
VALUES (2, 2, 'Dynamic webpages using PHP', 150, 2, 'Contact me!', 'active');

INSERT INTO ServiceMedia (serviceId, mediaURL)
VALUES (1, 'https://picsum.photos/id/237/1024');

INSERT INTO Purchase (serviceId, clientId, date, status)
VALUES (1, 3, 1743439908, 'pending');

INSERT INTO Message (senderId, receiverId, serviceId, content, date)
VALUES (3, 2, 1, 'Please give me a discount.', 1743439970),
       (2, 3, 1, 'No.', 1743439993);
