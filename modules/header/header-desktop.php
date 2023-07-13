<?php
    $inicioActive = '';
    $productosActive = '';
    $empresaActive = '';
    $blogActive = '';
    $contactoActive = '';
    $puntoventaActive = '';
    
    if(  isset($_GET['module']) && $_GET['module'] == "modules/puntoVenta/punto-venta.php" ){
        $puntoventaActive = 'active';
    }else if(  isset($_GET['module']) && $_GET['module'] == "modules/compania/compania.php" ){
        $empresaActive = 'active';
    }else if(  isset($_GET['module']) && $_GET['module'] == "modules/contacto/contacto.php" ){
        $contactoActive = 'active';
    }else if(  isset($_GET['module']) && (strpos($_GET['module'], "accesorios/") != false) ){
        $productosActive = 'active';
    }else if(  isset($_GET['module']) && (strpos($_GET['module'], "productos/") != false) ){
        $productosActive = 'active';
    }else{
        $inicioActive = 'active';
    }
        
?>

<header class="header" id="header">
    <div class="header-top">
        <div class="inner">
            <div class="logo">
                <a href="<?=$base . $idioma;?>" title="Inicio" rel="home" class="header__logo" id="logo">
                    <img src="assets/images/logo.png" alt="Recambios para tractores - Repuestos Fuster" title="Recambios para tractores - Repuestos Fuster" class="header__logo-image" />
                </a>
            </div>
            <div class="contacto-header">
                <div class="logos-rrss-header">
                    
                    <a href="<?=$idioma;?>/acceso/" class="acceso" style="display:none;"><?=${"lang_".$idioma}['accesoPriv'];?><img src="assets/images/acceso.svg"></a>
                    <a href="<?=$idioma;?>/carrito/" class="carritoHeader" style="margin-right: 25px;display:none;">
                        <img src="assets/images/carrito_bold.svg" style='margin-left: 6px;width: 21px;'>
                        <span class='cantProdCart' style="position: absolute;background-color: #f26440;border-radius: 18px;padding: 0px 5px;color: #fff;top: -4px;margin-left: -13px;font-size: 12px;">0</span>
                    </a>
                    <a href="<?=$idioma;?>/perfil/" class="perfil" style="display:none;"><span class='nombreUser'></span><img src="assets/images/user.svg" style='margin-left: 6px;width: 21px;'></a>
                </div>
                <div class="contact-header">
                    <div class='contenedorIcons'>
                            <div>
                                <div class="whatsapp-wrapper">
                                    <img class="header-icon fuster-icon-whatsapp" alt="+34 669 105 394" title="+34 669 105 394" src="assets/icons/whatsapp.png" width="40" height="40" /><a title="+34 669 105 394">+34 669 105 394</a>
                                </div>
                                <div class="phone-wrapper">
                                    <img class="header-icon fuster-icon-phone" alt="+34 976 77 07 96" title="+34 976 77 07 96" src="assets/icons/contact.png" width="40" height="40" /><a title="+34 976 77 07 96">+34 976 77 07 96</a>
                                </div>
                            </div>
                            <div class="mail-wrapper">
                                <img class="header-icon fuster-icon-mail" alt="mail icon" title="mail icon" src="assets/icons/message.png" width="40" height="40" />
                                <a class="mail-image" href="mailto:fuster@repuestosfuster.com" title="">fuster@repuestosfuster.com</a>
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="inner">
            <div class="menu_bar">
                <div class="bt-menu" href="#"><span class="icon-list2"></span></div>
            </div>
            <nav class="header__secondary-menu" id="main-menu" style="top: -100%;">
                <ul style='text-transform: uppercase;'>
                    <li>
                        <a class='<?=$inicioActive;?>' href="<?=$idioma;?>/<?=${"lang_".$idioma}['inicio']['url'];?>/" data-lang-es='<?=$lang_es['inicio']['url'];?>/' data-lang-en='<?=$lang_en['inicio']['url'];?>/' data-lang-fr='<?=$lang_fr['inicio']['url'];?>/' title="<?=${"lang_".$idioma}['inicio']['title'];?>"><?=${"lang_".$idioma}['inicio']['title'];?></a>
                    </li>
                    <li>
                        <a class='<?=$productosActive;?>' href="<?=$idioma;?>/<?=${"lang_".$idioma}['productos']['url'];?>/" data-lang-es='<?=$lang_es['productos']['url'];?>/' data-lang-en='<?=$lang_en['productos']['url'];?>/' data-lang-fr='<?=$lang_fr['productos']['url'];?>/' title="<?=${"lang_".$idioma}['productos']['title'];?>"><?=${"lang_".$idioma}['productos']['title'];?></a>
                    </li>
                    <li>
                        <a class='<?=$empresaActive;?>' href="<?=$idioma;?>/<?=${"lang_".$idioma}['empresa']['url'];?>/" data-lang-es='<?=$lang_es['empresa']['url'];?>/' data-lang-en='<?=$lang_en['empresa']['url'];?>/' data-lang-fr='<?=$lang_fr['empresa']['url'];?>/' title="<?=${"lang_".$idioma}['empresa']['title'];?>"><?=${"lang_".$idioma}['empresa']['title'];?></a>
                    </li>
                    <?php if($idioma != 'fr'){ ?>
                    <li>
                        <a class='<?=$puntoventaActive;?>' href="<?=$idioma;?>/<?=${"lang_".$idioma}['puntodeventa']['url'];?>/" data-lang-es='<?=$lang_es['puntodeventa']['url'];?>/'  data-lang-fr='<?=$lang_fr['puntodeventa']['url'];?>/' data-lang-en='<?=$lang_en['puntodeventa']['url'];?>/' title="<?=${"lang_".$idioma}['puntodeventa']['title'];?>"><?=${"lang_".$idioma}['puntodeventa']['title'];?></a>
                    </li>
                    
                    <li>
                        <a href="<?=$base;?>blog/" title="<?=${"lang_".$idioma}['blog']['title'];?>"><?=${"lang_".$idioma}['blog']['title'];?></a>
                    </li>
                    <?php } ?>
                    <li>
                        <a class='<?=$contactoActive;?>' href="<?=$idioma;?>/<?=${"lang_".$idioma}['contacto']['url'];?>/" data-lang-es='<?=$lang_es['contacto']['url'];?>/' data-lang-fr='<?=$lang_fr['contacto']['url'];?>/' data-lang-en='<?=$lang_en['contacto']['url'];?>/' title="<?=${"lang_".$idioma}['contacto']['title'];?>"><?=${"lang_".$idioma}['contacto']['title'];?></a>
                    </li>
                </ul>
            </nav>
            <div class="header__region region region-header">
                <div id="block-locale-language" class="block block-locale first last odd" role="complementary">
                    <ul class="language-switcher-locale-url">
                        <?php if($idioma != 'fr'){ ?>
                            <li <?php $show = ($idioma=='en') ? 'class="active"' : ''; echo $show; ?>><a id='btnLangEn' href="en/home/" class="language-link">EN</a></li>
                            <li <?php $show = ($idioma=='es') ? 'class="active"' : ''; echo $show; ?>><a id='btnLangEs' href="es/inicio/" class="language-link">ES</a></li>
                            <li <?php $show = ($idioma=='fr') ? 'class="active"' : ''; echo $show; ?>><a id='btnLangFr' href="https://www.repuestosfuster.fr/accueil/" class="language-link">FR</a></li>
                        <?php } ?>

                        <?php if($idioma == 'fr'){ ?>
                            <li <?php $show = ($idioma=='en') ? 'class="active"' : ''; echo $show; ?>><a id='btnLangEn' d href="http://www.fusterrepuestos.local/en/home/" class="language-link">EN</a></li>
                            <li <?php $show = ($idioma=='es') ? 'class="active"' : ''; echo $show; ?>><a id='btnLangEs' f href="http://www.fusterrepuestos.local/es/inicio/" class="language-link">ES</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
