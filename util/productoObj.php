<?PHP
class Producto
{
    public $idProducto;
    public $nombreproductos;
    public  $precio;
    public  $descripcion;
    public  $cantidad;
    public  $rutaImagen;

    function __construct(
        $idProducto,
        $nombreproductos,
        $precio,
        $descripcion,
        $cantidad,
        $rutaImagen
    ) {
        $this -> idProducto= $idProducto;
        $this -> nombreproductos= $nombreproductos;
        $this -> precio= $precio;
        $this -> descripcion= $descripcion;
        $this -> cantidad= $cantidad;
        $this -> rutaImagen= $rutaImagen;
    }
}
