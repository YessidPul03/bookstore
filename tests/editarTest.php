<?php

// tests/editarTest.php

use PHPUnit\Framework\TestCase;

class EditarTest extends TestCase
{
    protected $pdo;

    protected function setUp(): void
    {
        $this->pdo = $GLOBALS['pdo'];
        $this->pdo->exec("DELETE FROM libros WHERE titulo = 'Libro de Prueba Editado'");
        $this->pdo->exec("INSERT INTO libros (titulo, autor, ano_publicacion, genero) VALUES ('Libro de Prueba', 'Autor de Prueba', 2023, 'Ficción')");
    }

    public function testEditarLibroExitoso()
    {
        $data = [
            'id' => 1,
            'titulo' => 'Libro Editado',
            'autor' => 'Autor Editado',
            'ano_publicacion' => 2023,
            'genero' => 'No Ficción'
        ];

        $_POST = $data;
        ob_start();
        require '../api/editar.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Libro editado exitosamente', $output);

        // Verificar que el libro fue editado en la base de datos
        $stmt = $this->pdo->prepare("SELECT * FROM libros WHERE id = ?");
        $stmt->execute([$data['id']]);
        $book = $stmt->fetch();

        $this->assertEquals('Libro de Prueba Editado', $book['titulo']);
        $this->assertEquals('Autor de Prueba Editado', $book['autor']);
        $this->assertEquals(2024, $book['ano_publicacion']);
        $this->assertEquals('No Ficción', $book['genero']);
    }

    public function testEditarLibroSinCamposRequeridos()
    {
        $data = [
            'id' => 1,
            'titulo' => '',
            'autor' => '',
            'ano_publicacion' => '',
            'genero' => ''
        ];

        $_POST = $data;
        ob_start();
        require '../api/editar.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Todos los campos son obligatorios', $output);
    }
}
