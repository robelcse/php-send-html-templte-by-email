<?php


include_once 'Database.php';
  

class Mail {
    
    public $email;
    public $qty=1;
    public $price;
    public $subtotal;
    public $vat=0;
    public $total;
    public $deposit;
    public $payafterwork;
    
    public $package;
    public $subject;
    private $db;
    public $invoice_no; 
    
   
  function __construct($email, $price, $subtotal, $total, $deposit, $payafterwork, $package, $subject, $invoice_no) {
     
      $this->email = $email;
      $this->price = $price;
      $this->subtotal = $subtotal;
      $this->total = $total;
      $this->deposit = $deposit;
      $this->payafterwork = $payafterwork;
      $this->package = $package;
      $this->subject = $subject;
      $this->invoice_no = $invoice_no;
      
      $this->db = new Database();
      $this->sendEmailTouser();
      $this->store_email();
      
      
      
  }
  
  
  
  
  
  public function store_email(){
      
        $email = $this->email;
        $invoice_no = $this->invoice_no;
        $sql = "INSERT INTO projects(email,invoice) VALUES('$email', '$invoice_no')";
        $this->db->insert($sql);
  }
  
  
  
  public function sendEmailTouser(){
      
        $email = $this->email;
        $to      = $email;
        $subject = $this->subject;
         
       
        $price = $this->price;
        $total = $this->total;
        $subtotal = $this->subtotal;
        $deposit = $this->deposit;
        //$payafterwork = $this->payafterwork;
        $payafterwork = ($price-$deposit);
        
        $date = date("d M Y");
        
        $invoice_no = $this->invoice_no;
     
        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
         
        // Create email headers
        $headers .= 'From: Spouseware <support@spouseware.net>'."\r\n".
            'Reply-To: support@spouseware.net' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
   

        $message ='<section id="printdata" class="payment-wrapper">
        <style>
        
                .payment-option-image{
                        width:100%;
                        display:inline-block;
                    }
                    .bitcoin-image{
                        width:100%;
                        display:inline-block;
                    }
                        
                @media (min-width:300px) and (max-width:400px)
                {
                    .payment-option-image{
                        width:335px;
                        display:inline-block;
                    }
                    .bitcoin-image{
                        width:380px;
                        display:inline-block;
                    }
                    
                }
            </style>
     



<div style="width: 80%; margin: 0 auto;margin-bottom: 20px;background:#f8f9fa;">
    <table class="table" style="width: 100%; max-width: 100%; margin-bottom: 1rem;">
        <tr>
            <td align="center" style="padding: 10px;">
                <p>'.$invoice_no.'</p>
                <img width="60" src="https://www.hakerlist.co/wp-content/themes/hackerslist/images/barcode.png" alt="barcode" title="HL Barcode">
                <p>Date: '.$date.'</p>
            </td>
            <td align="center" style="padding: 10px;">
                <div style="text-align: center;">
                    <p style="margin-bottom:0;">Spouseware™Cears<br>Technology Ltd</p>
                    <p style="margin-top:0;margin-bottom:0;"><a href="https://www.spouseware.net/" target="_blank">www.spouseware.net</a></p>
                    <p style="margin-top:0;margin-bottom:0;"><a style="color:#000000;" href="mailto:support@spouseware.net">support@spouseware.net</a></p>
                    <p style="margin-top:0;">ABN: 954 673 652</p>
                </div>
            </td>
            <td align="center" style="padding: 10px;">
                <img src="https://spouseware.net/logo.png" width="60" alt="logo" title="HackersList" style="padding-top: 5px;margin:0 auto;">
            </td>
        </tr>
    </table>
</div>


<div style="width: 80%; margin: 0 auto;margin-bottom: 10px;">
        <table class="table table-hover" style="width: 100%; max-width: 100%; margin-bottom: 1rem;">
            <thead style="color: #7cb937;">
                <tr style="text-align:left;">
                    <th style="vertical-align: bottom; border-bottom: 1px solid #eceeef;border-top: 1px solid #eceeef;padding: 0.75rem;">Line Item</th>
                    <th style="vertical-align: bottom; border-bottom: 1px solid #eceeef;border-top: 1px solid #eceeef;padding: 0.75rem;">Qty</th>
                    <th style="vertical-align: bottom; border-bottom: 1px solid #eceeef;border-top: 1px solid #eceeef;padding: 0.75rem;">Price</th>
                </tr>
            </thead>

            <tbody>
                <tr style="text-align:left;">
                    <td style="padding: 0.75rem; vertical-align: top; border-top: 1px solid #eceeef;">Spouseware™ Online Pack</td>
                    <td style="padding: 0.75rem; vertical-align: top; border-top: 1px solid #eceeef;">01</td>
                    <td style="padding: 0.75rem; vertical-align: top; border-top: 1px solid #eceeef;">$'.$price.'</td>
                </tr>
                <tr style="text-align:left;">
                    <td style="padding: 0.75rem; vertical-align: top; border-top: 1px solid #eceeef;">Subtotal</td>
                    <td style="padding: 0.75rem; vertical-align: top; border-top: 1px solid #eceeef;"></td>
                    <td style="padding: 0.75rem; vertical-align: top; border-top: 1px solid #eceeef;">$'.$subtotal.'</td>
                </tr>
                <tr style="text-align:left;">
                    <td style="padding: 0.75rem; vertical-align: top; border-top: 1px solid #eceeef;">VAT</td>
                    <td style="padding: 0.75rem; vertical-align: top; border-top: 1px solid #eceeef;"></td>
                    <td style="padding: 0.75rem; vertical-align: top; border-top: 1px solid #eceeef;">$0</td>
                </tr>
                <tr style="text-align:left;">
                    <td style="vertical-align: bottom; border-bottom: 1px solid #eceeef;border-top: 1px solid #eceeef;padding: 0.75rem;">Total</td>
                    <td style="vertical-align: bottom; border-bottom: 1px solid #eceeef;border-top: 1px solid #eceeef;padding: 0.75rem;"></td>
                    <td style="vertical-align: bottom; border-bottom: 1px solid #eceeef;border-top: 1px solid #eceeef;padding: 0.75rem;">$'.$total.'</td>
                </tr>
            </tbody>

            <tfoot style="color: #7cb937;">
                <tr style="text-align:left;">
                    <th style="vertical-align: bottom; border-bottom: 1px solid #eceeef;border-top: 1px solid #eceeef;padding: 0.75rem;">Deposit</th>
                    <th style="vertical-align: bottom; border-bottom: 1px solid #eceeef;border-top: 1px solid #eceeef;padding: 0.75rem;"></th>
                    <th style="vertical-align: bottom; border-bottom: 1px solid #eceeef;border-top: 1px solid #eceeef;padding: 0.75rem;">$'.$deposit.'</th>
                </tr>
                <tr style="text-align:left;">
                    <th style="vertical-align: bottom; border-bottom: 1px solid #eceeef;border-top: 1px solid #eceeef;padding: 0.75rem;">Pay after work delivery</th>
                    <th style="vertical-align: bottom; border-bottom: 1px solid #eceeef;border-top: 1px solid #eceeef;padding: 0.75rem;"></th>
                    <th style="vertical-align: bottom; border-bottom: 1px solid #eceeef;border-top: 1px solid #eceeef;padding: 0.75rem;">$'.$payafterwork.'</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div style="width: 50%; margin: 0 auto; border: 1px solid #7cb937;">
        <h2 style="color: #7cb937;text-align:center;text-decoration: none;">Pay Now $100</h2>
    </div>

    <div style="width: 80%; margin: 0 auto;margin-bottom: 20px;">
        <div style="padding:10px 0;color: #000;" align="center">
            <h3 style="color: #000;">Payment options and  instructions</h3>
            <p>We ensure you pay anonymously and your transaction cannot be traced to Spouseware&trade;. Please pay by card, gift card, Bitcoin, PayPal following the instructions below:</p>
        </div>

        <div style="margin-bottom: 35px;" class="payment-option-one">
            <div style=" background: #7cb937">
               <img src="https://www.spouseware.net/payment/img/english/option-1.png" class="payment-option-image" width="100%">
            </div>
            <div>
                <p>Log in <a href="http://xoom.com/" target="_blank">xoom.com</a> with your PayPal login. Click Send Money, Select country Bangladesh, enter <strong>$100</strong>, Select Cash Pickup Send to receiver:<br><br>

                <strong style="font-style: italic">
                    First Name: RAKIB<br>
                    Last Name:  HASAN<br>
                    Address: 100 Link Road Badda<br>
                    District: Dhaka<br>
                    Division: Dhaka Zila<br>
                    Phone: +8801798233772
                </strong>   

                <br><br>
                 Forward to <a href="mailto:support@spouseware.net">support@spouseware.net</a> the Xoom transaction confirmation email when ready for pick up
                <!--<br><br>
                <img class="mx-auto d-block" src="https://www.spouseware.net/assets/images/paypal.png" width="200" alt="paypal" title="We accept paypal">-->
                <br><br><i>Remarks: <img src="https://www.spouseware.net/assets/images/icons/star1.png" width="16" height="16"> <img src="https://www.spouseware.net/assets/images/icons/star1.png" width="16" height="16"> <img src="https://www.spouseware.net/assets/images/icons/star1.png" width="16" height="16"> <img src="https://www.spouseware.net/assets/images/icons/star1.png" width="16" height="16"> <img src="https://www.spouseware.net/assets/images/icons/star1.png" width="16" height="16"> Fast, familiar.</i><br><br>
                <strong>Pay by: Paypal</strong></p>
            </div>
        </div>

        <div style="margin-bottom: 35px;" class="payment-option-two">
            <div style="background: #7cb937">
               <img src="https://www.spouseware.net/payment/img/english/option-2.png" class="payment-option-image" width="100%">
            </div>
            <div>
                <p>Visit your nearby store at <a href="http://locations.westernunion.com/" target="_blank">locations.westernunion.com</a> and send <strong>$100</strong> (equivalent BDT) to the receiver:<br><br>

                <strong style="font-style: italic">
                    Full Name: RAKIB HASAN <br>
                    Address: 100 Link Road Badda <br>
                    City/State: Dhaka <br>
                    Postcode: 1212 <br>
                    Country: Bangladesh <br>
                    Tel: +8801795322772
                </strong>  
                
                <br><br>
               Send to <a href="mailto:support@spouseware.net">support@spouseware.net</a> a photo of the full receipt.
                <br><br><i>Remarks: <img src="https://www.spouseware.net/assets/images/icons/star1.png" width="16" height="16"> <img src="https://www.spouseware.net/assets/images/icons/star1.png" width="16" height="16"> <img src="https://www.spouseware.net/assets/images/icons/star1.png" width="16" height="16"> <img src="https://www.spouseware.net/assets/images/icons/star1.png" width="16" height="16"> <img src="https://www.spouseware.net/assets/images/icons/star2.png" width="16" height="16"> Fast but takes 3 to 5 hours.</i><br><br>
                <strong>Pay by: Western union</strong></p>
            </div>
        </div>

        <div style="margin-bottom: 35px;" class="payment-option-three">
            
             <div style="background: #7cb937">
               <img src="https://www.spouseware.net/payment/img/english/option-3.png" class="bitcoin-image" width="100%">
            </div>
            <div>
                <p>Visit <a href="https://buy.coingate.com" target="_blank">https://buy.coingate.com</a>, select USD, write <strong>$100</strong>, Enter the Bitcoin address 1McDpMvyztoPG7r154zjFaKQ26yGb8D9fH and Checkout. You may also send from <a href="http://paybis.com/" target="_blank">paybis.com</a>, <a href="http://bitpay.com/" target="_blank">bitpay.com</a> or <a href="http://buy.chainbits.com/">buy.chainbits.com</a> and many other companies.Send a screenshot of the Bitcoin transaction to <a href="mailto:support@spouseware.net">support@spouseware.net</a><br><br>
                <img class="mx-auto d-block" src="https://www.hakerlist.co/wp-content/themes/hackerslist/images/qr-code.png" width="150" alt="qr-code" title="QR Code"><br><br>
                <i>Remarks: <img src="https://spouseware.net/assets/images/icons/star1.png" width="16" height="16"> <img src="https://spouseware.net/assets/images/icons/star1.png" width="16" height="16"> <img src="https://spouseware.net/assets/images/icons/star1.png" width="16" height="16"> <img src="https://spouseware.net/assets/images/icons/star2.png" width="16" height="16"> <img src="https://spouseware.net/assets/images/icons/star2.png" width="16" height="16"> Fast but new to some users.</i><br><br>
                <strong>Pay by: Bitcoin</strong></p>
            </div>
        </div>
        <hr>
        <div style="background:#7cb937; padding:10px;color:#FFF;">
            <strong>Authorized by:</strong>
            <p>Payment & Billing Team, Spouseware™<br>Support Contact: <a href="mailto:support@spouseware.net">support@spouseware.net</a></p>
        </div>
    </div>
</section>';




          mail($to, $subject, $message, $headers);
          
        //   if($this->package==1) {
              
        //         $url  = $_SERVER['REQUEST_URI']; 
        //         header('Location: '.$url);
              
        //      // header('Location: https://www.spouseware.net/payment2.php?package=1');
              
        //   }elseif ($this->package==2){
              
        //       $url  = $_SERVER['REQUEST_URI']; 
        //       header('Location: '.$url);
              
        //      // header('Location: https://www.spouseware.net/payment2.php?package=2');
              
        //   }elseif ($this->package==3){
              
        //       $url  = $_SERVER['REQUEST_URI']; 
        //       header('Location: '.$url);
              
        //       //header('Location: https://www.spouseware.net/payment2.php?package=3');
              
        //   }
          
         
  }
  
  
   
}//end method

 
?>