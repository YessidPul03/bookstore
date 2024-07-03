<?php

// tests/obtenerTest.php

use PHPUnit\Framework\TestCase;

class ObtenerTest extends TestCase
{
    protected $pdo;

    protected function setUp(): void
    {
        $this->pdo = $GLOBALS['pdo'];
    }

    public function testObtenerLibros()
    {
        ob_start();
        require '../api/obtener.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('success', $output);
        $this->assertStringContainsString('data', $output);

        // $libros = json_decode($output, true);
        // $this->assertIsArray($libros);
    }
}
