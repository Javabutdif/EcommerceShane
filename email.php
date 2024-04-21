<?php

$msg = "First line of text\nSecond line of text";

if (mail("edinavillegas2002@gmail.com", "My subject",$msg)){
    echo "Email successfully sent!";
}else{
    echo "Email sending failed!";
}
?>