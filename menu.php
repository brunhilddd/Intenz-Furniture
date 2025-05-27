<?php
$message = ""; // Initialize an empty message variable
$koneksi = new mysqli("localhost", "root", "", "dim");

if (isset($_POST["submit"])) {
    $firstName = $_POST["newFirstName"];
    $lastName = $_POST["newLastName"];
    $email = $_POST["newEmail"];
    $phone = $_POST["newPhone"];
    $city = $_POST["newCity"];
    $streetname = $_POST["newStreetHome"];
    $postcode = $_POST["newPostCode"];
    $housenumber = $_POST["newHouseNumber"];


    if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($phone) && !empty($city) && !empty($streetname) && !empty($postcode) && !empty($housenumber)) {
        $link = mysqli_connect("localhost", "root", "", "dim");
        if ($link == false) {
            die(mysqli_connect_error());
        }
        $sql = "INSERT INTO customers (FirstName, LastName, Email, Phone, City, StreetName, PostCode, HouseNumber) VALUES ('$firstName', '$lastName', '$email', '$phone', '$city', '$streetname', '$postcode', '$housenumber')";
        if (mysqli_query($link, $sql)) {
            $message = "Record inserted successfully";
        } else {
            $message = "Something went wrong";
        }

        mysqli_close($link);
    } else {
        $message = "Please provide all information";
    }
}

if (isset($_POST["submitNewStock"])) {
    $materialName = $_POST["materialName"];
    $materialQuantity = $_POST["materialQuantity"];

    if (!empty($materialName) && !empty($materialQuantity)) {
        // Connect to the database
        $link = mysqli_connect("localhost", "root", "", "dim");
        if ($link == false) {
            die(mysqli_connect_error());
        }

        // Insert data into the 'stock' table
        $sql = "INSERT INTO stocks (MaterialName, Quantity) VALUES ('$materialName', '$materialQuantity')";
        if (mysqli_query($link, $sql)) {
            $message = "Stock record inserted successfully";
        } else {
            $message = "Something went wrong";
        }

        mysqli_close($link);
    } else {
        $message = "Please provide all information for new stock";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #FFF8F0;
        }

        .table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .table td,
        .table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tr:hover {
            background-color: #ddd;
        }

        .table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #9e836a;
            color: white;
        }

        .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            background-color: #9E836A;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        #mainContent>div {
            display: none;
        }

        h1 {
            display: block;
            align-items: center;
            text-align: center;
            color: #FFF8F0;
            margin-bottom: 20px;
        }

        .logout-box {
            position: fixed;
            bottom: 20px;
            left: 20px;
            padding: 10px;
            background-color: #FFF8F0;
            color: #9E836A;
            border: 2px solid #9E836A;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            display: flex;
            align-items: center;
        }

        .logout-box i {
            margin-right: 10px;
        }

        .logout-box:hover {
            background-color: #9E836A;
            color: #FFF8F0;
        }

        .sidebar a {
            padding: 30px;
            text-align: center;
            text-decoration: none;
            font-size: 18px;
            color: #FFF8F0;
            display: block;
            transition: color 0.3s;
            font-weight: bold;
        }

        .sidebar a:hover {
            background-color: #FFF8F0;
            color: black;
            border-radius: 5px;
            font-size: 16px;
            padding: 20px;
            margin: 0 10px;
        }

        .content {
            margin-left: 250px;
            padding: 16px;
        }

        .overview-box {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            margin: 20px;
        }

        .overview-item {
            flex: 1;
            padding: 20px;
            background-color: #ECD3B5;
            color: #FFF8F0;
            border-radius: 5px;
            text-align: center;
            position: relative;
        }

        .overview-item img {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }

        .overview-label {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            color: #FFF8F0;
            font-size: 14px;
        }


        .current-stock {
            order: 1;
            margin-right: 10px;
        }

        .available-material {
            order: 2;
            margin-right: 10px;
        }

        .category {
            order: 3;
        }


        .available-material-box {
            padding: 20px;
            background-color: #ECD3B5;
            color: #FFF8F0;
            border-radius: 5px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px;
        }

        .available-material-box img {
            width: 100px;
            height: auto;
            margin-bottom: 10px;

        }

        /* CARD */
        .card {
            background: #ECD3B5;
            width: 200px;
            padding: 20px;
            border-radius: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            /* Align text to the left */
            align-items: flex-start;
            /* Align text to the left */
        }

        .daftar-card {
            display: flex;
            justify-content: left;
            align-items: center;
            gap: 40px;
        }

        .new-customer,
        .delete {
            flex: 1;
            margin: 0 10px;
        }

        .new-customer,
        .delete {
            background-color: #9E836A;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            margin: 20px;
        }

        .new-customer h2,
        .delete h2 {
            color: #FFF8F0;
            margin-bottom: 10px;
        }

        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background: #FFF8F0;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
        }

        .customer-box {
            flex: 1;
            padding: 20px;
            background-color: #ECD3B5;
            color: #FFF8F0;
            border-radius: 5px;
            text-align: center;
            margin-right: 10px;
        }

        .new-customer,
        .delete {
            flex: 1;
            margin: 0 10px;
            background-color: #9E836A;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            margin: 20px;
            color: #FFF8F0;
        }

        .detail-category-content {
            display: flex;
            margin: 20px;
        }

        .category-box img {
            width: 100%;
            max-height: 100px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .new-customer,
        .delete {
            flex: 1;
            margin: 0 10px;
            font-size: 12px;
            background-color: #9E836A;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            width: 128px;
            height: 48px;
            color: #FFF8F0;

            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: -32px;
            cursor: pointer;
        }

        /* /FATE EDIT/ */
        #overviewContent {
            display: flex;
            flex-direction: column;
            gap: 3rem;
            height: 100vh;
            padding: 0.5rem 0;
        }

        #overviewContent h1 {
            font-weight: 800;
            color: black;
            text-align: left;
        }

        #overviewContent section {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12rem;
        }

        .customer-detail-content {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 48px;

        }

        .customer-detail {
            flex: 1;
            padding: 20px;
            background-color: #ECD3B5;
            color: black;
            border-radius: 24px;
            text-align: center;
            margin-right: 10px;
            box-shadow: 0px 4px 15px 0px rgba(0, 0, 0, 0.15);
            height: 320px;
        }

        #detailStockContent {
            display: flex;
            flex-direction: column;
            gap: 3rem;
            height: 100vh;
            padding: 0.5rem 0;
        }

        #detailStockContent h2 {
            font-weight: 800;
            color: black;
            text-align: left;
        }

        #detailStockContent section {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12rem;
        }

        .stock-detail-content {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 48px;

        }

        .currentStock {
            flex: 1;
            padding: 20px;
            background-color: #ECD3B5;
            color: black;
            border-radius: 24px;
            text-align: center;
            margin-right: 10px;
            box-shadow: 0px 4px 15px 0px rgba(0, 0, 0, 0.15);
            height: 320px;
        }

        .box {
            flex: 1;
            padding: 20px;
            background-color: #ECD3B5;
            color: #FFF8F0;
            border-radius: 20px;
            text-align: left;
            margin-right: 10px;
            box-shadow: 0px 4px 15px 0px rgba(0, 0, 0, 0.15);
            height: 320px;
        }

        #detailMaterialContent {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            /* 100% tinggi viewport */
        }

        .material-content {
            text-align: center;
            max-width: 600px;
            /* Sesuaikan lebar maksimal sesuai keinginan Anda */
            margin: auto;
            /* Center horizontally */
        }

        .material-images {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .material-item {
            flex: 1;
            text-align: center;
            margin: 0 10px;
            /* Tambahkan jarak antar gambar di sini */
        }

        .material-item img {
            width: 100px;
            /* Sesuaikan ukuran gambar */
            height: auto;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .image-name {
            margin-top: 5px;
            font-size: 12px;
            /* Sesuaikan ukuran font nama */
        }

        .bottom-box {
            text-align: center;
        }

        .material-images {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .material-images img {
            width: 100px;
            /* Ubah ukuran sesuai kebutuhan */
            height: auto;
            border: 1px solid #ccc;
            /* Tambahkan border jika diinginkan */
            border-radius: 5px;
        }

        .bottom-box {
            margin-top: 20px;
            padding: 10px;
            background-color: #ECD3B5;
            border-radius: 5px;
            text-align: center;
        }

        .material-item {
            text-align: center;
        }

        .material-item img {
            width: 100px;
            /* Sesuaikan ukuran gambar */
            height: auto;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .image-name {
            margin-top: 5px;
            font-size: 12px;
            /* Sesuaikan ukuran font nama */
        }

        /* Add this style to your existing CSS */
        #category-content {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px;
        }

        .category-item {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .image-text {
            margin-top: 10px;
            font-size: 24px;
            font-weight: 600;
            color: #333;
        }

        .square {
            justify-content: center;
            align-items: center;
            overflow: hidden;
            border-radius: 32px;
        }

        .square img {
            height: 500px;
        }

        .kontainer,
        .kontainer-jarak,
        .kontainer-xxl {
            width: 100%;
            padding-right: var(--bs-gutter-x, .75rem);
            padding-left: var(--bs-gutter-x, .75rem);
            margin-right: auto;
            margin-left: auto
        }

        @media (min-width:576px) {
            .kontainer {
                max-width: 540px
            }
        }

        @media (min-width:768px) {
            .kontainer {
                max-width: 720px
            }
        }

        @media (min-width:992px) {
            .kontainer {
                max-width: 960px
            }
        }

        @media (min-width:1200px) {
            .kontainer {
                max-width: 1140px
            }
        }

        @media (min-width:1400px) {

            .kontainer,
            .kontainer-xxl {
                max-width: 1320px
            }
        }

        .baris {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: wrap;
            margin-top: calc(var(--bs-gutter-y) * -1);
            margin-right: calc(var(--bs-gutter-x)/ -2);
            margin-left: calc(var(--bs-gutter-x)/ -2)
        }

        .baris>* {
            flex-shrink: 0;
            width: 100%;
            max-width: 100%;
            padding-right: calc(var(--bs-gutter-x)/ 2);
            padding-left: calc(var(--bs-gutter-x)/ 2);
            margin-top: var(--bs-gutter-y)
        }

        .kolom-2 {
            flex: 0 0 auto;
            width: 16.66667%
        }

        .kolom-3 {
            flex: 0 0 auto;
            width: 25%
        }

        .kolom-4 {
            flex: 0 0 auto;
            width: 33.33333%
        }

        .kolom-8 {
            flex: 0 0 auto;
            width: 66.66667%
        }

        .kolom-9 {
            flex: 0 0 auto;
            width: 75%
        }

        .kolom-10 {
            flex: 0 0 auto;
            width: 83.33333%
        }

        .g-4 {
            --bs-gutter-x: 1.5rem
        }

        .g-4 {
            --bs-gutter-y: 1.5rem
        }

        .g-5 {
            --bs-gutter-x: 3rem
        }

        .g-5 {
            --bs-gutter-y: 3rem
        }

        @media (min-width:768px) {
            .kolom-sedang-2 {
                flex: 0 0 auto;
                width: 16.66667%
            }

            .kolom-sedang-3 {
                flex: 0 0 auto;
                width: 22%
            }

            .kolom-sedang-4 {
                flex: 0 0 auto;
                width: 30.33333%
            }

            .kolom-sedang-5 {
                flex: 0 0 auto;
                width: 41.66667%
            }

            .kolom-sedang-6 {
                flex: 0 0 auto;
                width: 40%
            }

            .kolom-sedang-7 {
                flex: 0 0 auto;
                width: 58.33333%
            }

            .kolom-sedang-8 {
                flex: 0 0 auto;
                width: 66.66667%
            }

            .kolom-sedang-9 {
                flex: 0 0 auto;
                width: 75%
            }

            .kolom-sedang-10 {
                flex: 0 0 auto;
                width: 83.33333%
            }

            .kolom-sedang-12 {
                flex: 0 0 auto;
                width: 100%
            }
        }

        @media (min-width:992px) {
            .kolom-besar-8 {
                flex: 0 0 auto;
                width: 66.66667%
            }
        }

        .form-control {
            display: block;
            width: 100%;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #525368;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            appearance: none;
            border-radius: 4px;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out
        }

        @media (prefers-reduced-motion:reduce) {
            .form-control {
                transition: none
            }
        }

        .form-control[type=file]:not(:disabled):not(:read-only) {
            cursor: pointer
        }

        .form-control:focus {
            color: #525368;
            background-color: #fff;
            border-color: #9ac79c;
            outline: 0;
            box-shadow: 0 0 0 .25rem rgba(52, 142, 56, .25)
        }

        .form-control::-webkit-date-and-time-value {
            height: 1.5em
        }

        .form-control:disabled {
            background-color: #e9ecef;
            opacity: 1
        }

        .form-control::file-selector-button {
            padding: .375rem .75rem;
            margin: -.375rem -.75rem;
            margin-inline-end: .75rem;
            color: #525368;
            background-color: #e9ecef;
            pointer-events: none;
            border-color: inherit;
            border-style: solid;
            border-width: 0;
            border-inline-end-width: 1px;
            border-radius: 0;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out
        }

        @media (prefers-reduced-motion:reduce) {
            .form-control::file-selector-button {
                transition: none
            }
        }

        .form-control:hover:not(:disabled):not(:read-only)::file-selector-button {
            background-color: #dde0e3
        }

        .form-control::-webkit-file-upload-button {
            padding: .375rem .75rem;
            margin: -.375rem -.75rem;
            margin-inline-end: .75rem;
            color: #525368;
            background-color: #e9ecef;
            pointer-events: none;
            border-color: inherit;
            border-style: solid;
            border-width: 0;
            border-inline-end-width: 1px;
            border-radius: 0;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out
        }

        @media (prefers-reduced-motion:reduce) {
            .form-control::-webkit-file-upload-button {
                transition: none
            }
        }

        .form-control:hover:not(:disabled):not(:read-only)::-webkit-file-upload-button {
            background-color: #dde0e3
        }

        .form-control-sm::file-selector-button {
            padding: .25rem .5rem;
            margin: -.25rem -.5rem;
            margin-inline-end: .5rem
        }

        .form-control-lg::file-selector-button {
            padding: .5rem 1rem;
            margin: -.5rem -1rem;
            margin-inline-end: 1rem
        }

        .form-control-color:not(:disabled):not(:read-only) {
            cursor: pointer
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            line-height: 1.5;
            color: #525368;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            border-radius: 4px;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        @media (prefers-reduced-motion:reduce) {
            .btn {
                transition: none
            }
        }

        .btn:hover {
            color: #525368
        }

        .btn:focus {
            outline: 0;
            box-shadow: 0 0 0 .25rem rgba(52, 142, 56, .25)
        }

        .btn:disabled {
            pointer-events: none;
            opacity: .65
        }

        .btn-abu {
            color: #000;
            background-color: #c7c7c7;
            border-color: #c7c7c7
        }

        .btn-abu:hover {
            color: #000;
            background-color: #ebf7ec;
            border-color: #eaf6eb
        }

        .btn-cokelat {
            color: white !important;
            background-color: #9E836A;
            border-color: #9E836A;
            margin: 10px !important;

        }

        .btn-cokelat:hover {
            color: white !important;
            background-color: #f9c407;
            border-color: #f9c407;
            margin: 10px !important;
        }

        .btn-light {
            color: #000;
            background-color: #e8f5e9;
            border-color: #e8f5e9
        }

        .btn-light:hover {
            color: #000;
            background-color: #ebf7ec;
            border-color: #eaf6eb
        }

        .btn-putih {
            color: black;
            background-color: #ffffff;
            border-color: #ffffff
        }

        .btn-putih:hover {
            color: black;
            background-color: #c5c5c5;
            border-color: #c5c5c5
        }

        .btn-hitam {
            color: white;
            background-color: #323232;
            border-color: #323232
        }

        .btn-hitam:hover {
            color: white;
            background-color: #000000;
            border-color: #000000
        }

        .btn-light:focus {
            color: #000;
            background-color: #ebf7ec;
            border-color: #eaf6eb;
            box-shadow: 0 0 0 .25rem rgba(197, 208, 198, .5)
        }

        .btn-light:active {
            color: #000;
            background-color: #edf7ed;
            border-color: #eaf6eb
        }

        .btn-light:active:focus {
            box-shadow: 0 0 0 .25rem rgba(197, 208, 198, .5)
        }

        .btn-light:disabled {
            color: #000;
            background-color: #e8f5e9;
            border-color: #e8f5e9
        }

        .tombol-hitam {
            color: #fff;
            background-color: #000;
            border-color: #000
        }

        .tombol-hitam:hover {
            color: #fff;
            background-color: #161616;
            border-color: #161616
        }

        .tombol-hitam:focus {
            color: #fff;
            background-color: #0d3823;
            border-color: #0c3521;
            box-shadow: 0 0 0 .25rem rgba(51, 94, 73, .5)
        }

        .tombol-hitam:active {
            color: #fff;
            background-color: #0c3521;
            border-color: #0b321f
        }

        .tombol-hitam:active:focus {
            box-shadow: 0 0 0 .25rem rgba(51, 94, 73, .5)
        }

        .tombol-hitam:disabled {
            color: #fff;
            background-color: #122c3d;
            border-color: #122c3d
        }

        .btn-cokelat {
            color: #000;
            background-color: #9E836A;
            border-color: #9E836A
        }

        .btn-cokelat:hover {
            color: #000;
            background-color: #f9c407;
            border-color: #f9c407;
        }


        .btn-outline-light {
            color: #e8f5e9;
            border-color: #e8f5e9
        }

        .btn-outline-light:hover {
            color: #000;
            background-color: #e8f5e9;
            border-color: #e8f5e9
        }

        .btn-outline-light:focus {
            box-shadow: 0 0 0 .25rem rgba(232, 245, 233, .5)
        }

        .btn-outline-light:active {
            color: #000;
            background-color: #e8f5e9;
            border-color: #e8f5e9
        }

        .btn-outline-light:active:focus {
            box-shadow: 0 0 0 .25rem rgba(232, 245, 233, .5)
        }

        .btn-outline-light:disabled {
            color: #e8f5e9;
            background-color: transparent
        }

        .btn-outline-dark {
            color: #122c3d;
            border-color: #122c3d
        }

        .btn-outline-dark:hover {
            color: #fff;
            background-color: #122c3d;
            border-color: #122c3d
        }

        .btn-outline-dark:focus {
            box-shadow: 0 0 0 .25rem rgba(15, 66, 41, .5)
        }

        .btn-outline-dark:active {
            color: #fff;
            background-color: #122c3d;
            border-color: #122c3d
        }

        .btn-outline-dark:active:focus {
            box-shadow: 0 0 0 .25rem rgba(15, 66, 41, .5)
        }

        .btn-outline-dark:disabled {
            color: #122c3d;
            background-color: transparent
        }

        .btn-lg {
            padding: .5rem 1rem;
            font-size: 1.25rem;
            border-radius: 4px
        }

        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h1>Intenz</h1>
        <a href="#" data-content="overview" onclick="loadContent('overview')">Customer Detail</a>
        <a href="#" data-content="detailStock" onclick="loadContent('detailStock')">Detail Stock</a>
        <a href="#" data-content="detailMaterial" onclick="loadContent('detailMaterial')">Detail Material</a>
        <a href="#" data-content="category-content" onclick="loadContent('category-content')">Category</a>
        <a href="#" data-content="finance" onclick="loadContent('finance')">Finance</a>

    </div>

    <div class="content" id="mainContent">
        <div id="overviewContent" hidden>
            <h1>Customer Info</h1>
            <section>
                <div class="customer-info">
                    <div class="customer-detail-content">
                        <div class="customer-detail">
                            <h2>Customer Detail</h2>
                        </div>
                        <div class="customer-detail">
                            <h2>Customer Detail</h2>
                        </div>
                    </div>
                </div>
                <div class="customer-button">
                    <div class="new-customer" onclick="openCustomerPopup()">
                        <h2>New Customer</h2>
                        <p>Add new customer content here.</p>
                    </div>
                    <div class="delete">
                        <h2>Delete</h2>
                        <p>Delete customer content here.</p>
                    </div>
                </div>
            </section>
        </div>

        <div id="newCustomerPopup" class="popup">
            <div class="popup-content">
                <span class="close" onclick="closeCustomerPopup()">&times;</span>
                <h2>New Customer Form</h2>
                <form id="newCustomerForm" action="menu.php" method="post">
                    <div class="form-group">
                        <label for="newFirstName">First Name:</label>
                        <input type="text" id="newFirstName" name="newFirstName" required>
                    </div>

                    <div class="form-group">
                        <label for="newLastName">Last Name:</label>
                        <input type="text" id="newLastName" name="newLastName" required>
                    </div>

                    <div class="form-group">
                        <label for="newEmail">Email:</label>
                        <input type="email" id="newEmail" name="newEmail" required>
                    </div>

                    <div class="form-group">
                        <label for="newPhone">Phone:</label>
                        <input type="tel" id="newPhone" name="newPhone" required>
                    </div>

                    <div class="form-group">
                        <label for="newCity">City:</label>
                        <input type="text" id="newCity" name="newCity" required>
                    </div>

                    <div class="form-group">
                        <label for="newStreetHome">Street Home:</label>
                        <input type="text" id="newStreetHome" name="newStreetHome" required>
                    </div>

                    <div class="form-group">
                        <label for="newPostCode">Postal Code:</label>
                        <input type="text" id="newPostCode" name="newPostCode" required>
                    </div>

                    <div class="form-group">
                        <label for="newHouseNumber">House Number:</label>
                        <input type="text" id="newHouseNumber" name="newHouseNumber" required>
                    </div>


                    <button type="submit" name="submit">Add Customer</button>

                </form>

            </div>
        </div>

        <!-- Detail Stock Content -->
        <div id="detailStockContent" hidden>
            <h2>Detail Stock Content</h2>
            <section>
                <div class="stock-info">
                    <div class="stock-detail-content">
                        <div class="currentStock box">
                            <h2>Current Stock</h2>

                        </div>
                        <div class="availableMaterial box">
                            <h2>Available Material</h2>

                        </div>
                        <div class="newStock box" onclick="openNewStockPopup()">
                            <h2>New Stock</h2>

                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Popup for new Stock -->
        <div id="newStockPopup" class="popup">
            <div class="popup-content">
                <span class="close" onclick="closeNewStockPopup()">&times;</span>
                <h2>New Stock Form</h2>
                <form id="newStockForm" action="menu.php" method="post">
                    <div class="form-group">
                        <label for="materialName">Material Name:</label>
                        <input type="text" id="materialName" name="materialName" required>
                    </div>

                    <div class="form-group">
                        <label for="materialQuantity">Material Quantity:</label>
                        <input type="number" id="materialQuantity" name="materialQuantity" required>
                    </div>
                    <br>
                    <button type="submit" name="submitNewStock">Add Stock</button>
                </form>
            </div>
        </div>



        <!-- Detail Material Content -->
        <div id="detailMaterialContent" hidden>
            <div class="material-content">
                <!-- 4 gambar kecil -->
                <!-- <div class="material-images">
                    <div class="material-item">
                        <img src="wood.jpeg" alt="Image 1">
                        <p class="image-name">Kayu</p>
                    </div>
                    <div class="material-item">
                        <img src="besi.jpeg" alt="Image 2">
                        <p class="image-name">Besi</p>
                    </div>
                    <div class="material-item">
                        <img src="titanium.jpeg" alt="Image 3">
                        <p class="image-name">Titanium</p>
                    </div>
                    <div class="material-item">
                        <img src="pasir.jpeg" alt="Image 4">
                        <p class="image-name">Pasir</p>
                    </div>

                </div> -->
                <?php
                $ambilmaterials = $koneksi->query("SELECT * FROM materials");
                $cekmaterials = $ambilmaterials->num_rows;
                if ($cekmaterials == 0) {
                ?>
                    <div class="baris" style="padding-top:100px">
                        <div class="kolom-sedang-12">
                            <img src="foto/kosong.png" width="200px">
                        </div>
                    </div>
                <?php } else { ?>
                    <div style="padding:100px">
                        <div class="baris">
                            <?php
                            // Fetch materials from the database and display them
                            $link = mysqli_connect("localhost", "root", "", "dim");
                            if ($link == false) {
                                die(mysqli_connect_error());
                            }

                            $result = mysqli_query($link, "SELECT * FROM materials");

                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <div class="kolom-sedang-6">
                                    <!-- Display material name -->
                                    <center>
                                        <img src="foto/<?= $row['foto'] ?>" width="100%" style="height: 150px !important;object-fit:cover">
                                        <h3 class="image-name"><?php echo $row['MaterialName']; ?></h3>
                                        <!-- Buttons for edit and delete -->
                                        <button class="btn btn-cokelat" onclick="openUpdateMaterialPopup(<?php echo $row['MaterialID']; ?>, '<?php echo $row['MaterialName']; ?>')">Edit</button>
                                        <form method="post">
                                            <input type="hidden" name="materialID" value="<?php echo $row['MaterialID']; ?>">
                                            <button type="submit" class="btn btn-cokelat" name="deleteMaterial" onclick="return confirm('Are you sure you want to delete this material?')">Delete</button>
                                        </form>
                                    </center>
                                </div>
                            <?php
                            }

                            mysqli_close($link);
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <!-- Kotak kata dengan tombol popup -->
                <!-- <div class="bottom-box"> -->
                <button class="btn btn-cokelat" onclick="openMaterialPopup()" style="color:white">New Material</button>
                <!-- </div> -->
            </div>

            <div id="newMaterialPopup" class="popup">
                <div class="popup-content">
                    <span class="close" onclick="closeMaterialPopup()">&times;</span>
                    <h2>New Material Form</h2>
                    <form id="newMaterialForm" action="menu.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="materialName">Material Name:</label>
                            <input type="text" id="materialName" class="form-control" name="materialName" required>
                        </div>
                        <div class="form-group">
                            <label for="materialName">File:</label>
                            <input type="file" id="materialName" class="form-control" name="foto" required>
                        </div>
                        <button type="submit" name="submitNewMaterial" class="btn btn-cokelat">Add Stock</button>
                    </form>
                </div>
            </div>

            <?php
            // Form submission handling
            if (isset($_POST["submitNewMaterial"])) {
                $link = mysqli_connect("localhost", "root", "", "dim");
                if (
                    $link == false
                ) {
                    die(mysqli_connect_error());
                }
                $namafoto = $_FILES['foto']['name'];
                $lokasifoto = $_FILES['foto']['tmp_name'];
                move_uploaded_file($lokasifoto, "foto/$namafoto");
                $materialName = $_POST["materialName"];
                $query = "INSERT INTO materials (MaterialName,foto) VALUES ('$materialName','$namafoto')";

                if (mysqli_query($link, $query)) {
                    echo '<script>alert("Material added successfully!");</script>';
                    // Redirect after displaying the alert
                    echo "<script> location ='menu.php';</script>";
                } else {
                    echo '<script>alert("Error: ' . mysqli_error($link) . '");</script>';
                    // Redirect after displaying the alert
                    echo "<script> location ='menu.php';</script>";
                }
            }
            ?>



            <div id="updateMaterialPopup" class="popup">
                <div class="popup-content">
                    <span class="close" onclick="closeUpdateMaterialPopup()">&times;</span>
                    <h2>Update Material Form</h2>
                    <form id="updateMaterialForm" action="menu.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="updateMaterialID" name="updateMaterialID">
                        <div class="form-group">
                            <label for="updateMaterialName">Material Name:</label>
                            <input type="text" id="updateMaterialName" name="updateMaterialName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="materialName">File:</label>
                            <input type="file" id="materialName" class="form-control" name="foto">
                        </div>
                        <button type="submit" name="submitUpdateMaterial" class="btn btn-cokelat">Update Material</button>
                    </form>
                </div>
            </div>

            <?php
            // Form submission handling for material update
            if (isset($_POST["submitUpdateMaterial"])) {
                $link = mysqli_connect("localhost", "root", "", "dim");
                if ($link == false) {
                    die(mysqli_connect_error());
                }
                $materialID = $_POST["updateMaterialID"];
                $newMaterialName = $_POST["updateMaterialName"];
                $namafoto = $_FILES['foto']['name'];
                $lokasifoto = $_FILES['foto']['tmp_name'];
                if (!empty($lokasifoto)) {
                    move_uploaded_file($lokasifoto, "foto/$namafoto");
                    $query = "UPDATE materials SET MaterialName='$newMaterialName',foto='$namafoto' WHERE MaterialID=$materialID";
                } else {
                    $query = "UPDATE materials SET MaterialName='$newMaterialName' WHERE MaterialID=$materialID";
                }
                if (mysqli_query($link, $query)) {
                    echo '<script>alert("Material updated successfully!");</script>';
                    // Redirect after displaying the alert
                    echo "<script> location ='menu.php';</script>";
                } else {
                    echo '<script>alert("Error: ' . mysqli_error($link) . '");</script>';
                    // Redirect after displaying the alert
                    echo "<script> location ='menu.php';</script>";
                }
            }

            if (isset($_POST["deleteMaterial"])) {
                $materialID = $_POST["materialID"];
                $link = mysqli_connect("localhost", "root", "", "dim");
                if ($link == false) {
                    die(mysqli_connect_error());
                }

                $sql = "DELETE FROM materials WHERE MaterialID=$materialID";
                if (mysqli_query($link, $sql)) {
                    echo '<script>alert("Material deleted successfully!");</script>';
                    // Redirect after displaying the alert
                    echo "<script> location ='menu.php';</script>";
                } else {
                    echo '<script>alert("Error: ' . mysqli_error($link) . '");</script>';
                    // Redirect after displaying the alert
                    echo "<script> location ='menu.php';</script>";
                }

                mysqli_close($link);
            }
            ?>

        </div>

        <!-- Detail Category Content -->
        <div id="category-contentContent" hidden>
            <div class="baris">
                <div class="kolom-sedang-3">
                    <center>
                        <div class="square" onclick="loadContent('detailkategori1')" data-content="detailkategori1">
                            <img src="kitchen.jpeg" width="100%" alt="Category 1">
                        </div>
                        <p class="image-text">Kitchen</p>
                    </center>
                </div>
                <div class="kolom-sedang-3">
                    <center>
                        <div class="square" onclick="loadContent('detailkategori2')" data-content="detailkategori2">
                            <img src="bedroom.jpeg" width="100%" alt="Category 2">
                        </div>
                        <p class="image-text">Bed Room</p>
                    </center>
                </div>
                <div class="kolom-sedang-3">
                    <center>
                        <div class="square" onclick="loadContent('detailkategori3')" data-content="detailkategori3">
                            <img src="wardrobe.jpeg" width="100%" alt="Category 3">
                        </div>
                        <p class="image-text">Wardrobe</p>
                    </center>
                </div>
                <div class="kolom-sedang-3">
                    <center>
                        <div class="square" onclick="loadContent('detailkategori4')" data-content="detailkategori4">
                            <img src="livingroom.jpeg" width="100%" alt="Category 4">
                        </div>
                        <p class="image-text">Livingroom</p>
                    </center>
                </div>
            </div>
            <!-- <button id="toggleCategoryBtn">Toggle Category Content</button> -->

        </div>

        <div id="detailkategori1Content" hidden>
            <h2>Kitchen</h2>
            <div class="baris">
                <div class="kolom-sedang-4">
                    <center>
                        <img src="kitchenwinter.jpg" width="100%" alt="Category 1" style="height: 150px;border-radius:10px">
                        <p class="image-text">Winter Model</p>
                    </center>
                </div>
                <div class="kolom-sedang-4">
                    <center>
                        <img src="kitchendesert.png" width="100%" alt="Category 2" style="height: 150px;border-radius:10px">
                        <p class="image-text">Desert Model</p>
                    </center>
                </div>
                <div class="kolom-sedang-4">
                    <center>
                        <img src="kitchenautumn.jpg" width="100%" alt="Category 3" style="height: 150px;border-radius:10px">
                        <p class="image-text">Autumn Model</p>
                    </center>
                </div>
                <div class="kolom-sedang-4">
                    <center>
                        <img src="kitchendrought.jpg" width="100%" alt="Category 4" style="height: 150px;border-radius:10px">
                        <p class="image-text">Drought Model</p>
                    </center>
                </div>
            </div>
        </div>
        <div id="detailkategori2Content" hidden>
            <h2>Bed Room</h2>
            <div class="baris">
                <div class="kolom-sedang-4">
                    <center>
                        <img src="bedroomwinter.jpg" width="100%" alt="Category 1" style="height: 150px;border-radius:10px">
                        <p class="image-text">Winter Model</p>
                    </center>
                </div>
                <div class="kolom-sedang-4">
                    <center>
                        <img src="bedroomdesert.jpg" width="100%" alt="Category 2" style="height: 150px;border-radius:10px">
                        <p class="image-text">Desert Model</p>
                    </center>
                </div>
                <div class="kolom-sedang-4">
                    <center>
                        <img src="bedroomautumn.jpg" width="100%" alt="Category 3" style="height: 150px;border-radius:10px">
                        <p class="image-text">Autumn Model</p>
                    </center>
                </div>
                <div class="kolom-sedang-4">
                    <center>
                        <img src="bedroomdrought.jpg" width="100%" alt="Category 4" style="height: 150px;border-radius:10px">
                        <p class="image-text">Drought Model</p>
                    </center>
                </div>
            </div>
        </div>
        <div id="detailkategori3Content" hidden>
            <h2>Wardrobe</h2>
            <div class="baris">
                <div class="kolom-sedang-4">
                    <center>
                        <img src="wardrobewinter.jpg" width="100%" alt="Category 1" style="height: 150px;border-radius:10px">
                        <p class="image-text">Winter Model</p>
                    </center>
                </div>
                <div class="kolom-sedang-4">
                    <center>
                        <img src="wardrobedesert.jpg" width="100%" alt="Category 2" style="height: 150px;border-radius:10px">
                        <p class="image-text">Desert Model</p>
                    </center>
                </div>
                <div class="kolom-sedang-4">
                    <center>
                        <img src="wardrobeautumn.jpg" width="100%" alt="Category 3" style="height: 150px;border-radius:10px">
                        <p class="image-text">Autumn Model</p>
                    </center>
                </div>
                <div class="kolom-sedang-4">
                    <center>
                        <img src="wardrobedrought.jpg" width="100%" alt="Category 4" style="height: 150px;border-radius:10px">
                        <p class="image-text">Drought Model</p>
                    </center>
                </div>
            </div>
        </div>
        <div id="detailkategori4Content" hidden>
            <h2>Living Room</h2>
            <div class="baris">
                <div class="kolom-sedang-4">
                    <center>
                        <img src="livingroomwinter.jpg" width="100%" alt="Category 1" style="height: 150px;border-radius:10px">
                        <p class="image-text">Winter Model</p>
                    </center>
                </div>
                <div class="kolom-sedang-4">
                    <center>
                        <img src="livingroomdesert.jpg" width="100%" alt="Category 2" style="height: 150px;border-radius:10px">
                        <p class="image-text">Desert Model</p>
                    </center>
                </div>
                <div class="kolom-sedang-4">
                    <center>
                        <img src="livingroomautumn.jpg" width="100%" alt="Category 3" style="height: 150px;border-radius:10px">
                        <p class="image-text">Autumn Model</p>
                    </center>
                </div>
                <div class="kolom-sedang-4">
                    <center>
                        <img src="livingroomdrought.jpg" width="100%" alt="Category 4" style="height: 150px;border-radius:10px">
                        <p class="image-text">Drought Model</p>
                    </center>
                </div>
            </div>
        </div>
        <!-- Finance Content -->
        <div id="financeContent" style="display: none;">
            <h2>Finance Content</h2>
            <button class="btn btn-cokelat" onclick="openFinancePopup()">Tambah Project Finance</button>
            <br>
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Project</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch materials from the database and display them
                    $link = mysqli_connect("localhost", "root", "", "dim");
                    if ($link == false) {
                        die(mysqli_connect_error());
                    }
                    $no = 1;
                    $result = mysqli_query($link, "SELECT * FROM finance");

                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $row['namaproject'] ?></td>
                            <td>
                                <div style="display: inline-block;">

                                    <button class="btn btn-cokelat" onclick="openDetailFinancePopup(<?php echo $row['idfinance']; ?>)">Detail</button>
                                    <button class="btn btn-cokelat" onclick="openUpdateFinancePopup(<?php echo $row['idfinance']; ?>)">Edit</button>
                                    <br>
                                    <form method="post">
                                        <input type="hidden" name="idfinance" value="<?php echo $row['idfinance']; ?>">
                                        <button class="btn btn-cokelat" type="submit" name="deletefinance" onclick="return confirm('Are you sure you want to delete this material?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php $no++; ?>
                    <?php } ?>
                </tbody>
            </table>

            <div id="financeFormPopup" class="popup">
                <div class="popup-content">
                    <span class="close" onclick="closeFinancePopup()">&times;</span>
                    <h2>New Finance Form</h2>
                    <form id="financeForm" action="menu.php" method="post">
                        <div class="form-group">
                            <label for="pendapatanBersih">Nama Project:</label>
                            <input type="text" id="namaproject" name="namaproject" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="pendapatanBersih">Pendapatan Bersih:</label>
                            <input type="text" id="pendapatanBersih" name="pendapatanBersih" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="pendapatanKotor">Pendapatan Kotor:</label>
                            <input type="text" id="pendapatanKotor" name="pendapatanKotor" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="keuntungan">Keuntungan:</label>
                            <input type="text" id="keuntungan" name="keuntungan" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="modal">Modal:</label>
                            <input type="text" id="modal" name="modal" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="pengeluaran">Pengeluaran:</label>
                            <input type="text" id="pengeluaran" name="pengeluaran" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tipePembayaran">Tipe Pembayaran:</label>
                            <input type="text" id="tipePembayaran" name="tipePembayaran" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="biayaPengerjaan">Biaya Pengerjaan:</label>
                            <input type="text" id="biayaPengerjaan" name="biayaPengerjaan" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="biayaPengiriman">Biaya Pengiriman:</label>
                            <input type="text" id="biayaPengiriman" name="biayaPengiriman" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-cokelat" name="submitFinance">Submit Finance</button>
                    </form>
                </div>
            </div>
            <?php
            if (isset($_POST["submitFinance"])) {
                $namaproject = $_POST["namaproject"];
                $pendapatanBersih = $_POST["pendapatanBersih"];
                $pendapatanKotor = $_POST["pendapatanKotor"];
                $keuntungan = $_POST["keuntungan"];
                $modal = $_POST["modal"];
                $pengeluaran = $_POST["pengeluaran"];
                $tipePembayaran = $_POST["tipePembayaran"];
                $biayaPengerjaan = $_POST["biayaPengerjaan"];
                $biayaPengiriman = $_POST["biayaPengiriman"];

                $link = mysqli_connect("localhost", "root", "", "dim");
                if ($link == false) {
                    die(mysqli_connect_error());
                }

                $sql = "INSERT INTO finance (namaproject,pendapatanbersih, pendapatankotor, keuntungan, modal, pengeluaran, tipepembayaran, biayapengerjaan, biayapengiriman) VALUES ('$namaproject','$pendapatanBersih', '$pendapatanKotor', '$keuntungan', '$modal', '$pengeluaran', '$tipePembayaran', '$biayaPengerjaan', '$biayaPengiriman')";

                if (mysqli_query($link, $sql)) {
                    // Redirect after displaying the alert
                    echo '<script>alert("Data finance berhasil ditambahkan!");</script>';

                    echo "<script> location ='menu.php';</script>";
                } else {
                    echo '<script>alert("Error: ' . mysqli_error($link) . '");</script>';
                    // Redirect after displaying the alert
                    echo "<script> location ='menu.php';</script>";
                }
            }
            if (isset($_POST["deletefinance"])) {
                $idfinance = $_POST["idfinance"];
                $link = mysqli_connect("localhost", "root", "", "dim");
                if ($link == false) {
                    die(mysqli_connect_error());
                }

                $sql = "DELETE FROM finance WHERE idfinance=$idfinance";
                if (mysqli_query($link, $sql)) {
                    echo '<script>alert("Material deleted successfully!");</script>';
                    // Redirect after displaying the alert
                    echo "<script> location ='menu.php';</script>";
                } else {
                    echo '<script>alert("Error: ' . mysqli_error($link) . '");</script>';
                    // Redirect after displaying the alert
                    echo "<script> location ='menu.php';</script>";
                }
            }

            mysqli_close($link);
            ?>
            <div id="updateFinanceFormPopup" class="popup">
                <div class="popup-content">
                    <span class="close" onclick="closeUpdateFinancePopup()">&times;</span>
                    <h2>Update Finance Form</h2>
                    <form id="updatefinanceForm" action="menu.php" method="post">
                        <input type="hidden" id="idfinance" name="idfinance" value="">
                        <div class="form-group">
                            <label for="namaproject">Nama Project:</label>
                            <input type="text" id="updatenamaproject" name="updatenamaproject" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="pendapatanBersih">Pendapatan Bersih:</label>
                            <input type="text" id="updatependapatanBersih" name="updatependapatanBersih" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="pendapatanKotor">Pendapatan Kotor:</label>
                            <input type="text" id="updatependapatanKotor" name="updatependapatanKotor" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="keuntungan">Keuntungan:</label>
                            <input type="text" id="updatekeuntungan" name="updatekeuntungan" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="modal">Modal:</label>
                            <input type="text" id="updatemodal" name="updatemodal" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="pengeluaran">Pengeluaran:</label>
                            <input type="text" id="updatepengeluaran" name="updatepengeluaran" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tipePembayaran">Tipe Pembayaran:</label>
                            <input type="text" id="updatetipePembayaran" name="updatetipePembayaran" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="biayaPengerjaan">Biaya Pengerjaan:</label>
                            <input type="text" id="updatebiayaPengerjaan" name="updatebiayaPengerjaan" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="biayaPengiriman">Biaya Pengiriman:</label>
                            <input type="text" id="updatebiayaPengiriman" name="updatebiayaPengiriman" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-cokelat" name="updatesubmitFinance">Submit Finance</button>
                    </form>
                </div>
            </div>
            <?php
            if (isset($_POST["updatesubmitFinance"])) {
                $idfinance = $_POST['idfinance'];
                $namaproject = $_POST["updatenamaproject"];
                $pendapatanBersih = $_POST["updatependapatanBersih"];
                $pendapatanKotor = $_POST["updatependapatanKotor"];
                $keuntungan = $_POST["updatekeuntungan"];
                $modal = $_POST["updatemodal"];
                $pengeluaran = $_POST["updatepengeluaran"];
                $tipePembayaran = $_POST["updatetipePembayaran"];
                $biayaPengerjaan = $_POST["updatebiayaPengerjaan"];
                $biayaPengiriman = $_POST["updatebiayaPengiriman"];

                $link = mysqli_connect("localhost", "root", "", "dim");
                if ($link == false) {
                    die(mysqli_connect_error());
                }

                $sql = "UPDATE finance 
                        SET namaproject='$namaproject', 
                            pendapatanbersih='$pendapatanBersih', 
                            pendapatankotor='$pendapatanKotor', 
                            keuntungan='$keuntungan', 
                            modal='$modal', 
                            pengeluaran='$pengeluaran', 
                            tipepembayaran='$tipePembayaran', 
                            biayapengerjaan='$biayaPengerjaan', 
                            biayapengiriman='$biayaPengiriman' 
                        WHERE idfinance=$idfinance";

                if (mysqli_query($link, $sql)) {
                    // Redirect after displaying the alert
                    echo '<script>alert("Data finance berhasil diubah!");</script>';

                    echo "<script> location ='menu.php';</script>";
                } else {
                    echo '<script>alert("Error: ' . mysqli_error($link) . '");</script>';
                    // Redirect after displaying the alert
                    echo "<script> location ='menu.php';</script>";
                }

                mysqli_close($link);
            }
            ?>

            <div id="detailFinanceFormPopup" class="popup">
                <div class="popup-content">
                    <span class="close" onclick="closeDetailFinancePopup()">&times;</span>
                    <h2 id="detailnamaproject">Finance Detail</h2>
                    <table>
                        <tr>
                            <th align="left">Pendapatan Bersih</th>
                            <td>: <span id="detailpendapatanBersih"></span></td>
                        </tr>
                        <tr>
                            <th align="left">Pendapatan Kotor</th>
                            <td>: <span id="detailpendapatanKotor"></span></td>
                        </tr>
                        <tr>
                            <th align="left">Keuntungan</th>
                            <td>: <span id="detailkeuntungan"></span></td>
                        </tr>
                        <tr>
                            <th align="left">Modal</th>
                            <td>: <span id="detailmodal"></span></td>
                        </tr>
                        <tr>
                            <th align="left">Pengeluaran</th>
                            <td>: <span id="detailpengeluaran"></span></td>
                        </tr>
                        <tr>
                            <th align="left">Tipe Pembayaran</th>
                            <td>: <span id="detailtipePembayaran"></span></td>
                        </tr>
                        <tr>
                            <th align="left">Biaya Pengerjaan</th>
                            <td>: <span id="detailbiayaPengerjaan"></span></td>
                        </tr>
                        <tr>
                            <th align="left">Biaya Pengiriman</th>
                            <td>: <span id="detailbiayaPengiriman"></span></td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>

    </div>

    <div class="logout-box" onclick="logout()"><i class='bx bx-log-out-circle'></i>Log Out</div>
    </div>

    <script>
        function loadContent(menu) {
            // Sembunyikan semua konten terlebih dahulu
            document.getElementById('overviewContent').style.display = 'none';
            document.getElementById('detailStockContent').style.display = 'none';
            document.getElementById('detailMaterialContent').style.display = 'none';
            document.getElementById('category-contentContent').style.display = 'none';
            document.getElementById('financeContent').style.display = 'none';
            document.getElementById('detailkategori1Content').style.display = 'none';
            document.getElementById('detailkategori2Content').style.display = 'none';
            document.getElementById('detailkategori3Content').style.display = 'none';
            document.getElementById('detailkategori4Content').style.display = 'none';

            // Tampilkan konten yang dipilih
            const contentId = menu + 'Content';
            document.getElementById(contentId).style.display = 'block';
        }

        function openCategoryDetail(categoryName, description, imagePath) {
            // Display category content
            const categoryContent = document.getElementById('categoryContent');
            categoryContent.style.display = 'block';

            // Show details in the category content
            const categoryDetail = document.getElementById('categoryDetail');
            categoryDetail.innerHTML = `
        <h2>${categoryName}</h2>
        <p>${description}</p>
        <img src="${imagePath}" alt="${categoryName}">
    `;
        }

        function toggleCategoryContent() {
            // Toggle the visibility of category content
            const categoryContent = document.getElementById('categoryContent');
            categoryContent.style.display = categoryContent.style.display === 'none' ? 'block' : 'none';
        }

        // Add an event listener to the category content toggle button
        document.getElementById('toggleCategoryBtn').addEventListener('click', toggleCategoryContent);


        function loadCategoryContent() {
            const categories = [{
                    name: 'Kitchen',
                    image: 'kitchen.jpeg',
                    description: 'Kitchen description goes here.'
                },
                {
                    name: 'Bed Room',
                    image: 'bedroom.jpeg',
                    description: 'Bedroom description goes here.'
                },
                {
                    name: 'Wardrobe',
                    image: 'wardrobe.jpeg',
                    description: 'Wardrobe description goes here.'
                },
                {
                    name: 'Livingroom',
                    image: 'livingroom.jpeg',
                    description: 'Livingroom description goes here.'
                }
            ];

            const categoryContent = document.getElementById('categoryContent');
            categoryContent.innerHTML = ''; // Clear existing content

            categories.forEach(category => {
                const categoryItem = document.createElement('div');
                categoryItem.classList.add('category-item');

                const square = document.createElement('div');
                square.classList.add('square');

                const img = document.createElement('img');
                img.src = category.image;
                img.alt = `Category ${category.name}`;

                const imageText = document.createElement('p');
                imageText.classList.add('image-text');
                imageText.textContent = category.name;

                square.appendChild(img);
                categoryItem.appendChild(square);
                categoryItem.appendChild(imageText);

                // Add an event listener to open the category detail when clicked
                categoryItem.addEventListener('click', function() {
                    openCategoryDetail(category.name, category.description, category.image);
                });

                categoryContent.appendChild(categoryItem);
            });
        }



        function logout() {
            window.location.href = 'login.php';
        }

        document.getElementById('newCustomerBtn').addEventListener('click', openCustomerPopup);

        function openCustomerPopup() {
            var popup = document.getElementById('newCustomerPopup');
            popup.style.display = 'block';
        }

        function closeCustomerPopup() {
            var popup = document.getElementById('newCustomerPopup');
            popup.style.display = 'none';
        }

        function openNewStockPopup() {
            document.getElementById('newStockPopup').style.display = 'flex';
        }

        function closeNewStockPopup() {
            document.getElementById('newStockPopup').style.display = 'none';
        }

        function submitNewStock() {
            // Add logic to handle new stock submission
            console.log("New stock submitted!");
            // Close the pop-up after submission
            closeNewStockPopup();
        }

        function openMaterialPopup() {
            document.getElementById('newMaterialPopup').style.display = 'flex';
        }

        function closeMaterialPopup() {
            document.getElementById('newMaterialPopup').style.display = 'none';
        }

        function openUpdateMaterialPopup(materialID, materialName) {
            document.getElementById('updateMaterialID').value = materialID;
            document.getElementById('updateMaterialName').value = materialName;
            document.getElementById('updateMaterialPopup').style.display = 'flex';
        }

        // Function to close the update material popup
        function closeUpdateMaterialPopup() {
            document.getElementById('updateMaterialPopup').style.display = 'none';
        }

        function openFinancePopup() {
            document.getElementById('financeFormPopup').style.display = 'flex';
        }

        function closeFinancePopup() {
            document.getElementById('financeFormPopup').style.display = 'none';
        }

        function openUpdateFinancePopup(idfinance) {
            // Menggunakan AJAX untuk mengambil data dari server
            $.ajax({
                type: 'POST',
                url: 'get_finance_data.php', // Ganti dengan URL yang sesuai
                data: {
                    idfinance: idfinance
                },
                success: function(response) {
                    // Response berisi data dari server, parse JSON jika perlu
                    var data = JSON.parse(response);

                    // Set nilai-nilai ke dalam input fields
                    document.getElementById('idfinance').value = data.idfinance;
                    document.getElementById('updatenamaproject').value = data.namaproject;
                    document.getElementById('updatependapatanBersih').value = data.pendapatanbersih;
                    document.getElementById('updatependapatanKotor').value = data.pendapatankotor;
                    document.getElementById('updatekeuntungan').value = data.keuntungan;
                    document.getElementById('updatemodal').value = data.modal;
                    document.getElementById('updatepengeluaran').value = data.pengeluaran;
                    document.getElementById('updatetipePembayaran').value = data.tipepembayaran;
                    document.getElementById('updatebiayaPengerjaan').value = data.biayapengerjaan;
                    document.getElementById('updatebiayaPengiriman').value = data.biayapengiriman;

                    // Tampilkan formulir update
                    document.getElementById('updateFinanceFormPopup').style.display = 'flex';
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }


        function closeUpdateFinancePopup() {
            document.getElementById('updateFinanceFormPopup').style.display = 'none';
        }

        function openDetailFinancePopup(idfinance) {
            // Menggunakan AJAX untuk mengambil data dari server
            $.ajax({
                type: 'POST',
                url: 'get_finance_data.php', // Ganti dengan URL yang sesuai
                data: {
                    idfinance: idfinance
                },
                success: function(response) {
                    // Response berisi data dari server, parse JSON jika perlu
                    var data = JSON.parse(response);

                    function formatRupiah(number) {
                        return new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(number);
                    }
                    // Set nilai-nilai ke dalam input fields
                    document.getElementById('detailnamaproject').innerText = data.namaproject;
                    document.getElementById('detailpendapatanBersih').innerText = formatRupiah(data.pendapatanbersih);
                    document.getElementById('detailpendapatanKotor').innerText = formatRupiah(data.pendapatankotor);
                    document.getElementById('detailkeuntungan').innerText = formatRupiah(data.keuntungan);
                    document.getElementById('detailmodal').innerText = formatRupiah(data.modal);
                    document.getElementById('detailpengeluaran').innerText = formatRupiah(data.pengeluaran);
                    document.getElementById('detailtipePembayaran').innerText = data.tipepembayaran;
                    document.getElementById('detailbiayaPengerjaan').innerText = formatRupiah(data.biayapengerjaan);
                    document.getElementById('detailbiayaPengiriman').innerText = formatRupiah(data.biayapengiriman);

                    document.getElementById('detailFinanceFormPopup').style.display = 'flex';
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }


        function closeDetailFinancePopup() {
            document.getElementById('detailFinanceFormPopup').style.display = 'none';
        }


        function addNewMaterial() {
            const materialName = document.getElementById('materialName').value;

            // Perform validation if needed
            if (!materialName) {
                alert("Please enter material name");
                return;
            }

            // Create a FormData object to send the data to the server
            const formData = new FormData();
            formData.append('materialName', materialName);

            // Send a POST request to the server-side script (menu.php) to insert the material into the database
            fetch('menu.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Handle success, e.g., close the popup or update the UI
                        closePopup();
                        console.log('Material added successfully!');
                    } else {
                        // Handle the error case
                        console.error('Error:', data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }


        function openCategoryDetail(categoryName, description, imagePath) {
            alert('Category: ' + categoryName + '\nDescription: ' + description + '\nImage: ' + imagePath);
        }

        document.getElementById('newCustomerForm').addEventListener('submit', function(e) {
            e.preventDefault();

            fetch('menu.php', {
                    method: 'POST',
                    body: new FormData(document.getElementById('newCustomerForm'))
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Update customer detail box with the received data
                        const customerDetailBox = document.getElementById('customerDetailBox');
                        customerDetailBox.innerHTML = `
    <h2>Customer Detail</h2>
    <p>First Name: ${data.firstName}</p>
    <p>Last Name: ${data.lastName}</p>
    <p>Email: ${data.email}</p>
    <p>Phone: ${data.phone}</p>
    <p>City: ${data.city}</p>
    <p>Street Home: ${data.streetHome}</p>
    <p>Postal Code: ${data.postCode}</p>
    <p>House Number: ${data.houseNumber}</p>
    <!-- Add more details as needed -->
    `;

                        // Append the customer detail box to the overview content
                        contentDiv.innerHTML = `
    <div class="customer-detail-content">
        <div class="customer-box">
            ${customerDetailBox.innerHTML}
        </div>
        <div class="customer-box">
            <!-- Add another customer detail box if needed -->
        </div>
    </div>
    <div class="new-customer" onclick="openPopup()">
        <h2>New Customer</h2>
        <p>Add new customer content here.</p>
    </div>
    <div class="delete">
        <h2>Delete</h2>
        <p>Delete customer content here.</p>
    </div>
    `;

                        // Close the popup
                        closePopup();
                    } else {
                        // Handle the error case
                        console.error('Error:', data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</body>

</html>