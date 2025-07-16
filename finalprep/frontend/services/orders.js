
var OrdersService = {
  load_all: async function () {
    const res = await fetch(`${Constants.API_BASE}/orders/report`);
    const data = await res.json();
    const table = document.querySelector("#order-details tbody");
    table.innerHTML = "";

    data.forEach(order => {
      table.innerHTML += `
        <tr>
          <td class="text-center">
            <button class="btn btn-success" onclick="OrdersService.show_details(${order.orderNumber})">Details</button>
          </td>
          <td>${order.orderNumber}</td>
          <td>${order.total}</td>
        </tr>`;
    });
  },

  show_details: async function (order_id) {
    const res = await fetch(`${Constants.API_BASE}/order/details/${order_id}`);
    const data = await res.json();

    const tbody = document.querySelector("#order-details-modal tbody");
    tbody.innerHTML = "";
    let total = 0;
    data.forEach((item, index) => {
      const rowTotal = item.quantityOrdered * item.priceEach;
      total += rowTotal;
      tbody.innerHTML += `
        <tr>
          <th scope="row">${index + 1}</th>
          <td>${item.productName}</td>
          <td>${item.quantityOrdered}</td>
          <td>${item.priceEach.toFixed(2)}</td>
        </tr>`;
    });

    tbody.innerHTML += `
      <tr>
        <td colspan="3"><strong>Total bill</strong></td>
        <td><strong>${total.toFixed(2)}</strong></td>
      </tr>`;

    const modal = new bootstrap.Modal(document.getElementById("order-details-modal"));
    modal.show();
  }
};

document.addEventListener("DOMContentLoaded", OrdersService.load_all);
