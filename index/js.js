function submitForm(size, name, id, sizeValue, price) {
  document.getElementById('choose_size').value = size;
  document.getElementById('p_name').value = name;
  document.getElementById('p_id').value = id;
  document.getElementById('p_size').value = sizeValue;
  document.getElementById('p_price').value = price;
  document.getElementById('productForm').submit();
}
$(".menu-btn").click(function (){
    $(".navbar .menu").toggleClass("active");
    $(".menu-btn i").toggleClass("active");
})


$(document).off('.alert.data-api')


  $('#myModal').modal(options)

  $('#myModal').on('shown.bs.modal', function () {
    $('#myInput').focus()
  })
  

function toggleCart() {
    const cartContent = document.querySelector('.cart-content');
    cartContent.classList.toggle('open');
}


function calculateChange() {
  const total_price = parseFloat(document.getElementById('total_price_input').value);
  const customer_money = parseFloat(document.getElementById('customer_money').value) || 0;
  const change = customer_money - total_price;

  document.getElementById('change').innerText = change >= 0 ? `Change: ${change.toFixed(2)}` : 'Insufficient funds';
}



document.getElementById("checkout-button").addEventListener("click", function(event) {
  event.preventDefault();

  html2canvas(document.querySelector(".cart-content")).then(canvas => {
      canvas.toBlob(blob => {
          const formData = new FormData();
          formData.append("receipt_image", blob, "receipt.png");

          fetch("upload_receipt.php", {
              method: "POST",
              body: formData
          }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Set hidden input with the receipt filename
                    document.getElementById("receipt_filename").value = data.filename;

                    // Submit the form to finalize the transaction
                    document.querySelector("form").submit();
                } else {
                    alert("Error uploading receipt");
                }
            });
      });
  });
});