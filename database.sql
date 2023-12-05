ALTER TABLE users
ADD COLUMN avatar VARCHAR(255) DEFAULT 'https://i.ibb.co/BKSN4Lv/pxrp-less-then-10mb-1.gif',  -- Replace with the default avatar URL
ADD COLUMN playtime INT DEFAULT 0;


CREATE TABLE p42_chatlog (
    id INT AUTO_INCREMENT PRIMARY KEY,
    playerId VARCHAR(255),
    username VARCHAR(255),
    message TEXT,
    timestamp DATETIME
);



CREATE TABLE p42_supporttickets (
    ticket_id INT AUTO_INCREMENT PRIMARY KEY,
    creator_id VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    status VARCHAR(50) NOT NULL,
    creation_date DATETIME DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE p42_ticketmessages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT NOT NULL,
    sender_id VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ticket_id) REFERENCES p42_supporttickets(ticket_id)
);
