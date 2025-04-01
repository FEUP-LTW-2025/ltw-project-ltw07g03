DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS ServiceCategory;
DROP TABLE IF EXISTS Service;
DROP TABLE IF EXISTS ServiceMedia;
DROP TABLE IF EXISTS Purchase;
DROP TABLE IF EXISTS Message;
DROP TABLE IF EXISTS Feedback;

CREATE TABLE User
(
    userId            INTEGER,
    name              NVARCHAR(255) NOT NULL,
    username          VARCHAR(255) NOT NULL,
    email             VARCHAR(255) NOT NULL,
    password          VARCHAR(255) NOT NULL,
    isAdmin           BOOLEAN      NOT NULL DEFAULT 0,
    profilePictureURL VARCHAR(1023),
    status            VARCHAR(15),

    CONSTRAINT User_PK PRIMARY KEY (userId),
    CONSTRAINT User_email_unique UNIQUE (email),
    CONSTRAINT User_username_unique UNIQUE (username),
    CONSTRAINT User_isAdmin_CK CHECK ( isAdmin IN (0, 1) ),
    CONSTRAINT User_status_CK CHECK ( status IN ('active', 'inactive') )
);

CREATE TABLE ServiceCategory
(
    serviceCategoryId INTEGER,
    name              VARCHAR(255) NOT NULL,

    CONSTRAINT ServiceCategory_PK PRIMARY KEY (serviceCategoryId)
);

CREATE TABLE Service
(
    serviceId    INTEGER,
    freelancerId INTEGER        NOT NULL,
    categoryId   INTEGER,
    title        VARCHAR(255)   NOT NULL,
    price        DECIMAL(10, 2) NOT NULL,
    deliveryTime INTEGER        NOT NULL,
    description  TEXT           NOT NULL,
    status       VARCHAR(15)    NOT NULL,
    rating       DECIMAL(2, 1)  NOT NULL DEFAULT 0,

    CONSTRAINT Service_PK PRIMARY KEY (serviceId),
    CONSTRAINT Service_freelancer_FK FOREIGN KEY (freelancerId) REFERENCES User (userId) ON UPDATE CASCADE,
    CONSTRAINT Service_category_FK FOREIGN KEY (categoryId) REFERENCES ServiceCategory (serviceCategoryId) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT Service_deliveryTime_check CHECK ( deliveryTime > 0 ),
    CONSTRAINT Service_status_CK CHECK ( status IN ('active', 'inactive', 'deleted') ),
    CONSTRAINT Service_rating_CK CHECK ( rating BETWEEN 0 AND 5 )
);

CREATE TABLE ServiceMedia
(
    serviceMediaId INTEGER,
    serviceId      INTEGER       NOT NULL,
    mediaURL       VARCHAR(1023) NOT NULL,

    CONSTRAINT ServiceMedia_PK PRIMARY KEY (serviceMediaId),
    CONSTRAINT ServiceMedia_service_FK FOREIGN KEY (serviceId) REFERENCES Service (serviceId) ON UPDATE CASCADE
);

CREATE TABLE Purchase
(
    purchaseId INTEGER,
    serviceId  INTEGER     NOT NULL,
    clientId   INTEGER     NOT NULL,
    date       DATETIME    NOT NULL,
    status     VARCHAR(15) NOT NULL,

    CONSTRAINT Purchase_PK PRIMARY KEY (purchaseId),
    CONSTRAINT Purchase_service_FK FOREIGN KEY (serviceId) REFERENCES Service (serviceId) ON UPDATE CASCADE,
    CONSTRAINT Purchase_client_FK FOREIGN KEY (clientId) REFERENCES User (userId) ON UPDATE CASCADE,
    CONSTRAINT Purchase_status_CK CHECK ( status IN ('pending', 'closed') )
);

CREATE TABLE Message
(
    messageId  INTEGER,
    senderId   INTEGER  NOT NULL,
    receiverId INTEGER  NOT NULL,
    serviceId  INTEGER  NOT NULL,
    content    TEXT     NOT NULL,
    date       DATETIME NOT NULL,

    CONSTRAINT Message_PK PRIMARY KEY (messageId),
    CONSTRAINT Message_sender_FK FOREIGN KEY (senderId) REFERENCES User (userId) ON UPDATE CASCADE,
    CONSTRAINT Message_receiver_FK FOREIGN KEY (receiverId) REFERENCES User (userId) ON UPDATE CASCADE,
    CONSTRAINT Message_service_FK FOREIGN KEY (serviceId) REFERENCES Service (serviceId) ON UPDATE CASCADE
);

CREATE TABLE Feedback
(
    feedbackId INTEGER,
    purchaseId INTEGER       NOT NULL,
    rating     DECIMAL(2, 1) NOT NULL DEFAULT 0,
    review     TEXT,
    date       DATETIME      NOT NULL,

    CONSTRAINT Feedback_PK PRIMARY KEY (feedbackId),
    CONSTRAINT Feedback_purchase_FK FOREIGN KEY (purchaseId) REFERENCES Purchase (purchaseId) ON UPDATE CASCADE,
    CONSTRAINT Feedback_rating_CK CHECK ( rating BETWEEN 0 AND 5 )
);

CREATE TRIGGER update_service_rating_after_rating_insert
    AFTER INSERT
    ON Feedback
BEGIN
    UPDATE Service
    SET rating = COALESCE((SELECT AVG(f.rating)
                           FROM Feedback f
                                    JOIN Purchase p ON f.purchaseId = p.purchaseId
                           WHERE p.serviceId = NEW.purchaseId), 0)
    WHERE serviceId = (SELECT serviceId FROM Purchase WHERE purchaseId = NEW.purchaseId);
END;
