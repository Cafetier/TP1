-- Insert dummy DATA
INSERT INTO Gender (GenderName)
VALUES ('Man'), ('Woman'), ('Other');

INSERT INTO ProductImage (ImageName)
VALUES ('Help.png');

INSERT INTO Brand (BrandName)
VALUES ('Adidas'), ('Reebok'), ('Vans');

INSERT INTO ProductType (TypeName)
VALUES ('Running'), ('Training'), ('Everyday');

INSERT INTO Color (ColorName)
VALUES ('Red'), ('Blue'), ('Green');

INSERT INTO Product 
(ProductName, ProductDescription, COLORID, BRANDID, TYPEID)
VALUES ('Superstar', 'Cool stuff', 1, 1, 3);

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

INSERT INTO ImageProduct (IMAGEID, PRODUCTID)
VALUES (1, 1);

