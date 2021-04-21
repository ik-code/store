<?php 
$personal_number = $_COOKIE['BankID'] ? $_COOKIE['BankID'] : '';
?>
<h2 class="booking__title page-title">Logga in med BankID</h2>
<p class="booking__description description">För att logga in, öppna din BankID-applikation på din dator eller
    mobil och verifiera dig. Har du redan ett konto? <a class="login" href="#">Logga in här!</a></p>
    <div class="booking__nav-tabs">
        <span class="booking__nav-tabs-button booking__nav-tabs-button--active " data-tab-button="1">privatPERSON</span>
        <span class="booking__nav-tabs-button" data-tab-button="2">FÖRETAG</span>
    </div>
    <?php if($error){ ?>
        <div><span class="error-message">En användare med denna information finns redan. <a class="login" href="#"><u>Logga in här!</u></a></span></div>
    <?php } ?>
    <form class="booking__form booking__form--show" action="<?php echo $_SERVER['REQUEST_URI']; ?>" data-tab-form="1" method="post">
        <div class="booking__input-wrapper">
            <input class="booking__input bank-id" type="text" name="personal_number" value="<?php echo $personal_number; ?>" placeholder="ÅÅÅÅMMDD-NNNN" required>
            <!--                     <span class="error-message">Please enter your personal identity number in the format ÅÅÅÅMMDDNNNN</span>-->
        </div>
        <div class="booking__input-wrapper">
            <input class="booking__input number" type="tel" name="phone_number" placeholder="Mobilnummer 07XXXXXXXX" required>
        </div>
        <div class="booking__input-wrapper">
            <input class="booking__input" type="email" name="personal_email" placeholder="E-post" required>
            <!-- <span class="error-message">Please enter a valid e-mail address</span> -->
        </div>
        <input type="submit" name="submit" class="booking__button btn btn--black" value="Fortsätt">
    </form>
    <form class="booking__form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" data-tab-form="2" method="post">
        <div class="booking__input-wrapper">
            <input class="booking__input bank-id" type="text" name="personal_number" value="<?php echo $personal_number; ?>" placeholder="ÅÅÅÅMMDD-NNNN" required>
            <!-- <span class="error-message">Please enter your personal identity number in the format ÅÅÅÅMMDDNNNN</span> -->
        </div>
        <div class="booking__input-wrapper">
            <input class="booking__input phone-number" type="tel" name="phone_number" placeholder="Mobilnummer 07XXXXXXXX" required>
        </div>
        <div class="booking__input-wrapper">
            <input class="booking__input" type="email" name="personal_email" placeholder="E-post" required>
            <!-- <span class="error-message">Please enter a valid e-mail address</span> -->
        </div>
        <div class="booking__input-wrapper">
            <input class="booking__input" type="text" name="company_name" placeholder="Företagsnamn" required>
            <!-- <span class="error-message">This field is required</span> -->
        </div>
        <div class="booking__input-wrapper">
            <input class="booking__input" type="text" name="copnamy_number" placeholder="Organisationsnummer" required>
            <!-- <span class="error-message">This field is required</span> -->
        </div>
        <input type="submit" name="submit" class="booking__button btn btn--black" value="Fortsätt">
    </form>
    <p class="booking__reference">Har du inte Mobilt BankID? <a href="https://support.bankid.com/sv/bestalla-bankid/bestalla-mobilt-bankid">Klicka här</a></p>

