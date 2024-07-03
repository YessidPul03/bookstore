<?php

// tests/obtenerPorIdTest.php

use PHPUnit\Framework\TestCase;

class ObtenerPorIdTest extends TestCase
{
    protected $pdo;

    protected function setUp(): void
    {
        $this->pdo = $GLOBALS['pdo'];
        $this->pdo->exec("DELETE FROM libros WHERE titulo = 'Libro de Prueba por ID'");
        $this->pdo->exec("INSERT INTO libros (titulo, autor, ano_publicacion, genero) VALUES ('Libro de Prueba por ID', 'Autor de Prueba', 2023, 'Ficción')");
    }

    public function testObtenerLibroPorIdExitoso()
    {
        $stmt = $this->pdo->prepare("SELECT id FROM libros WHERE titulo = 'Libro de Prueba por ID'");
        $stmt->execute();
        $book = $stmt->fetch();

        $data = [
            'id' => $book['id']
        ];

        $_GET = $data;
        ob_start();
        require '../api/obtener_por_id.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('success', $output);
        $this->assertStringContainsString('data', $output);
        // $libro = json_decode($output, true);
        // $this->assertIsArray($libro);
        // $this->assertArrayHasKey('id', $libro);
    }

    public function testObtenerLibroPorIdInvalido()
    {
        $_GET['id'] = 'invalid';
        ob_start();
        require '../api/obtener_por_id.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('ID del libro es obligatorio', $output);
    }
}
