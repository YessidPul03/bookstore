<?php

// tests/eliminarTest.php

use PHPUnit\Framework\TestCase;

class EliminarTest extends TestCase
{
    protected $pdo;

    protected function setUp(): void
    {
        $this->pdo = $GLOBALS['pdo'];
        $this->pdo->exec("DELETE FROM libros WHERE titulo = 'Libro de Prueba a Eliminar'");
        $this->pdo->exec("INSERT INTO libros (titulo, autor, ano_publicacion, genero) VALUES ('Libro de Prueba a Eliminar', 'Autor de Prueba', 2023, 'Ficción')");
    }

    public function testEliminarLibroExitoso()
    {
        $stmt = $this->pdo->prepare("SELECT id FROM libros WHERE titulo = 'Libro de Prueba a Eliminar'");
        $stmt->execute();
        $book = $stmt->fetch();

        $data = [
            'id' => $book['id']
        ];

        $_POST = $data;
        ob_start();
        require '../api/eliminar.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Libro eliminado exitosamente', $output);

        // Verificar que el libro fue eliminado de la base de datos
        $stmt = $this->pdo->prepare("SELECT * FROM libros WHERE id = ?");
        $stmt->execute([$data['id']]);
        $book = $stmt->fetch();

        $this->assertFalse($book);
    }

    public function testEliminarLibroSinId()
    {
        $data = ['id' => ''];

        $_POST = $data;
        ob_start();
        require '../api/eliminar.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('ID del libro es obligatorio', $output);
    }
}
