--Insert Tony Stark
INSERT INTO clients
(clientFirstname, clientLastname, clientEmail, clientPassword, comment)
VALUES
("Tony", "Stark", "tony@starkent.com", "Iam1ronM@n", "I am the real Ironman");

--Read the clients table
SELECT clientId, clientFirstname, clientLastname, clientLevel FROM clients;

--Update Tony Stark from level 1 to level 3
Update clients SET clientLevel = '3' WHERE clientFirstname = 'Tony';

--Find the GM Hummer
SELECT invId, invMake, invModel, invDescription FROM inventory WHERE invMake = 'GM';

--Update the GM Hummer description
UPDATE inventory SET invDescription = REPLACE(invDescription, 'small interior', 'spacious interior');

--Find the SUV
SELECT carclassification.classificationId, carclassification.classificationName, inventory.invMake, inventory.invModel FROM inventory INNER JOIN carclassification ON inventory.classificationId = carclassification.classificationId WHERE carclassification.classificationName = 'SUV';

--Find the Jeep
SELECT invId, invMake, invModel, invDescription FROM inventory WHERE invMake = 'Jeep';

--Delete the Jeep
DELETE FROM inventory WHERE invId = 1;

--Find Images and Thumbnails
SELECT invImage, invThumbnail FROM inventory;

--Update Images and Thumbnails
UPDATE inventory SET invImage = CONCAT('/phpmotors', invImage), invThumbnail = CONCAT('/phpmotors', invThumbnail);