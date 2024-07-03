const baseUrl = "http://localhost/vsc_yeyowork/bookstore/api";

async function agregarLibro() {
  const titulo = document.getElementById("titulo").value;
  const autor = document.getElementById("autor").value;
  const ano_publicacion = document.getElementById("ano_publicacion").value;
  const genero = document.getElementById("genero").value;

  const response = await fetch(`${baseUrl}/agregar.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ titulo, autor, ano_publicacion, genero }),
  });

  const data = await response.json();
  alert(data.message);
  obtenerLibros();
}

async function editarLibro() {
  const id = document.getElementById("id").value;
  const titulo = document.getElementById("titulo").value;
  const autor = document.getElementById("autor").value;
  const ano_publicacion = document.getElementById("ano_publicacion").value;
  const genero = document.getElementById("genero").value;

  const response = await fetch(`${baseUrl}/editar.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ id, titulo, autor, ano_publicacion, genero }),
  });

  const data = await response.json();
  alert(data.message);
  obtenerLibros();
}

async function eliminarLibro(id) {
  const response = await fetch(`${baseUrl}/eliminar.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ id }),
  });

  const data = await response.json();
  alert(data.message);
  obtenerLibros();
}

async function obtenerLibros() {
  const response = await fetch(`${baseUrl}/obtener.php`);
  const libros = await response.json();

  const lista = document.getElementById("lista");
  lista.innerHTML = "";

  libros.forEach((libro) => {
    const item = document.createElement("li");
    item.innerHTML = `
            <span>${libro.titulo} - ${libro.autor} - ${libro.ano_publicacion} - ${libro.genero}</span>
            <div class="button-container">
                <button onclick="editarFormulario(${libro.id}, '${libro.titulo}', '${libro.autor}', ${libro.ano_publicacion}, '${libro.genero}')">Editar</button>
                <button onclick="eliminarLibro(${libro.id})">Eliminar</button>
            </div>
        `;
    lista.appendChild(item);
  });
}

async function buscarLibro() {
  const id = document.getElementById("buscarId").value;

  if (!id) {
    alert("Ingrese un ID válido para buscar.");
    return;
  }

  try {
    const response = await fetch(`${baseUrl}/obtener_por_id.php?id=${id}`);
    const libro = await response.json();

    if (libro && !libro.message) {
      const lista = document.getElementById("lista");
      lista.innerHTML = "";

      const item = document.createElement("li");
      item.innerHTML = `
                <span>${libro.titulo} - ${libro.autor} - ${libro.ano_publicacion} - ${libro.genero}</span>
                <div class="button-container">
                    <button onclick="editarFormulario(${libro.id}, '${libro.titulo}', '${libro.autor}', ${libro.ano_publicacion}, '${libro.genero}')">Editar</button>
                    <button onclick="eliminarLibro(${libro.id})">Eliminar</button>
                </div>
            `;
      lista.appendChild(item);
    } else {
      alert(
        libro.message || "No se encontró ningún libro con el ID proporcionado."
      );
    }
  } catch (error) {
    console.error("Error al buscar el libro:", error);
    alert(
      "Ocurrió un error al buscar el libro. Verifique la consola para más detalles."
    );
  }
}

function editarFormulario(id, titulo, autor, ano_publicacion, genero) {
  document.getElementById("id").value = id;
  document.getElementById("titulo").value = titulo;
  document.getElementById("autor").value = autor;
  document.getElementById("ano_publicacion").value = ano_publicacion;
  document.getElementById("genero").value = genero;
}

document.addEventListener("DOMContentLoaded", obtenerLibros);
