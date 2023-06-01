<?php
$PageTitle = 'About';
require "../templates/header.php";
require "../templates/nav.php";
include_once "../templates/alert.php";
?>

<section class="container">
    <h1>Learn a little more about us</h1>
    <p>We are the <b>#1</b> selling website in Canada for the shoe industry.</p>
    <br>
    <table class="table">
        <tbody>
            <tr class="table-active">
                <th scope="col"></th>
                <td>We sold over 250 000 shoes last years wich makes us #1 in sales and reputation.</td>
            </tr>
            <tr class="table-active">
                <th scope="col"></th>
                <td>So if you're looking for a place to buy some nice kicks, search no further, we have everything.</td>
            </tr>
        </tbody>
    </table>
    <br>


    <h4>Leading more shoes into people's feet.</h4>
    <ul>
        <li>We give 5% of our profits to organizations that help the people in need.</li>
        <li>Shoes Pro Shop is not only a market place for nice shoes, it's also a way to give back to your community.</li>
    </ul>
    <br>

    <h1>Find Us</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Address</th>
                <th>City</th>
                <th>Province</th>
                <th>Country</th>
                <th>Postal Code</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>180 Rue Dorval</td>
                <td>L'Assomption</td>
                <td>QC</td>
                <td>CA</td>
                <td>J5W 6C1</td>
            </tr>
            <tr>
                <td>420 Rue Dorval</td>
                <td>Épiphanie</td>
                <td>QC</td>
                <td>CA</td>
                <td>J5W 5V3</td>
            </tr>
        </tbody>
    </table>
</section>

<?php require_once('../templates/footer.php'); ?>