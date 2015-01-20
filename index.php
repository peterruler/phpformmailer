<?php
 /**
 * (c) 2014 by  peterruler, all rights reserved, GNU/GPL
 * Date: 19.11.14
 * Time: 15:23
 * (c) 2014, all rights reserved
 */
namespace ch\keepitnative\formmailer;

use ch\keepitnative\formmailer\src\captcha\Captcha;
use ch\keepitnative\formmailer\src\csrfprotection\CsrfProtection;
//set base paths
if(!defined('BASE_PATH')) {
    define('BASE_PATH',__DIR__);
}
if(!defined('BASE_PATH_LIB')) {
    define('BASE_PATH_LIB',__DIR__.'/src/');
}

//load required includes, just to keep things clean
$boostrapPath = __DIR__.'/init.php';
try {
    if (file_exists($boostrapPath)) {
        require_once $boostrapPath;
    } else {
        throw new Exception('Bootstrap File could not be loaded' . $boostrapPath);
    }
} catch (Exception $e) {
    print $e->getMessage();
}
?>
<?php if(ENV == 'PRODUCTION') :?>

            <h2>Offertenanfrage</h2>

            <p>Alle mit * gekennzeichneten Felder sind Plichtfelder</p>
            <?php
                print $errors::getErrors();
                print $errors::getMsg();
            //var_dump(gettype($validater->errors));
            ?>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" role="form">
                <fieldset>
                    <legend>Adresse</legend>
                    <p>
                        <label class="sr-only" for="email">E-Mail *</label>
                        <input type="text" id="email" class="form-control" name="email" placeholder="Email * " autofocus
                               value="<?php echo ($input->post('email')) ? $input->post('email') : ''; ?>"/>
                    </p>

                    <p>
                        <label class="sr-only" for="nachname">Name *</label>
                        <input type="text" id="nachname" class="form-control" name="nachname" placeholder="Name * "
                               value="<?php echo ($input->post('nachname')) ? $input->post('nachname') : ''; ?>"/>
                    </p>

                    <p>
                        <label class="sr-only" for="vorname">Vorname *</label>
                        <input type="text" id="vorname" class="form-control" name="vorname" placeholder="Vorname * "
                               value="<?php echo ($input->post('vorname')) ? $input->post('vorname') : ''; ?>"/>
                    </p>

                    <p>
                        <label class="sr-only" for="strassenr">Strasse/nr *</label>
                        <input type="text" id="strassenr" class="form-control" name="strassenr"
                               placeholder="Strassenr * "
                               value="<?php echo ($input->post('strassenr')) ? $input->post('strassenr') : ''; ?>"/>
                    </p>

                    <p>
                        <label class="sr-only" for="plzort">Plz/Ort *</label>
                        <input type="text" id="plzort" class="form-control" name="plzort" placeholder="Plz/Ort * "
                               value="<?php echo ($input->post('plzort')) ? $input->post('plzort') : ''; ?>"/>
                    </p>

                    <p>
                        <label class="sr-only" for="telefon">Telefon</label>
                        <input type="text" id="telefon" class="form-control" name="telefon" placeholder="Telefon * "
                               value="<?php echo ($input->post('telefon')) ? $input->post('telefon') : ''; ?>"/>
                    </p>

                    <p>
                        <label class="sr-only" for="bemerkungen">Bemerkungen *</label>
                        <textarea id="bemerkungen" class="form-control" name="bemerkungen"
                                  placeholder="Bemerkungen"><?php echo ($input->post('bemerkungen')) ?  $input->post('bemerkungen') : ''; ?></textarea>
                    </p>
                    <?php
                    if($configRegistry->get('config')['captchaBenutzen']) :
                    ?>
                    <p>
                        <label class="sr-only" for="captcha">Bitte Code eingeben *</label>
                        <?php Captcha::outputImage();?>
                        <input type="text" id="captcha" class="form-control" name="captcha" placeholder="Captcha * "
                               value="<?php echo ($input->post('captcha')) ? $input->post('captcha') : ''; ?>"/>

                    </p>
                     <?php
                         endif;
                     ?>
                </fieldset>
                <fieldset>
                    <legend>Angaben zum Sujet</legend>
                    <p>
                        <label for="sujet">Sujet</label>
                        Es kann ein Bild von maximal 2MB als AI / EPS / JPG / PNG / GIF oder PDF Datei hochgeladen werden.<br/>
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
                            <option <?php echo $format = ($input->post('format')) ? ($input->post('format') == 1) ? 'selected=selected' : '' : 'selected=selected'; ?>
                                value="1">Nur Text
                            </option>
                            <option <?php echo $format = ($input->post('format')) ? ($input->post('format') == 2) ? 'selected=selected' : '' : ''; ?>
                                value="2">Nur Bild
                            </option>
                            <option <?php echo $format = ($input->post('format')) ? ($input->post('format') == 3) ? 'selected=selected' : '' : '' ?>
                                value="3">Bild und
                                Text
                            </option>
                        </select>
                    </p>
                    <p>
                        <label for="groesse">Grösse *</label>
                        <textarea id="groesse" class="form-control" name="groesse" placeholder="Groesse"><?php echo ($input->post('groesse')) ? $groesse =  preg_replace('/[^\+w]\+s\+w/','',$input->post('groesse')) : '';
?></textarea>
                    </p>

                    <p class="dropdown">
                        <label for="art">Art *</label>
                        <select name="art" class="form-control">
                            <option <?php echo $format = ($input->post('art')) ? ($input->post('art') == 1) ? 'selected=selected' : '' : ''; ?>
                                value="1">Whatever
                            </option>
                            <option <?php echo $format = ($input->post('art')) ? ($input->post('art') == 2) ? 'selected=selected' : '' : ''; ?>
                                value="2">Whatelse
                            </option>
                        </select>
                    </p>
                </fieldset>
                <?php
                    CsrfProtection::createTokenField();
                ?>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Absenden</button>
                <input name="reset" value="Zur&uuml;cksetzen" class="btn btn-lg btn-primary btn-block" type="submit"/>
            </form>

    <?php
    else :
        require_once __DIR__ . '/tmpl/index.dev.php';
    ?>
<?php endif;?>