-- select database
USE `OnlineStore`;

-- Purge all data

-- Insert dummy DATA
INSERT INTO Gender (gName)
VALUES ('Man'), ('Woman'), ('Other');

INSERT INTO pImage (iName)
VALUES 
('AdidasSuperstarWhite.webp'),
('ReebokNPCIIWhite.webp'),
('ReebokNPCIIBlack.webp'),
('VansClassicWhite.jpg'),
('VansClassicBlack.jpg'),
('VansClassicRed.jpg');

INSERT INTO Brand (bName)
VALUES 
('Adidas'), 
('Reebok'), 
('Vans'),
('Nike'), 
('Jordan'), 
('Converse'), 
('Crocs'), 
('PUMA'), 
('Champion'), 
('Under Armour'), 
('New Balance');

INSERT INTO pType (tName)
VALUES 
('Running'), 
('Training'), 
('Casual'),
('Basketball');

INSERT INTO Size (Size)
VALUES 
(5), (5.5), 
(6), (6.5), 
(7), (7.5), 
(8), (8.5), 
(9), (9.5), 
(10), (10.5), 
(11), (11.5),
(12), (12.5),
(13);

INSERT INTO Color (cName, Hex)
VALUES 
('Black', UNHEX('000000')), 
('White', UNHEX('FFFFFF')), 
('Red', UNHEX('FF0000'));

INSERT INTO Product 
(pName, pDescription, Price, Listed, BRANDID, TYPEID, GENDERID)
VALUES 
('Superstar', 
'Originally made for basketball courts in the 70s. Celebrated by hip hop royalty in the 80s. 
The adidas Superstar shoe is now a lifestyle staple for streetwear enthusiasts. 
The world-famous shell toe feature remains, providing style and protection. Just like it did on the B-ball courts back in the day.
Now, whether at a festival or walking in the street you can enjoy yourself without the fear of being stepped on.
The serrated 3-Stripes detail and adidas Superstar box logo adds OG authenticity to your look.', 
120.00, 1, 1, 3, 3),
('NPC II', 'Reebok classic shoes', 99.99, 1, 2, 1, 3),
('Classic', 'Vans classic old skool', 98.99, 1, 3, 3, 3),
('Flow Velociti SE', 'Running shoes', 159.99, 1, 10, 1, 1),
('Nicekicks Kamikaze', '', 160.00, 1, 2, 1, 1),
('NMD V2 Core', '', 189.99, 1, 1, 3, 1),
('NMD R1', '', 189.99, 1, 1, 3, 1),
('Zoom Freak 3', '', 159.99, 1, 4, 3, 1),
('Originals Yeezy 700 MNVN', 'West classic shoes', 300.00, 1, 1, 3, 1);

INSERT INTO `User`
(LastName, FirstName, Email, Password, BirthDate, GENDERID)
VALUES 
('Gauthier', 'Dany', 'danygauthier57@yahoo.ca', '$2y$10$tHhqhrzl1rE6HXNHPX3cP.JNjSIXhGKb.C/moQ4rOcHCDkDY7sYZC', '2002-06-08', 1),
('Doe', 'John', 'john.doe@exemple.com', '$2y$10$cqIjtwlAgdecF4U5oO3hJeyqwIBnnh7o1J9x9chg.nhfIlxOgT88e', '2002-06-08', 1),
('Doe', 'Jane', 'jane.doe@exemple.com', '$2y$10$uwzVtW9PAqiadLK5ILkzje2Dv2/6fHUykfBPw/ljARxPIGIZlF63m', '2002-06-08', 2);

INSERT INTO Wishlist (PRODUCTID, USERID)
VALUES (1, 1), (2, 1), (3, 1);

INSERT INTO Cart (PRODUCTID, USERID, COLORID, SIZEID)
VALUES (1, 1, 1, 12);

INSERT INTO pImage_Product (IMAGEID, PRODUCTID)
VALUES (1, 1), (2,2), (3,2), (4,3), (5,3), (6,3);

INSERT INTO Color_Product (COLORID, PRODUCTID)
VALUES 
-- Superstar
(2, 1), 
-- Reebok
(1, 2), 
(2, 2), 
-- Vans
(1, 3),
(2, 3),
(3, 3);

INSERT INTO Size_Product (SIZEID, PRODUCTID)
VALUES 
-- Superstar
(1, 1), 
(2, 1), 
(3, 1), 
(4, 1), 
(5, 1), 
(6, 1), 
(7, 1), 
(8, 1), 
(9, 1), 
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
-- Reebok
(1, 2), 
(2, 2), 
(3, 2), 
(4, 2), 
(5, 2), 
(6, 2), 
(7, 2), 
(8, 2), 
(9, 2), 
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
-- Vans
(1, 3), 
(2, 3), 
(3, 3), 
(4, 3), 
(5, 3), 
(6, 3), 
(7, 3), 
(8, 3), 
(9, 3), 
(10, 3),
(11, 3),
(12, 3),
(13, 3),
(14, 3),
(15, 3),
(16, 3);
