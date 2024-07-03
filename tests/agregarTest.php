<?php
// tests/agregarTest.php

use PHPUnit\Framework\TestCase;

class AgregarTest extends TestCase
{
    protected $pdo;

    protected function setUp(): void
    {
        $this->pdo = $GLOBALS['pdo'];
        $this->pdo->exec("DELETE FROM libros WHERE titulo = 'Libro de Prueba'");
    }

    public function testAgregarLibroExitoso()
    {
        $data = [
            'titulo' => 'Libro de Prueba',
            'autor' => 'Autor de Prueba',
            'ano_publicacion' => 2023,
            'genero' => 'Ficción'
        ];

        $_POST = $data;
        ob_start();
        require '../api/agregar.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Libro agregado exitosamente', $output);

        // Verificar que el libro fue agregado en la base de datos
        $stmt = $this->pdo->prepare("SELECT * FROM libros WHERE titulo = ?");
        $stmt->execute([$data['titulo']]);
        $book = $stmt->fetch();

        $this->assertNotFalse($book);
    }

    public function testAgregarLibroSinCamposRequeridos()
    {
        $data = [
            'titulo' => '',
            'autor' => '',
            'ano_publicacion' => '',
            'genero' => ''
        ];

        $_POST = $data;
        ob_start();
        require '../api/agregar.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('Todos los campos son obligatorios', $output);
    }
}
