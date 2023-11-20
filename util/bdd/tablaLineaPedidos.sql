CREATE TABLE lineasPedidos (
    lineaPedido INT AUTO_INCREMENT PRIMARY KEY,
    idProducto INT,
    idPedido INT,
    precioUnitario FLOAT,
    cantidad INT,
    FOREIGN KEY (idProducto) REFERENCES Productos(idProducto),
    FOREIGN KEY (idPedido) REFERENCES Pedidos(idPedido)
);