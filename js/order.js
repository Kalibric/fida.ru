document.addEventListener('DOMContentLoaded', () => {
    const orderForm = document.querySelector('#order-form');
    const dateInput = document.querySelector('#dateInput');
    let date = new Date();
    dateInput.min = `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()+1}`;
    dateInput.value = `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()+1}`;
    orderForm.addEventListener('submit', (e) => {
    });

});