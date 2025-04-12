const table = document.getElementById("default-table");
const modal = document.getElementById('modal');
const form = document.getElementsByTagName('form')[0];
let idCurrent = null;

function toggleModal() {
  const isChecked = modal.getAttribute('aria-checked') === 'true';
  modal.setAttribute('aria-checked', !isChecked);
}

form.addEventListener('submit', async function (event) {
  try {
    event.preventDefault();
    const formData = new FormData(form);


    console.log({ idCurrent });
    if (idCurrent) {
      formData.append('id', idCurrent);
    }

    const resp = await fetch('api/user', {
      method: 'POST',
      body: formData
    })

    if (!resp.ok) {
      throw new Error('Error en la solicitud');
    }
    const response = await resp.json();
    toggleModal();
    if (idCurrent)
      alert('Usuario actualizado correctamente');
    else
      alert('Usuario agregado correctamente');
    // recargar la pagina
    window.location.reload();
  } catch (error) {
    console.error('Error:', error);
    alert('Error al agregar el usuario');
  }
})

function editUser(id) {
  const user = users.find(user => Number(user.id) === id);
  if (!user) {
    console.error('Usuario no encontrado');
    return;
  }
  idCurrent = user.id;
  form.name.value = user.name;
  form.email.value = user.email;
  form.role.value = user.role;
  toggleModal();
  form.password.value = '';
  form.password.removeAttribute('required');
}

async function deleteUser(id) {
  try {
    const resp = await fetch('api/user?id=' + id, {
      method: 'DELETE',
    });

    if (!resp.ok) {
      throw new Error('Error en la solicitud');
    }

    const response = await resp.json();

    if (response.error) {
      alert(response.error);
      return;
    }

    alert('Usuario eliminado correctamente');
    // recargar la pagina
    window.location.reload();
  } catch (error) {
    console.error('Error:', error);
    alert('Error al eliminar el usuario');
  }
}

// Obtener los datos de los usuarios
const data = users.map(user => {
  return {
    id: user.id,
    name: user.name,
    email: user.email,
    role: user.role,
    status: user.status,
    created_at: user.created_at,
    updated_at: user.updated_at,
  };
});

const columns = [{
  title: "ID",
  data: "id"
},
{
  title: "Nombre",
  data: "name"
},
{
  title: "Email",
  data: "email"
},
{
  title: "Rol",
  data: "role"
},
{
  title: "Estado",
  data: "status"
},
{
  title: "Fecha de creación",
  data: "created_at"
},
{
  title: "Fecha de actualización",
  data: "updated_at"
},
{
  title: "Acciones",
  data: "id"
}
];

const options = {
  data: {
    headings: columns.map(col => col.title),
    data: data.map(user => columns.map(col => user[col.data]))
  },
  columns: [
    { select: 0, sortable: true }, // Ocultar la columna ID
    { select: 1, sortable: true },
    { select: 2, sortable: true },
    { select: 3, sortable: true },
    { select: 4, sortable: true },
    { select: 5, sortable: true },
    { select: 6, sortable: true },
    {
      select: 7,
      sortable: false,
      render: function (row) {
        return `<button class="text-primary cursor-pointer" onclick="editUser(${row[0].data})">Editar</button>
                <button class="text-red-400 cursor-pointer" onclick="deleteUser(${row[0].data})">Eliminar</button>`;
      }
    }
  ],
  perPage: 10,
  perPageSelect: [5, 10, 20],
  searchable: true,
  labels: {
    placeholder: "Buscar...",
    perPage: " registros por página",
    noRows: "No se encontraron registros",
    info: "Mostrando {start} a {end} de {rows} registros",
  }
};

const dataTable = new simpleDatatables.DataTable(table, options);

// estilos
const input = document.querySelector("#container-table-users input");
const select = document.querySelector("#container-table-users select");
const parentTable = table.parentElement;

input.classList.add("rounded-md", "border", "border-gray-300", "shadow-sm", "focus:border-blue-500", "focus:ring", "focus:ring-blue-200", "focus:ring-opacity-50", "bg-white", "dark:bg-gray-800", "dark:border-gray-700");
select.classList.add("rounded-md", "border", "border-gray-300", "shadow-sm", "focus:border-blue-500", "focus:ring", "focus:ring-blue-200", "focus:ring-opacity-50", "bg-white", "dark:bg-gray-800", "dark:border-gray-700");
parentTable.classList.add("overflow-x-auto", "rounded-lg", "shadow", "bg-white", "dark:bg-gray-800", "dark:border-gray-700");

// Agregar un boton de agregar usuario a lado del input
const addButton = document.createElement("button");
addButton.innerText = "Agregar usuario";
addButton.classList.add("ml-2", "px-4", "py-2", "bg-primary", "text-white", "rounded-md", "shadow-sm", "hover:bg-primary/50");

addButton.addEventListener("click", function () {
  toggleModal();
  form.password.addAttribute('required', true);
  form.reset();
  idCurrent = null;
});

input.parentElement.appendChild(addButton);

// Cerrar el modal al hacer teclear "Escape"
document.addEventListener('keydown', (event) => {
  if (event.key === 'Escape') {
    modal.setAttribute('aria-checked', false);
  }
});
