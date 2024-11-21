CREATE SCHEMA `livros`;
-- Criação das tabelas

CREATE TABLE Autor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    sobrenome VARCHAR(100) NOT NULL
);

CREATE TABLE Livro (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    publicacao_int INT,
    categoria VARCHAR(100),
    preco_double DOUBLE NOT NULL,
    autor_id INT NOT NULL,
    FOREIGN KEY (autor_id) REFERENCES Autor(id)
);

CREATE TABLE Categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(200) NOT NULL
);

CREATE TABLE LivroCategoria (
    livro_id INT NOT NULL,
    categoria_id INT NOT NULL,
    PRIMARY KEY (livro_id, categoria_id),
    FOREIGN KEY (livro_id) REFERENCES Livro(id),
    FOREIGN KEY (categoria_id) REFERENCES Categoria(id)
);

CREATE TABLE Usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(200) NOT NULL,
    senha VARCHAR(100) NOT NULL,
    nivelPermissao INT NOT NULL,
    dataUltimoLogin DATETIME
);

CREATE TABLE Cliente (
    usuario_id INT PRIMARY KEY,
    cpf VARCHAR(14) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id)
);

CREATE TABLE Compra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data DATE NOT NULL,
    valorTotalCompra DOUBLE NOT NULL,
    usuario_id INT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id)
);

CREATE TABLE LivroCompra (
    compra_id INT NOT NULL,
    livro_id INT NOT NULL,
    PRIMARY KEY (compra_id, livro_id),
    FOREIGN KEY (compra_id) REFERENCES Compra(id),
    FOREIGN KEY (livro_id) REFERENCES Livro(id)
);
