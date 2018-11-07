<?php
  /* Setup your Subject and Message Body */
  $subject='Testing PHP Email';
  $body='Put Your Text Message Here.';
  
  /* Specify your SMTP Server, Port and Valid From Address */
  ini_set("SMTP","smtp.baddeo.com");
  ini_set("smtp_port","25");
  ini_set("sendmail_from","i.am.dissatisfied@gmail.com");
  
  /* Additional Headers */
  $headers = "Cc:Real CC Name <ccUser@theirdomain.com>\r\n";
  $headers .= "Bcc:Real BCC Name <bccUser@theirdomain.com>\r\n";
  
  /* Try to send message and respond if it sends or fails. */
  if(mail ('Matteo <iosonomatteo@gmail.com>', $subject, $body, $headers )){
      echo "<h2>Your Message was sent!</h2>";
  }
  else{
      echo "<font color='red'><h2>Your Message Was Not Sent!</h2></font>";
  }
  exit;
?>
