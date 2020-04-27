INSERT INTO product (SKU, Name,Price, TypeID, Value1)
VALUES
    ('ABC120', 'Test1', 10, 1, 1),
	('ABC121', 'Test2', 64, 2, 1),
	('ABC122', 'Test3', 30, 3, 1),
	('ABC123', 'Test4', 16, 1, 2),
	('ABC124', 'Test5', 653, 1, 2),
	('ABC125', 'Test6', 452, 2, 2),
	('ABC126', 'Test7', 6853, 2, 2),
	('ABC127', 'Test8', 643, 3, 2),
	('ABC128', 'Test9', 150, 1, 3),
	('ABC129', 'Test10', 160, 3, 4),
	('ABC130', 'Test11', 65, 3, 5);

INSERT INTO dvd (SKUID, Size)
VALUES
    ('ABC120',  23),	
	('ABC123', 32),
	('ABC124', 42),
	('ABC128',  3);
	
INSERT INTO book (SKUID, Weight)
VALUES

	('ABC121',  56),
	('ABC125',  22),
	('ABC126', 253);

INSERT INTO furniture (SKUID, Height,Width, Length)
VALUES
	('ABC122',  321, 41, 14),
	('ABC127',  143, 143, 1414),
	('ABC129',  413, 413, 431),
	('ABC130', 413, 235, 253);
