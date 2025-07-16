var EmployeesService = {
  load_all: async function () {
    const res = await fetch(`${Constants.API_BASE}/employees/performance`);
    const data = await res.json();
    console.log(data);
    const table = document.querySelector("#employee-performance tbody");
    table.innerHTML = "";

    data.forEach(emp => {
      table.innerHTML += `
        <tr>
          <td class="text-center">
            <div class="btn-group" role="group">
              <button class="btn btn-warning" onclick="EmployeesService.edit_employee(${emp.id})">Edit</button>
              <button class="btn btn-danger" onclick="EmployeesService.delete_employee(${emp.id})">Delete</button>
            </div>
          </td>
          <td>${emp.full_name}</td>
          <td>–</td>
          <td>${emp.total}</td>
        </tr>`;
    });
  },

  delete_employee: async function (employee_id) {
    if (confirm("Do you want to delete employee with the id " + employee_id + "?")) {
      const res = await fetch(`${Constants.API_BASE}/employee/delete/${employee_id}`, {
        method: "DELETE"
      });
      const json = await res.json();
      alert(json.message);
      this.load_all();
    }
  },

  edit_employee: function (employee_id) {
    document.querySelector("#customer_id").value = employee_id;
    document.querySelector("#first_name").value = "";
    document.querySelector("#last_name").value = "";
    document.querySelector("#email").value = "";

    const modal = new bootstrap.Modal(document.getElementById("edit-employee-modal"));
    modal.show();
  }
};

document.addEventListener("DOMContentLoaded", () => {
  EmployeesService.load_all();

  document.querySelector("form").addEventListener("submit", async function (e) {
    const id = document.querySelector("#customer_id").value;
    const data = {
      firstName: document.querySelector("#first_name").value,
      lastName: document.querySelector("#last_name").value,
      email: document.querySelector("#email").value,
      jobTitle: "Sales Rep"
    };

    const res = await fetch(`${Constants.API_BASE}/employee/edit/${id}`, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data)
    });

    const json = await res.json();
    alert(json.message);

    const modalEl = document.getElementById("edit-employee-modal");
    bootstrap.Modal.getInstance(modalEl).hide();
    EmployeesService.load_all();
  });
});
