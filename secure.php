<!Doctype html>
<html>
  <body>
<?php

  
  extract($_POST);

  $pname = '';
  $amount = '';

  if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'payment'){


      if (isset($_POST['pname']) && isset($_POST['amount'])) {
        $pname = $_POST['pname'];
        $amount = $_POST['amount'];
        $purchaseOrderNo = $_POST['purchaseOrderNo'];

        ?>
        <form onsubmit="return false;">
          <div id="securepay-ui-container"></div>
          <button onclick="mySecurePayUI.tokenise();">Submit</button>
        </form>
        <form method="post" id="paymentForm">
          <input type="hidden" name="orderId" value="<?= $purchaseOrderNo?>">
          <input type="hidden" name="pname" value="<?= $pname?>">
          <input type="hidden" name="amount" value="<?= $amount?>">
          <input type="hidden" name="token" id="token" value="">          
          <input type="hidden" name="merchantCode" id="merchantCode" value="">          
        </form>
        <button id="payamount" style="visibility: hidden;">click</button>
        <?php 
      }else{
        echo "redirect empty";
      }

  }else{
    echo "redirect";
  }
?>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

 <script id="securepay-ui-js" src="https://payments-stest.npe.auspost.zone/v3/ui/client/securepay-ui.min.js"></script>
    <script type="text/javascript">

      var merchantId = '5AR0055';

      var mySecurePayUI = new securePayUI.init({
        containerId: 'securepay-ui-container',
        scriptId: 'securepay-ui-js',
        clientId: '0oaxb9i8P9vQdXTsn3l5',
        merchantCode: merchantId,
        card: {
            allowedCardTypes: ['visa', 'mastercard'],
            showCardIcons: false,
            onCardTypeChange: function(cardType) {
              // card type has changed
            },
            onBINChange: function(cardBIN) {
              // card BIN has changed
            },
            onFormValidityChange: function(valid) {
              // form validity has changed
            },
            onTokeniseSuccess: function(tokenisedCard) {
              document.getElementById('token').value=tokenisedCard.token;
              document.getElementById('merchantCode').value=tokenisedCard.merchantCode;
              // document.getElementById("payamount").click();
              $(function(){
              var form = $('#paymentForm');
              
              data = form.serialize();

              $.ajax({
                    url: "./payment_process.php",
                    type: 'POST',
                    data: data                   
                 })
                 .done(function(response) {

                   console.log(response);  

                 });
              })
            },
            onTokeniseError: function(errors) {              
              
            }
        },        
        onLoadComplete: function () {
          
        }       
      });
    </script>
  </body>
</html>