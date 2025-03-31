DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS ServiceCategory;
DROP TABLE IF EXISTS Service;
DROP TABLE IF EXISTS ServiceMedia;
DROP TABLE IF EXISTS Purchase;
DROP TABLE IF EXISTS Message;
DROP TABLE IF EXISTS Feedback;

CREATE TABLE User
(
    userId   INTEGER,
    name     NVARCHAR NOT NULL,
    username VARCHAR  NOT NULL,
    email    VARCHAR  NOT NULL,
    password VARCHAR  NOT NULL,

    CONSTRAINT User_PK PRIMARY KEY (userId),
    CONSTRAINT User_email_unique UNIQUE (email),
    CONSTRAINT User_username_unique UNIQUE (username)
);

CREATE TABLE ServiceCategory
(
    serviceCategoryId INTEGER,
    name              VARCHAR NOT NULL,

    CONSTRAINT ServiceCategory_PK PRIMARY KEY (serviceCategoryId)
);

CREATE TABLE Service
(
    serviceId    INTEGER,
    freelancerId INTEGER NOT NULL,
    categoryId   INTEGER,
    price        INTEGER NOT NULL,
    deliveryTime DATE    NOT NULL,
    description  TEXT    NOT NULL,
    status       VARCHAR NOT NULL,

    CONSTRAINT Service_PK PRIMARY KEY (serviceId),
    CONSTRAINT Service_freelancer_FK FOREIGN KEY (freelancerId) REFERENCES User (userId) ON DELETE CASCADE,
    CONSTRAINT Service_category_FK FOREIGN KEY (categoryId) REFERENCES ServiceCategory (serviceCategoryId) ON DELETE SET NULL,
    CONSTRAINT Service_status_check CHECK ( status IN ('active', 'inactive', 'deleted') )
);

CREATE TABLE ServiceMedia
(
    serviceMediaId INTEGER,
    serviceId      INTEGER,
    mediaURL       VARCHAR,

    CONSTRAINT ServiceMedia_PK PRIMARY KEY (serviceMediaId),
    CONSTRAINT ServiceMedia_service_FK FOREIGN KEY (serviceId) REFERENCES Service (serviceId) ON DELETE CASCADE
);

CREATE TABLE Purchase
(
    purchaseId INTEGER,
    serviceId  INTEGER,
    clientId   INTEGER,
    date       DATE    NOT NULL,
    status     VARCHAR NOT NULL,

    CONSTRAINT Purchase_PK PRIMARY KEY (purchaseId),
    CONSTRAINT Purchase_service_FK FOREIGN KEY (serviceId) REFERENCES Service (serviceId) ON DELETE SET NULL,
    CONSTRAINT Purchase_client_FK FOREIGN KEY (clientId) REFERENCES User (userId) ON DELETE SET NULL,
    CONSTRAINT Purchase_status_check CHECK ( status IN ('pending', 'closed') )
);

CREATE TABLE Message
(
    messageId  INTEGER,
    senderId   INTEGER,
    receiverId INTEGER,
    serviceId  INTEGER NOT NULL,
    content    TEXT    NOT NULL,
    date       DATE    NOT NULL,

    CONSTRAINT Message_PK PRIMARY KEY (messageId),
    CONSTRAINT Message_sender_FK FOREIGN KEY (senderId) REFERENCES User (userId) ON DELETE SET NULL,
    CONSTRAINT Message_receiver_FK FOREIGN KEY (receiverId) REFERENCES User (userId) ON DELETE SET NULL,
    CONSTRAINT Message_service_FK FOREIGN KEY (serviceId) REFERENCES Service (serviceId)
);

CREATE TABLE Feedback
(
    feedbackId INTEGER,
    purchaseId INTEGER NOT NULL,
    rating     FLOAT   NOT NULL,
    review     TEXT,
    date       DATE    NOT NULL,

    CONSTRAINT Feedback_PK PRIMARY KEY (feedbackId),
    CONSTRAINT Feedback_purchase_FK FOREIGN KEY (purchaseId) REFERENCES Purchase (purchaseId),
    CONSTRAINT Feedback_rating_check CHECK ( rating > 0 AND rating < 5 )
);
