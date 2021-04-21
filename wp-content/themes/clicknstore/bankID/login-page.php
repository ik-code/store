<?php 
$personal_number = $_COOKIE['BankID'] ? $_COOKIE['BankID'] : '';
?>
<h2 class="booking__title page-title">Logga in med BankID</h2>
<form class="booking__form booking__form--show" action="<?php echo $_SERVER['REQUEST_URI']; ?>" data-tab-form="1" method="post">
    <div class="booking__input-wrapper">
        <input class="booking__input bank-id" type="text" name="personal_number" value="<?php echo $personal_number; ?>" placeholder="ÅÅÅÅMMDD-NNNN" required>
    </div>
    <input type="submit" name="submit" class="booking__button btn btn--black" value="Fortsätt">
</form>
<p class="booking__reference">Har du inte Mobilt BankID? <a href="https://support.bankid.com/sv/bestalla-bankid/bestalla-mobilt-bankid">Klicka här</a></p>

