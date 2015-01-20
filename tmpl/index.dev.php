<?php
/**
 * Created by PhpStorm.
 * * (c) 2014 by  peterruler, all rights reserved, GNU/GPL
 * Date: 19.11.14
 * Time: 15:23
 * (c) 2014, all rights reserved
 */
namespace ch\keepitnative\formmailer;
use ch\keepitnative\formmailer\src\csrfprotection\CsrfProtection;
?>
<!DOCTYPE html>
<html>
<head lang="de">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="shortcut icon" href="http://www.trivadis.com/uploads/pics/Schweizerische-Post-Logo.png">
    <title>Formmailer</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col col-md-offset-4 col-md-4">
            <h2>Offerte</h2>

            <p>Alle mit * gekennzeichneten Felder sind Plichtfelder</p>
            <?php
            use ch\keepitnative\formmailer\src\captcha\Captcha;

                print $errors::getErrors();
                print $errors::getMsg();
            //var_dump(gettype($validater->errors));
            ?>
            <form id="form01" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" role="form">
                <fieldset>
                    <legend>Adresse</legend>
                    <p>
                        <label class="sr-only" for="email">E-Mail *</label>
                        <input type="text" id="email" class="form-control" name="email" placeholder="Email * " autofocus
                               value="<?php echo $input->post('email'); ?>"/>
                    </p>

                    <p>
                        <label class="sr-only" for="nachname">Name *</label>
                        <input type="text" id="nachname" class="form-control" name="nachname" placeholder="Name * "
                               value="<?php echo $input->post('nachname'); ?>"/>
                    </p>

                    <p>
                        <label class="sr-only" for="vorname">Vorname *</label>
                        <input type="text" id="vorname" class="form-control" name="vorname" placeholder="Vorname * "
                               value="<?php echo $input->post('vorname'); ?>"/>
                    </p>

                    <p>
                        <label class="sr-only" for="strassenr">Strasse/nr *</label>
                        <input type="text" id="strassenr" class="form-control" name="strassenr"
                               placeholder="Strassenr * "
                               value="<?php echo $input->post('strassenr'); ?>"/>
                    </p>

                    <p>
                        <label class="sr-only" for="plzort">Plz/Ort *</label>
                        <input type="text" id="plzort" class="form-control" name="plzort" placeholder="Plz/Ort * "
                               value="<?php echo $input->post('plzort'); ?>"/>
                    </p>

                    <p>
                        <label class="sr-only" for="telefon">Telefon</label>
                        <input type="tel" id="telefon" class="form-control" name="telefon" placeholder="Telefon * "
                               value="<?php echo $input->post('telefon'); ?>"/>
                    </p>

                    <p>
                        <label class="sr-only" for="bemerkungen">Bemerkungen *</label>
                        <textarea id="bemerkungen" class="form-control" name="bemerkungen"
                                  placeholder="Bemerkungen"><?php echo $input->post('bemerkungen'); ?></textarea>
                    </p>
                    <?php
                    if($configRegistry->get('config')['captchaBenutzen']) :
                        ?>
                        <p>
                            <label class="sr-only" for="captcha">Bitte Code eingeben *</label>
                            <?php Captcha::outputImage();?>
                            <input type="text" id="captcha" class="form-control" name="captcha" placeholder="Captcha * "
                                   value="<?php echo $input->post('captcha'); ?>"/>

                        </p>
                    <?php
                    endif;
                    ?>
                </fieldset>
                <fieldset>
                    <legend>Angaben zum Sujet</legend>
                    <p>
                        <label for="sujet">Sujet</label>
                        Es kann ein Bild von maximal 2MB als AI/EPS/JPG/PNG/GIF oder PDF Datei hochgeladen werden.<br/>
                        <?php /* You may need to sanitize the value of $_POST['file_upload'];
                               * this is just a start */
                        if($input->post('sujet') && !empty($input->post('sujet'))){ ?>
                            <input type="hidden" value="<?php print $input->post('sujet'); ?>" />
                        <?php } else { ?>
                            <input type="file" name="sujet" id="sujet" class="form-control" name="text"/>
                        <?php } ?>
                    </p>

                    <p class="dropdown">
                        <label for="format">Format *</label>
                        <select name="format" class="form-control">
                            <option <?php echo $format = ($input->post('format') == 1) ?  'selected=selected':''; ?>
                                value="1">Nur Text
                            </option>
                            <option <?php echo $format = ($input->post('format') == 2) ? 'selected=selected' : ''; ?>
                                value="2">Nur Bild
                            </option>
                            <option <?php echo $format = ($input->post('format') == 3) ? 'selected=selected' :  '' ?>
                                value="3">Bild und
                                Text
                            </option>
                        </select>
                    </p>
                    <p>
                        <label for="groesse">Grösse *</label>
                        <textarea id="groesse" class="form-control" name="groesse" placeholder="Grösse">
                            <?php echo $groesse =  preg_replace('/[^\+w]\+s\+w/','',$input->post('groesse')); ?>
                        </textarea>
                    </p>

                    <p class="dropdown">
                        <label for="art">Art *</label>
                        <select name="art" class="form-control">
                            <option <?php echo $format = ($input->post('art') == 1) ? 'selected=selected' : ''; ?>
                                value="1">Whatever
                            </option>
                            <option <?php echo $format = ($input->post('art') == 2) ? 'selected=selected' : ''; ?>
                                value="2">Whatelse
                            </option>
                        </select>
                    </p>
                </fieldset>
                <?php
                CsrfProtection::createTokenField();
                ?>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Absenden</button><br>
                <input name="reset" value="Zur&uuml;cksetzen" class="btn btn-lg btn-primary btn-block" type="submit"/>
            </form>
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script>
    ;(function($) {

    })(jQuery);
</script>
</body>
</html>