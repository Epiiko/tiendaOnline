CREATE TABLE Pedidos (
    idPedido INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(255),
    precioTotal FLOAT,
    fechaPedido DATE  DEFAULT (CURDATE()),
    FOREIGN KEY (usuario) REFERENCES Usuarios(usuario)
);