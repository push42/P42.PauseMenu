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



