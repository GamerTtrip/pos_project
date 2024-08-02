<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HTML Print Example</title>
    <link rel="stylesheet" href="invoice.css" />
  </head>
  <body>
    <div class="buttons-container">
      <button id="save">Save</button>
      <button id="print">Print</button>
    </div>
    <a id="save_to_image">
      <div class="invoice-container">
        <table cellpadding="0" cellspacing="0">
          <tr class="top">
            <td colspan="2">
            </td>
          </tr>
          <tr class="information">
            <td colspan="2">
              <table>
                <tr>
                  <td>
                    CAVITE STATE UNIVERSITY GENTRI CAMPUS<br />
                    007 Arnaldo Hwy, General Trias, 4107 Cavite<br />
                    EBA OFFICES
                  </td>
                  <td>
                    DATE <br />
                    EMAIL: <br />
                    Student Number
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <tr class="heading">
            <td>Item</td>
            <td>Price</td>
          </tr>
          <tr class="item">
            <td>item name</td>
            <td>item price</td>
          </tr>

          <tr class="total">
            <td></td>
            <td>Total : 300.00</td>
          </tr>
          <tr class="total">
            <td></td>
            <td>Money: 1000</td>
          </tr>
          <tr class="total">
            <td></td>
            <td>Change : 700 </td>
          </tr>
        </table>
      </div>
    </a>
    <script src="/html2canvas.js"></script>
    <script src="index.js"></script>
  </body>
</html>