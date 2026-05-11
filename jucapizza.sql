CREATE TABLE pizzas (
    idPizza INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    ingredientes VARCHAR(255) NOT NULL,
    valor DECIMAL(10, 2) NOT NULL
);
INSERT INTO pizzas (nome, ingredientes, valor) VALUES
('Calabresa', 'Mussarela, calabresa fatiada e cebola', 45.50),
('Mussarela', 'Mussarela e molho de tomate', 40.00),
('Frango com Catupiry', 'Frango desfiado, catupiry e mussarela', 52.90),
('Portuguesa', 'Mussarela, presunto, ovo, ervilha, cebola e calabresa', 62.90),
('Moda do Juca', 'Mussarela, peito de peru, palmito, alho poró e alcaparras', 72.50);

CREATE TABLE bebidas (
    idBebida INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao VARCHAR(255) NOT NULL,
    valor DECIMAL(10, 2) NOT NULL
);


INSERT INTO bebidas (nome, descricao, valor) VALUES
('Coca-Cola', 'Lata 350ml', 6.50),
('Coca-Cola', 'Garrafa 2L', 14.00),
('Suco de Laranja', 'Copo 400ml - Natural', 9.90),
('Água Mineral', '500ml sem gás', 4.00),
('Cerveja Heineken', 'Long Neck 330ml', 11.00),
('Vinho Tinto Casa Valduga', 'Garrafa 750ml', 85.00);