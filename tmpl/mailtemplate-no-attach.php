--http://webcheatsheet.com/php/send_email_text_html_attachment.php
--/*(c) 2014 by keepitnative*/
--PHP-mixed-<?php echo $random_hash; ?>
Content-Type: application/zip; name="<?php echo $imgName;?>"
Content-Transfer-Encoding: base64
Content-Disposition: attachment

<?php echo $attachment; ?>
--PHP-mixed-<?php echo $random_hash; ?>-- --PHP-mixed-<?php echo $random_hash; ?>
Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>"

--PHP-alt-<?php echo $random_hash; ?>
Content-Type: text/html; charset="iso-8859-1"
Content-Transfer-Encoding: 7bit

<h2>Offerte</h2>
<p>Die Offerte wird so bald als möglich bearbeitet.</p>
<?php
echo $msg
?>