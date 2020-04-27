CREATE TABLE IF NOT EXISTS Type( 
                        ID int PRIMARY KEY AUTO_INCREMENT,
                        TypeName VARCHAR(30) NOT NULL
                        )ENGINE = InnoDB;
        INSERT INTO Type (TypeName)
                        VALUE ('DVD-disc'),
                        ('Book'),
                        ('Furniture');
 CREATE TABLE IF NOT EXISTS Product(
                        SKU VARCHAR(30)  PRIMARY KEY, 
                        Name VARCHAR(30) NOT NULL,
                        Price VARCHAR(30) NOT NULL,
                        TypeID int NOT NULL,
                        Value1 int NOT NULL,
                        CONSTRAINT  FOREIGN KEY (TypeID) REFERENCES Type(ID) ON DELETE CASCADE
                        )ENGINE = InnoDB;
         CREATE TABLE IF NOT EXISTS Furniture( 
                        SKUID VARCHAR(30)  PRIMARY KEY, 
                        Height int NOT NULL,
                        Width int NOT NULL,
                        Length int NOT NULL,
                        CONSTRAINT  FOREIGN KEY (SKUID) REFERENCES Product(SKU) ON DELETE CASCADE
                        )ENGINE = InnoDB;
            CREATE TABLE IF NOT EXISTS DVD( 
                        SKUID VARCHAR(30)  PRIMARY KEY, 
                        Size int NOT NULL,
                        CONSTRAINT  FOREIGN KEY (SKUID) REFERENCES Product(SKU) ON DELETE CASCADE
                        )ENGINE = InnoDB;
           CREATE TABLE IF NOT EXISTS Book( 
                        SKUID VARCHAR(30)  PRIMARY KEY, 
                        Weight int NOT NULL,
                        CONSTRAINT  FOREIGN KEY (SKUID) REFERENCES Product(SKU) ON DELETE CASCADE
                        )ENGINE = InnoDB;