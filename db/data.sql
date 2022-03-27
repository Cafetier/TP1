-- Insert dummy DATA
INSERT INTO Gender (GenderName)
VALUES ('Man'), ('Woman'), ('Other');

INSERT INTO pImage (ImageName)
VALUES ('Help.png');

INSERT INTO Brand (BrandName)
VALUES ('Adidas'), ('Reebok'), ('Vans');

INSERT INTO pType (TypeName)
VALUES ('Running'), ('Training'), ('Everyday');

INSERT INTO pSize (Size)
VALUES (10), (10.5), (11);

INSERT INTO Color (ColorName, Hex)
VALUES ('Red', UNHEX('FF0000')), 
('Green', UNHEX('8fce00')), 
('Blue', UNHEX('2986cc'));

INSERT INTO Product 
(ProductName, ProductDescription, Price, Listed, BRANDID, TYPEID)
VALUES 
('Superstar', 'Cool stuff', 109.99, 1, 1, 3),
('Rockstar', 'Another shit', 299.99, 1, 2, 1),
('Jordan 911', 'Oh yeah', 98.99, 1, 3, 3);

INSERT INTO User 
(LastName, FirstName, Email, Password, BirthDate, GENDERID)
VALUES 
('Gauthier', 'Dany', 'danygauthier57@yahoo.ca', 'Abc123', '2002-06-08', 1),
('Doe', 'John', 'john.doe@exemple.com', 'Abc123', '2002-06-08', 1),
('Doe', 'Jane', 'jane.doe@exemple.com', 'Abc123', '2002-06-08', 1);

INSERT INTO Wishlist (PRODUCTID, USERID)
VALUES (1, 1);

INSERT INTO Cart (PRODUCTID, USERID)
VALUES (1, 2);

INSERT INTO pImage_Product (IMAGEID, PRODUCTID)
VALUES (1, 1);

INSERT INTO Color_Product (COLORID, PRODUCTID)
VALUES (1, 1), (2, 1), (3, 1);

INSERT INTO pSize_Product (SIZEID, PRODUCTID)
VALUES (1, 1), (2, 1), (3, 1);

