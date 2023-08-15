<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function check(string $credit2, string $credittype2) {
    if (is_numeric($credit2) && strlen($credit2) !== 16) {
        return false;
    }
    
    if ($credittype2 == "Visa" && substr($credit2, 0, 1) !== '4') {
        return false;
    }
    
    if ($credittype2 == "Mastercard" && substr($credit2, 0, 1) !== '5') {
        return false;
    }
    
    return true;
}

if (
    isset($_POST['name']) && $_POST['name'] !== "" &&
    $_POST['section'] !== "default" &&
    isset($_POST['credit']) && $_POST['credit'] !== "" &&
    isset($_POST['credittype'])
) {
    if (check($_POST['credit'], $_POST['credittype'])) {
        $info = $_POST['name'] . " ; " . $_POST["credit"] . " ; " . $_POST["credittype"] . "\n";
        if (file_put_contents("dopayment.txt", $info, FILE_APPEND) !== false) {
            $successMessage = "Your information has been recorded. R.I.P your Card!";
        } else {
            $errorMessage = "Error saving data.";
        }
    } else {
        $errorMessage = "You didn't provide a valid card number.";
    }
} else {
    $errorMessage = "You didn't fill out the form completely.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Here is your information</title>
    <link href="payment_files/payment.css" type="text/css" rel="stylesheet" />
</head>

<body>
<?php if (isset($successMessage)) : ?>
    <h1>Thanks, victim!</h1>
    <p><?= $successMessage ?></p>

    <dl>
        <dt>Name</dt>
        <dd><?= htmlspecialchars($_POST['name']); ?></dd>

        <dt>Section</dt>
        <dd><?= htmlspecialchars($_POST['section']); ?></dd>

        <dt>Credit Card</dt>
        <dd><?= htmlspecialchars($_POST['credit']); ?></dd>
    </dl>
    <pre><?= htmlspecialchars(file_get_contents("dopayment.txt")); ?></pre>
<?php elseif (isset($errorMessage)) : ?>
    <h1>Sorry</h1>
    <p><?= $errorMessage ?></p>
    <a href="payment.php">Try again?</a>
<?php endif; ?>
</body>
</html>
