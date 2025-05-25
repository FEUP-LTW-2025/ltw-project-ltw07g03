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
    name              NVARCHAR(255),
    username          VARCHAR(255),
    email             VARCHAR(255),
    password          VARCHAR(255),
    isAdmin           BOOLEAN     DEFAULT 0,
    profilePictureURL VARCHAR(1023),
    status            VARCHAR(15) DEFAULT 'inactive',

    CONSTRAINT User_PK PRIMARY KEY (userId),
    CONSTRAINT User_email_unique UNIQUE (email),
    CONSTRAINT User_username_unique UNIQUE (username),
    CONSTRAINT User_name_NN CHECK (name IS NOT NULL),
    CONSTRAINT User_username_NN CHECK (username IS NOT NULL),
    CONSTRAINT User_email_NN CHECK (email IS NOT NULL),
    CONSTRAINT User_password_NN CHECK (password IS NOT NULL),
    CONSTRAINT User_isAdmin_NN CHECK (isAdmin IS NOT NULL),
    CONSTRAINT User_status_NN CHECK (status IS NOT NULL),
    CONSTRAINT User_isAdmin_CK CHECK (isAdmin IN (0, 1)),
    CONSTRAINT User_status_CK CHECK (status IN ('active', 'inactive'))
);

CREATE TABLE ServiceCategory
(
    serviceCategoryId INTEGER,
    name              VARCHAR(255),
    icon              VARCHAR(15),

    CONSTRAINT ServiceCategory_PK PRIMARY KEY (serviceCategoryId),
    CONSTRAINT ServiceCategory_name_NN CHECK (name IS NOT NULL),
    CONSTRAINT ServiceCategory_icon_NN CHECK (icon IS NOT NULL)
);

CREATE TABLE Service
(
    serviceId    INTEGER,
    freelancerId INTEGER,
    categoryId   INTEGER,
    title        VARCHAR(255),
    price        DECIMAL(10, 2),
    deliveryTime INTEGER,
    description  TEXT,
    about        TEXT,
    status       VARCHAR(15),
    rating       DECIMAL(2, 1) DEFAULT 0,

    CONSTRAINT Service_PK PRIMARY KEY (serviceId),
    CONSTRAINT Service_freelancerId_NN CHECK (freelancerId IS NOT NULL),
    CONSTRAINT Service_title_NN CHECK (title IS NOT NULL),
    CONSTRAINT Service_price_NN CHECK (price IS NOT NULL),
    CONSTRAINT Service_deliveryTime_NN CHECK (deliveryTime IS NOT NULL),
    CONSTRAINT Service_description_NN CHECK (description IS NOT NULL),
    CONSTRAINT Service_status_NN CHECK (status IS NOT NULL),
    CONSTRAINT Service_rating_NN CHECK (rating IS NOT NULL),
    CONSTRAINT Service_freelancer_FK FOREIGN KEY (freelancerId) REFERENCES User (userId) ON UPDATE CASCADE,
    CONSTRAINT Service_category_FK FOREIGN KEY (categoryId) REFERENCES ServiceCategory (serviceCategoryId) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT Service_deliveryTime_check CHECK (deliveryTime > 0),
    CONSTRAINT Service_status_CK CHECK (status IN ('active', 'inactive', 'deleted')),
    CONSTRAINT Service_rating_CK CHECK (rating BETWEEN 0 AND 5)
);

CREATE TABLE ServiceMedia
(
    serviceMediaId INTEGER,
    serviceId      INTEGER,
    mediaURL       VARCHAR(1023),

    CONSTRAINT ServiceMedia_PK PRIMARY KEY (serviceMediaId),
    CONSTRAINT ServiceMedia_serviceId_NN CHECK (serviceId IS NOT NULL),
    CONSTRAINT ServiceMedia_mediaURL_NN CHECK (mediaURL IS NOT NULL),
    CONSTRAINT ServiceMedia_service_FK FOREIGN KEY (serviceId) REFERENCES Service (serviceId) ON UPDATE CASCADE
);

CREATE TABLE Purchase
(
    purchaseId INTEGER,
    serviceId  INTEGER,
    clientId   INTEGER,
    date       INTEGER,
    status     VARCHAR(15),

    CONSTRAINT Purchase_PK PRIMARY KEY (purchaseId),
    CONSTRAINT Purchase_serviceId_NN CHECK (serviceId IS NOT NULL),
    CONSTRAINT Purchase_clientId_NN CHECK (clientId IS NOT NULL),
    CONSTRAINT Purchase_date_NN CHECK (date IS NOT NULL),
    CONSTRAINT Purchase_status_NN CHECK (status IS NOT NULL),
    CONSTRAINT Purchase_service_FK FOREIGN KEY (serviceId) REFERENCES Service (serviceId) ON UPDATE CASCADE,
    CONSTRAINT Purchase_client_FK FOREIGN KEY (clientId) REFERENCES User (userId) ON UPDATE CASCADE,
    CONSTRAINT Purchase_status_CK CHECK (status IN ('pending', 'closed'))
);

CREATE TABLE Message
(
    messageId  INTEGER,
    senderId   INTEGER,
    receiverId INTEGER,
    content    TEXT,
    date       INTEGER,

    CONSTRAINT Message_PK PRIMARY KEY (messageId),
    CONSTRAINT Message_senderId_NN CHECK (senderId IS NOT NULL),
    CONSTRAINT Message_receiverId_NN CHECK (receiverId IS NOT NULL),
    CONSTRAINT Message_content_NN CHECK (content IS NOT NULL),
    CONSTRAINT Message_date_NN CHECK (date IS NOT NULL),
    CONSTRAINT Message_sender_FK FOREIGN KEY (senderId) REFERENCES User (userId) ON UPDATE CASCADE,
    CONSTRAINT Message_receiver_FK FOREIGN KEY (receiverId) REFERENCES User (userId) ON UPDATE CASCADE
);

CREATE TABLE Feedback
(
    feedbackId INTEGER,
    purchaseId INTEGER,
    rating     DECIMAL(2, 1) DEFAULT 0,
    review     TEXT,
    date       INTEGER,

    CONSTRAINT Feedback_PK PRIMARY KEY (feedbackId),
    CONSTRAINT Feedback_purchaseId_NN CHECK (purchaseId IS NOT NULL),
    CONSTRAINT Feedback_rating_NN CHECK (rating IS NOT NULL),
    CONSTRAINT Feedback_date_NN CHECK (date IS NOT NULL),
    CONSTRAINT Feedback_purchase_FK FOREIGN KEY (purchaseId) REFERENCES Purchase (purchaseId) ON UPDATE CASCADE,
    CONSTRAINT Feedback_rating_CK CHECK (rating BETWEEN 0 AND 5)
);

CREATE TRIGGER update_service_rating_after_rating_insert
    AFTER INSERT
    ON Feedback
BEGIN
    UPDATE Service
    SET rating = COALESCE((SELECT AVG(f.rating)
                           FROM Feedback f
                                    JOIN Purchase p ON f.purchaseId = p.purchaseId
                           WHERE p.serviceId = (SELECT serviceId FROM Purchase WHERE purchaseId = NEW.purchaseId)), 0)
    WHERE serviceId = (SELECT serviceId FROM Purchase WHERE purchaseId = NEW.purchaseId);
END;

CREATE TRIGGER update_service_rating_after_rating_update
    AFTER UPDATE
    ON Feedback
BEGIN
    UPDATE Service
    SET rating = COALESCE((SELECT AVG(f.rating)
                           FROM Feedback f
                                    JOIN Purchase p ON f.purchaseId = p.purchaseId
                           WHERE p.serviceId = (SELECT serviceId FROM Purchase WHERE purchaseId = NEW.purchaseId)), 0)
    WHERE serviceId = (SELECT serviceId FROM Purchase WHERE purchaseId = NEW.purchaseId);
END;

CREATE TRIGGER update_service_rating_after_rating_delete
    AFTER DELETE
    ON Feedback
BEGIN
    UPDATE Service
    SET rating = COALESCE((SELECT AVG(f.rating)
                           FROM Feedback f
                                    JOIN Purchase p ON f.purchaseId = p.purchaseId
                           WHERE p.serviceId = (SELECT serviceId FROM Purchase WHERE purchaseId = OLD.purchaseId)), 0)
    WHERE serviceId = (SELECT serviceId FROM Purchase WHERE purchaseId = OLD.purchaseId);
END;
